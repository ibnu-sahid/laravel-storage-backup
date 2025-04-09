<?php

namespace IbnuSahid\StorageBackup;

use ZipArchive;
use Illuminate\Support\Facades\Storage;

class BackupManager
{
    public function backupStorage($destinationPath = null)
    {
    $zip = new \ZipArchive();

    $timestamp = now()->format('Ymd_His');
    $filename = "storage_{$timestamp}.zip";

    $backupPath = $destinationPath ?? storage_path("app/{$filename}");

    // Pastikan folder tujuan ada
    $backupDir = dirname($backupPath);
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0755, true);
    }

    // Coba buka zip file
    $res = $zip->open($backupPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

    if ($res !== true) {
        throw new \Exception("Failed to create ZIP file at $backupPath. Error code: $res");
    }

    $storagePath = storage_path('app');

    $files = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($storagePath),
        \RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = ltrim(str_replace($storagePath, '', $filePath), DIRECTORY_SEPARATOR);
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();

    return $backupPath;
}

}
