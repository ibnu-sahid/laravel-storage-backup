<?php

namespace IbnuSahid\StorageBackup\StorageAdapters;

use Illuminate\Support\Facades\Storage;

class FTPStorageAdapter implements StorageAdapter
{
    public function store(string $sourcePath, string $destinationPath): bool
    {
        return Storage::disk('ftp')->put($destinationPath, file_get_contents($sourcePath));
    }

    public function retrieve(string $path): string
    {
        return Storage::disk('ftp')->get($path);
    }

    public function delete(string $path): bool
    {
        return Storage::disk('ftp')->delete($path);
    }

    public function list(string $path): array
    {
        return Storage::disk('ftp')->files($path);
    }

    public function exists(string $path): bool
    {
        return Storage::disk('ftp')->exists($path);
    }
} 