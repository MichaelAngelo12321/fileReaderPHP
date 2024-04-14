<?php

namespace src\Models;

use src\Interfaces\FileReaderInterface;

class UnixLineEndingFileReader implements FileReaderInterface
{
    private $fileReader;

    public function __construct(FileReaderInterface $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    public function openFile(string $filePath): bool
    {
        return $this->fileReader->openFile($filePath);
    }

    public function readLine(): ?string
    {
        $line = $this->fileReader->readLine();

        if ($line !== null) {
            $line = str_replace("\r\n", "\n", $line);
            $line = str_replace("\r", "\n", $line);
        }

        return $line;
    }

    public function closeFile(): void
    {
        $this->fileReader->closeFile();
    }
}