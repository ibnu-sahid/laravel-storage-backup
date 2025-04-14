<?php

namespace IbnuSahid\StorageBackup;

use Illuminate\Support\ServiceProvider;
use IbnuSahid\StorageBackup\Console\BackupStorageCommand;
use IbnuSahid\StorageBackup\Console\ScheduleBackupCommand;
use IbnuSahid\StorageBackup\Console\CleanBackupCommand;

class StorageBackupServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('storage-backup', function () {
            return new BackupManager();
        });

        $this->app->singleton('folder-suggester', function () {
            return new FolderSuggester();
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BackupStorageCommand::class,
                ScheduleBackupCommand::class,
                CleanBackupCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/config/storage-backup.php' => config_path('storage-backup.php'),
            ], 'config');
        }
    }
}
