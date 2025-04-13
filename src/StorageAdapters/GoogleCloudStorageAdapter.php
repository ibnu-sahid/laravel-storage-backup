<?php

namespace IbnuSahid\StorageBackup\StorageAdapters;

use Illuminate\Support\Facades\Storage;

class GoogleCloudStorageAdapter implements StorageAdapter
{
    public function store(string $sourcePath, string $destinationPath): bool
    {
        return Storage::disk('gcs')->put($destinationPath, file_get_contents($sourcePath));
    }

    public function retrieve(string $path): string
    {
        return Storage::disk('gcs')->get($path);
    }

    public function delete(string $path): bool
    {
        return Storage::disk('gcs')->delete($path);
    }

    public function list(string $path): array
    {
        return Storage::disk('gcs')->files($path);
    }

    public function exists(string $path): bool
    {
        return Storage::disk('gcs')->exists($path);
    }
} 