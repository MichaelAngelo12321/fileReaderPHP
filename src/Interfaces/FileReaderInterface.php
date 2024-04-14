<?php

namespace src\Interfaces;

interface FileReaderInterface
{
    public function openFile(string $filePath): bool;
    public function readLine(): ?string;
    public function closeFile(): void;
}