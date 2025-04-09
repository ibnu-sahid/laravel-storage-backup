<?php

namespace IbnuSahid\StorageBackup;

use ZipArchive;
use Illuminate\Support\Facades\Storage;

class BackupManager
{
    public function backupStorage($destinationPath = null)
    {
        $zip = new ZipArchive;
        $backupPath = $destinationPath ?? storage_path('app/backup/storage_' . now()->format('Ymd_His') . '.zip');

        $storagePath = storage_path();
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($storagePath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        if ($zip->open($backupPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($storagePath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
        }

        return $backupPath;
    }
}
