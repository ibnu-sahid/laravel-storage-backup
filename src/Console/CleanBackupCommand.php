<?php

namespace IbnuSahid\StorageBackup\Console;

use Illuminate\Console\Command;
use IbnuSahid\StorageBackup\BackupManager;

class CleanBackupCommand extends Command
{
    protected $signature = 'storage:backup:clean 
        {--keep-last= : Number of backups to keep}
        {--keep-days= : Number of days to keep backups}
        {--keep-size= : Maximum size of backups to keep}
        {--storage=local : Storage type to use (local, s3, ftp, sftp, gcs, azure)}';

    protected $description = 'Clean old backups';

    public function handle(BackupManager $manager)
    {
        $keepLast = $this->option('keep-last');
        $keepDays = $this->option('keep-days');
        $keepSize = $this->option('keep-size');
        $storageType = $this->option('storage');

        if (!$keepLast && !$keepDays && !$keepSize) {
            $this->error('At least one of --keep-last, --keep-days, or --keep-size must be specified');
            return 1;
        }

        $this->info("Cleaning backups with the following rules:");
        if ($keepLast) {
            $this->info("Keeping last $keepLast backups");
        }
        if ($keepDays) {
            $this->info("Keeping backups for $keepDays days");
        }
        if ($keepSize) {
            $this->info("Keeping backups with maximum size of $keepSize");
        }

        return 0;
    }
} 