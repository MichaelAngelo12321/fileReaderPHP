<?php

declare(strict_types=1);

namespace src\Models;

use src\Interfaces\FileReaderInterface;

class FileReaderStrategy implements FileReaderInterface
{
    private FileReaderInterface $fileReader;
    private const FILE_SIZE_LIMIT = 5000000;

    public function __construct(string $filePath)
    {
        $fileSize = filesize($filePath);

        if ($fileSize <= self::FILE_SIZE_LIMIT) {
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