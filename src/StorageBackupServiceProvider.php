<?php

namespace IbnuSahid\StorageBackup;

use Illuminate\Support\ServiceProvider;

class StorageBackupServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('storage-backup', function () {
            return new BackupManager();
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\BackupStorageCommand::class,
            ]);
        }
    }
}
