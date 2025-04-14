<?php

namespace IbnuSahid\StorageBackup;

use IbnuSahid\StorageBackup\StorageAdapters\StorageAdapter;
use IbnuSahid\StorageBackup\StorageAdapters\LocalStorageAdapter;
use IbnuSahid\StorageBackup\StorageAdapters\S3StorageAdapter;
use IbnuSahid\StorageBackup\StorageAdapters\FTPStorageAdapter;
use IbnuSahid\StorageBackup\StorageAdapters\SFTPStorageAdapter;
use IbnuSahid\StorageBackup\StorageAdapters\GoogleCloudStorageAdapter;
use IbnuSahid\StorageBackup\StorageAdapters\AzureBlobStorageAdapter;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupManager
{
    private array $adapters = [];

    public function __construct()
    {
        $this->adapters = [
            'local' => new LocalStorageAdapter(),
            's3' => new S3StorageAdapter(),
            'ftp' => new FTPStorageAdapter(),
            'sftp' => new SFTPStorageAdapter(),
            'gcs' => new GoogleCloudStorageAdapter(),
            'azure' => new AzureBlobStorageAdapter(),
        ];
    }

    public function backupStorage(array $folders = [], string $storageType = 'local', string $destinationPath = null): string
    {
        $zip = new ZipArchive();
        $timestamp = now()->format('Ymd_His');
        $filename = "storage_{$timestamp}.zip";
        $backupPath = $destinationPath ?? storage_path("app/{$filename}");

        $backupDir = dirname($backupPath);
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $res = $zip->open($backupPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($res !== true) {
            throw new \Exception("Failed to create ZIP file at $backupPath. Error code: $res");
        }

        $storagePath = storage_path('app');
        $folders = empty($folders) ? [$storagePath] : array_map(function ($folder) use ($storagePath) {
            return $storagePath . '/' . ltrim($folder, '/');
        }, $folders);

        foreach ($folders as $folder) {
            if (!file_exists($folder)) {
                continue;
            }

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($folder),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = ltrim(str_replace($storagePath, '', $filePath), DIRECTORY_SEPARATOR);
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }

        $zip->close();

        if (!isset($this->adapters[$storageType])) {
            throw new \Exception("Storage type $storageType is not supported");
        }

        $adapter = $this->adapters[$storageType];
        $adapter->store($backupPath, $filename);

        return $backupPath;
    }
}
