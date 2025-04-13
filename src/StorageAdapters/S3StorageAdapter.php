<?php

namespace IbnuSahid\StorageBackup\StorageAdapters;

use Illuminate\Support\Facades\Storage;

class S3StorageAdapter implements StorageAdapter
{
    public function store(string $sourcePath, string $destinationPath): bool
    {
        return Storage::disk('s3')->put($destinationPath, file_get_contents($sourcePath));
    }

    public function retrieve(string $path): string
    {
        return Storage::disk('s3')->get($path);
    }

    public function delete(string $path): bool
    {
        return Storage::disk('s3')->delete($path);
    }

    public function list(string $path): array
    {
        return Storage::disk('s3')->files($path);
    }

    public function exists(string $path): bool
    {
        return Storage::disk('s3')->exists($path);
    }
} 