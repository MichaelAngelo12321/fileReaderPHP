<?php

namespace Unit;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use src\Models\TextFileReader;
use src\Models\ProxyFileReader;
use src\Interfaces\FileDownloaderInterface;

class ProxyFileReaderTest extends TestCase
{
    private $reader;
    private $tempFile;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $textFileReader = new TextFileReader();
        $fileDownloader = $this->createMock(FileDownloaderInterface::class);
        $this->reader = new ProxyFileReader($textFileReader, $fileDownloader, 'https://filesamples.com/samples/document/txt/sample1.txt');

        $this->tempFile = tempnam(sys_get_temp_dir(), 'tfr');
        file_put_contents($this->tempFile, "Test line\n");
    }

    protected function tearDown(): void
    {
        if (file_exists($this->tempFile)) {
            unlink($this->tempFile);
        }
    }

    public function testOpenFile()
    {
        $result = $this->reader->openFile($this->tempFile);

        $this->assertTrue($result, 'File should be opened successfully');
        $this->assertFileExists($this->tempFile, 'File should exist after opening');
    }

    public function testReadLine()
    {
        $this->reader->openFile($this->tempFile);
        $line = $this->reader->readLine();

        $this->assertEquals("Test line\n", $line, 'Read line should match the content of the file');
    }

    public function testCloseFile()
    {
        $this->reader->openFile($this->tempFile);
        $this->reader->closeFile();

        $line = $this->reader->readLine();
        $this->assertNull($line, 'No line should be read from a closed file');
    }
}