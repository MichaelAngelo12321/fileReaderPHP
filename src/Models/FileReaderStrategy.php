<?php

namespace src\Models;

use src\Interfaces\FileReaderInterface;

class FileReaderStrategy implements FileReaderInterface
{
    private $fileReader;

    public function __construct(string $filePath)
    {
        $fileSize = filesize($filePath);

        if ($fileSize <= 5000000) {
            $this->fileReader = new SmallFileReader();
        } else {
            $this->fileReader = new LargeFileReader();
        }
    }

    public function openFile(string $filePath): bool
    {
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