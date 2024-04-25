<?php

declare(strict_types=1);

namespace src\Models;

use src\Interfaces\FileReaderInterface;

class TextFileReader implements FileReaderInterface
{
    private $fileHandle;
    private const FILE_OPEN_MODE = 'r';

    public function openFile(string $filePath): bool
    {
        if (!file_exists($filePath)) {
            return false;
        }

        $this->fileHandle = fopen($filePath, self::FILE_OPEN_MODE);
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