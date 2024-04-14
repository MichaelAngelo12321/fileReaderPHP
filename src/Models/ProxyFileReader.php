<?php

namespace src\Models;

use src\Interfaces\FileReaderInterface;
use src\Interfaces\FileDownloaderInterface;

class ProxyFileReader implements FileReaderInterface
{
    private $fileReader;
    private $remoteUrl;
    private $fileDownloader;

    public function __construct(FileReaderInterface $fileReader, FileDownloaderInterface $fileDownloader, string $remoteUrl)
    {
        $this->fileReader = $fileReader;
        $this->remoteUrl = $remoteUrl;
        $this->fileDownloader = $fileDownloader;
    }

    public function openFile(string $filePath): bool
    {
        if (!file_exists($filePath)) {
            $this->fileDownloader->downloadFile($filePath, $this->remoteUrl);
        }

        return $this->fileReader->openFile($filePath);
    }

    public function readLine(): ?string
    {
        return $this->fileReader->readLine();
    }

    public function closeFile(): void
    {
        $this->fileReader->closeFile();
    }
}