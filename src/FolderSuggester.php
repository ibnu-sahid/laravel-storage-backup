<?php

namespace IbnuSahid\StorageBackup;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class FolderSuggester
{
    private array $config;

    public function __construct()
    {
        $this->config = Config::get('storage-backup.suggestions');
    }

    public function suggest(): array
    {
        $suggestions = [];

        if ($this->config['recent']['enabled']) {
            $suggestions = array_merge($suggestions, $this->getRecentFolders());
        }

        if ($this->config['size']['enabled']) {
            $suggestions = array_merge($suggestions, $this->getLargeFolders());
        }

        if ($this->config['type']['enabled']) {
            $suggestions = array_merge($suggestions, $this->getTypedFolders());
        }

        if ($this->config['critical']['enabled']) {
            $suggestions = array_merge($suggestions, $this->getCriticalFolders());
        }

        if ($this->config['patterns']['enabled']) {
            $suggestions = array_merge($suggestions, $this->getPatternFolders());
        }

        if ($this->config['permissions']['enabled']) {
            $suggestions = array_merge($suggestions, $this->getPermissionFolders());
        }

        if ($this->config['metadata']['enabled']) {
            $suggestions = array_merge($suggestions, $this->getMetadataFolders());
        }

        return array_unique($suggestions);
    }

    private function getRecentFolders(): array
    {
        $folders = [];
        $days = $this->config['recent']['days'];
        $storagePath = storage_path('app');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            $modified = $file->getMTime();
            if ($modified > (time() - ($days * 24 * 60 * 60))) {
                $folders[] = dirname($file->getPathname());
            }
        }

        return array_unique($folders);
    }

    private function getLargeFolders(): array
    {
        $folders = [];
        $minSize = $this->config['size']['min_size'];
        $storagePath = storage_path('app');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            $size = $file->getSize();
            if ($size > $this->parseSize($minSize)) {
                $folders[] = dirname($file->getPathname());
            }
        }

        return array_unique($folders);
    }

    private function getTypedFolders(): array
    {
        $folders = [];
        $types = $this->config['type']['types'];
        $storagePath = storage_path('app');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            $extension = $file->getExtension();
            foreach ($types as $type => $extensions) {
                if (in_array($extension, $extensions)) {
                    $folders[] = dirname($file->getPathname());
                }
            }
        }

        return array_unique($folders);
    }

    private function getCriticalFolders(): array
    {
        return $this->config['critical']['folders'];
    }

    private function getPatternFolders(): array
    {
        $folders = [];
        $names = $this->config['patterns']['names'];
        $storagePath = storage_path('app');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            $path = $file->getPathname();
            foreach ($names as $name) {
                if (strpos($path, $name) !== false) {
                    $folders[] = dirname($path);
                }
            }
        }

        return array_unique($folders);
    }

    private function getPermissionFolders(): array
    {
        $folders = [];
        $permissions = $this->config['permissions']['permissions'];
        $storagePath = storage_path('app');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            if ($permissions['writable'] && $file->isWritable()) {
                $folders[] = dirname($file->getPathname());
            }

            if ($permissions['system'] && $this->isSystemFile($file)) {
                $folders[] = dirname($file->getPathname());
            }
        }

        return array_unique($folders);
    }

    private function getMetadataFolders(): array
    {
        $folders = [];
        $metadata = $this->config['metadata'];
        $storagePath = storage_path('app');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            if ($metadata['access'] && $file->getATime() > (time() - (24 * 60 * 60))) {
                $folders[] = dirname($file->getPathname());
            }

            if ($metadata['modification'] && $file->getMTime() > (time() - (24 * 60 * 60))) {
                $folders[] = dirname($file->getPathname());
            }

            if ($metadata['importance'] && $this->isImportantFile($file)) {
                $folders[] = dirname($file->getPathname());
            }
        }

        return array_unique($folders);
    }

    private function parseSize(string $size): int
    {
        $units = ['B' => 1, 'KB' => 1024, 'MB' => 1024 * 1024, 'GB' => 1024 * 1024 * 1024];
        $size = strtoupper($size);
        $unit = substr($size, -2);
        $number = substr($size, 0, -2);

        if (!isset($units[$unit])) {
            $unit = substr($size, -1);
            $number = substr($size, 0, -1);
        }

        return $number * $units[$unit];
    }

    private function isSystemFile(SplFileInfo $file): bool
    {
        $systemFiles = ['.git', '.env', 'composer.json', 'composer.lock', 'package.json', 'package-lock.json'];
        return in_array($file->getFilename(), $systemFiles);
    }

    private function isImportantFile(SplFileInfo $file): bool
    {
        $importantExtensions = ['php', 'js', 'css', 'html', 'json', 'yml', 'yaml', 'ini', 'env'];
        return in_array($file->getExtension(), $importantExtensions);
    }
} 