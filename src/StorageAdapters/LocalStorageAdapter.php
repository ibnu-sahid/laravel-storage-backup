<?php

namespace IbnuSahid\StorageBackup\StorageAdapters;

use Illuminate\Support\Facades\Storage;

class LocalStorageAdapter implements StorageAdapter
{
    public function store(string $sourcePath, string $destinationPath): bool
    {
        return Storage::disk('local')->put($destinationPath, file_get_contents($sourcePath));
    }

    public function retrieve(string $path): string
    {
        return Storage::disk('local')->get($path);
    }

    public function delete(string $path): bool
    {
        return Storage::disk('local')->delete($path);
    }

    public function list(string $path): array
    {
        return Storage::disk('local')->files($path);
    }

    public function exists(string $path): bool
    {
        return Storage::disk('local')->exists($path);
    }
} 