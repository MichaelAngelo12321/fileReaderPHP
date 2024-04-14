<?php

namespace tests\Unit;

use PHPUnit\Framework\TestCase;
use src\Models\TextFileReader;

class TextFileReaderTest extends TestCase
{
    private $reader;
    private $tempFile;

    protected function setUp(): void
    {
        $this->reader = new TextFileReader();
        $this->tempFile = tempnam(sys_get_temp_dir(), 'tfr');

        file_put_contents($this->tempFile, "Test line 1\nTest line 2\nTest line 3\n");
        $this->reader->openFile($this->tempFile);
    }

    protected function tearDown(): void
    {
        unlink($this->tempFile);
    }

    public function testReadLine()
    {
        $line = $this->reader->readLine();
        $this->assertEquals("Test line 1\n", $line, 'First line should be read correctly');

        $line = $this->reader->readLine();
        $this->assertEquals("Test line 2\n", $line, 'Second line should be read correctly');

        $line = $this->reader->readLine();
        $this->assertEquals("Test line 3\n", $line, 'Third line should be read correctly');

        $line = $this->reader->readLine();
        $this->assertNull($line, 'After all lines are read, should return null');
    }
}