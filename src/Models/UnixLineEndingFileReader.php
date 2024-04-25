<?php

declare(strict_types=1);

namespace src\Models;

use src\Interfaces\FileReaderInterface;

class UnixLineEndingFileReader implements FileReaderInterface
{
    private FileReaderInterface $fileReader;
    private const UNIX_LINE_ENDING = "\n";
    private const WINDOWS_LINE_ENDING = "\r\n";
    private const MAC_LINE_ENDING = "\r";

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
            $line = str_replace(self::WINDOWS_LINE_ENDING, self::UNIX_LINE_ENDING, $line);
            $line = str_replace(self::MAC_LINE_ENDING, self::UNIX_LINE_ENDING, $line);
        }

        return $line;
    }

    public function closeFile(): void
    {
        $this->fileReader->closeFile();
    }
}