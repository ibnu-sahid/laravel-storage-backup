<?php

namespace IbnuSahid\StorageBackup\Console;

use Illuminate\Console\Command;
use IbnuSahid\StorageBackup\BackupManager;
use IbnuSahid\StorageBackup\FolderSuggester;

class BackupStorageCommand extends Command
{
    protected $signature = 'storage:backup 
        {--folders=* : List of folders to backup}
        {--storage=local : Storage type to use (local, s3, ftp, sftp, gcs, azure)}
        {--schedule : Enable scheduling}
        {--frequency= : Frequency of backup (hourly, daily, weekly, monthly)}
        {--time= : Time for daily/weekly/monthly backup}
        {--day= : Day for weekly/monthly backup}
        {--keep-last= : Number of backups to keep}
        {--keep-days= : Number of days to keep backups}
        {--keep-size= : Maximum size of backups to keep}
        {--suggest : Show suggested folders}';

    protected $description = 'Backup storage folder into zip';

    public function handle(BackupManager $manager, FolderSuggester $suggester)
    {
        $folders = $this->option('folders');
        $storageType = $this->option('storage');
        $schedule = $this->option('schedule');
        $frequency = $this->option('frequency');
        $time = $this->option('time');
        $day = $this->option('day');
        $keepLast = $this->option('keep-last');
        $keepDays = $this->option('keep-days');
        $keepSize = $this->option('keep-size');
        $suggest = $this->option('suggest');

        if ($suggest) {
            $suggestions = $suggester->suggest();
            $this->info('Suggested folders:');
            foreach ($suggestions as $suggestion) {
                $this->line("- $suggestion");
            }
            return 0;
        }

        if ($schedule) {
            if (!$frequency) {
                $this->error('Frequency is required when scheduling is enabled');
                return 1;
            }

            if (in_array($frequency, ['daily', 'weekly', 'monthly']) && !$time) {
                $this->error('Time is required for daily, weekly, and monthly backups');
                return 1;
            }

            if (in_array($frequency, ['weekly', 'monthly']) && !$day) {
                $this->error('Day is required for weekly and monthly backups');
                return 1;
            }
        }

        $path = $manager->backupStorage($folders, $storageType);

        $this->info("Backup created at: $path");

        if ($schedule) {
            $this->info("Backup scheduled with frequency: $frequency");
            if ($time) {
                $this->info("Time: $time");
            }
            if ($day) {
                $this->info("Day: $day");
            }
        }

        if ($keepLast || $keepDays || $keepSize) {
            $this->info("Auto-clean enabled");
            if ($keepLast) {
                $this->info("Keeping last $keepLast backups");
            }
            if ($keepDays) {
                $this->info("Keeping backups for $keepDays days");
            }
            if ($keepSize) {
                $this->info("Keeping backups with maximum size of $keepSize");
            }
        }

        return 0;
    }
}
