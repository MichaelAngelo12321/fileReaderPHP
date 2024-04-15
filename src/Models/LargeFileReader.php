<?php

namespace src\Models;

use RuntimeException;
use src\Interfaces\FileReaderInterface;

class LargeFileReader implements FileReaderInterface
{

    private $fileHandle;

    public function __destruct()
    {
        $this->closeFile();
    }

    public function openFile(string $filePath): bool
    {
        if (!file_exists($filePath)) {
            return false;
        }

        $this->fileHandle = @fopen($filePath, 'r');

        if ($this->fileHandle === false) {
            throw new RuntimeException("Failed to open file: $filePath");
        }

        return true;
    }

    public function readLine(): ?string
    {
        if (!$this->fileHandle) {
            return null;
        }

        $line = @fgets($this->fileHandle);

        if ($line === false) {
            if (feof($this->fileHandle)) {
                return null;
            } else {
                throw new RuntimeException('Failed to read line from file');
            }
        }

        return $line;
    }

    public function closeFile(): void
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
            $this->fileHandle = null;
        }
    }
}