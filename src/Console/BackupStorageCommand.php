<?php

namespace IbnuSahid\StorageBackup\Console;

use Illuminate\Console\Command;

class BackupStorageCommand extends Command
{
    protected $signature = 'storage:backup';
    protected $description = 'Backup storage folder into zip';

    public function handle()
    {
        $manager = app('storage-backup');
        $path = $manager->backupStorage();

        $this->info("Backup created at: $path");
    }
}
