<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use src\Models\FileReaderStrategy;

class FileReaderStrategyTest extends TestCase
{
    private $smallFile;
    private $largeFile;

    protected function setUp(): void
    {
        $this->smallFile = tempnam(sys_get_temp_dir(), 'sfr');
        file_put_contents($this->smallFile, "Test line\n");

        $this->largeFile = tempnam(sys_get_temp_dir(), 'lfr');
        file_put_contents($this->largeFile, str_repeat("Test line\n", 1000000));
    }

    protected function tearDown(): void
    {
        if (file_exists($this->smallFile)) {
            unlink($this->smallFile);
        }

        if (file_exists($this->largeFile)) {
            unlink($this->largeFile);
        }
    }

    public function testOpenFile()
    {
        $reader = new FileReaderStrategy($this->smallFile);
        $result = $reader->openFile($this->smallFile);
        $this->assertTrue($result, 'Small file should be opened successfully');

        $reader = new FileReaderStrategy($this->largeFile);
        $result = $reader->openFile($this->largeFile);
        $this->assertTrue($result, 'Large file should be opened successfully');
    }

    public function testReadLine()
    {
        $reader = new FileReaderStrategy($this->smallFile);
        $reader->openFile($this->smallFile);
        $line = $reader->readLine();
        $this->assertEquals("Test line\n", $line, 'Read line should match the content of the small file');

        $reader = new FileReaderStrategy($this->largeFile);
        $reader->openFile($this->largeFile);
        $line = $reader->readLine();
        $this->assertEquals("Test line\n", $line, 'Read line should match the content of the large file');
    }

    public function testCloseFile()
    {
        $reader = new FileReaderStrategy($this->smallFile);
        $reader->openFile($this->smallFile);
        $reader->closeFile();
        $line = $reader->readLine();
        $this->assertNull($line, 'No line should be read from a closed small file');

        $reader = new FileReaderStrategy($this->largeFile);
        $reader->openFile($this->largeFile);
        $reader->closeFile();
        $line = $reader->readLine();
        $this->assertNull($line, 'No line should be read from a closed large file');
    }
}