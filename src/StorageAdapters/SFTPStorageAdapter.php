<?php

namespace IbnuSahid\StorageBackup\StorageAdapters;

use Illuminate\Support\Facades\Storage;

class SFTPStorageAdapter implements StorageAdapter
{
    public function store(string $sourcePath, string $destinationPath): bool
    {
        return Storage::disk('sftp')->put($destinationPath, file_get_contents($sourcePath));
    }

    public function retrieve(string $path): string
    {
        return Storage::disk('sftp')->get($path);
    }

    public function delete(string $path): bool
    {
        return Storage::disk('sftp')->delete($path);
    }

    public function list(string $path): array
    {
        return Storage::disk('sftp')->files($path);
    }

    public function exists(string $path): bool
    {
        return Storage::disk('sftp')->exists($path);
    }
} 