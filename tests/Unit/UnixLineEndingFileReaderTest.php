<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use src\Models\TextFileReader;
use src\Models\UnixLineEndingFileReader;

class UnixLineEndingFileReaderTest extends TestCase
{
    private $reader;
    private $tempFile;

    protected function setUp(): void
    {
        $textFileReader = new TextFileReader();
        $this->reader = new UnixLineEndingFileReader($textFileReader);

        $this->tempFile = tempnam(sys_get_temp_dir(), 'tfr');

        file_put_contents($this->tempFile, "Test line 1\r\nTest line 2\r\nTest line 3\r\n");
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