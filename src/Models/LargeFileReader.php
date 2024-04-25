<?php

declare(strict_types=1);

namespace src\Models;

use RuntimeException;
use src\Interfaces\FileReaderInterface;

class LargeFileReader implements FileReaderInterface
{
    private $fileHandle;
    private const FILE_OPEN_MODE = 'r';
    private const ERROR_MESSAGE_OPEN = "Failed to open file: ";
    private const ERROR_MESSAGE_READ = 'Failed to read line from file';

    public function __destruct()
    {
        $this->closeFile();
    }

    public function openFile(string $filePath): bool
    {
        if (!file_exists($filePath)) {
            return false;
        }

        $this->fileHandle = @fopen($filePath, self::FILE_OPEN_MODE);

        if ($this->fileHandle === false) {
            throw new RuntimeException(self::ERROR_MESSAGE_OPEN . $filePath);
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
                throw new RuntimeException(self::ERROR_MESSAGE_READ);
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