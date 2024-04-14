<?php

namespace src\Models;

use src\Interfaces\FileReaderInterface;

class TextFileReader implements FileReaderInterface
{

    private $fileHandle;

    public function openFile(string $filePath): bool
    {
        if (!file_exists($filePath)) {
            return false;
        }

        $this->fileHandle = fopen($filePath, 'r');
        return true;
    }

    public function readLine(): ?string
    {
        if (!$this->fileHandle || feof($this->fileHandle)) {
            return null;
        }

        $line = fgets($this->fileHandle);
        return $line === false ? null : $line;
    }

    public function closeFile(): void
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
            $this->fileHandle = null;
        }
    }
}