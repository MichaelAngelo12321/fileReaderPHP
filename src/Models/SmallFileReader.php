<?php

declare(strict_types=1);

namespace src\Models;

use src\Interfaces\FileReaderInterface;

class SmallFileReader implements FileReaderInterface
{
    private array $fileContent;
    private int $currentLine;

    public function openFile(string $filePath): bool
    {
        if (!file_exists($filePath)) {
            return false;
        }

        $this->fileContent = file($filePath);
        $this->currentLine = 0;

        return true;
    }

    public function readLine(): ?string
    {
        if ($this->fileContent === null || $this->currentLine >= count($this->fileContent)) {
            return null;
        }

        return $this->fileContent[$this->currentLine++];
    }

    public function closeFile(): void
    {
        $this->fileContent = [];
        $this->currentLine = 0;
    }
}