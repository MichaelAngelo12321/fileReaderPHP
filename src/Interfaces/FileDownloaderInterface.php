<?php

namespace src\Interfaces;

interface FileDownloaderInterface
{
    public function downloadFile(string $filePath, string $url): void;
}