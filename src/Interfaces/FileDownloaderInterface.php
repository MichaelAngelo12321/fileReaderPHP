<?php

namespace src\Interfaces;

use src\Exceptions\FileDownloadException;

interface FileDownloaderInterface
{
    /**
     * @throws FileDownloadException
     */
    public function downloadFile(string $filePath, string $url): void;
}