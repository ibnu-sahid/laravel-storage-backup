<?php

namespace IbnuSahid\StorageBackup\StorageAdapters;

interface StorageAdapter
{
    public function store(string $sourcePath, string $destinationPath): bool;
    public function retrieve(string $path): string;
    public function delete(string $path): bool;
    public function list(string $path): array;
    public function exists(string $path): bool;
} 