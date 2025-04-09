# Laravel Storage Backup

A simple Laravel package to back up your application's `storage/app` folder into a ZIP file.

## 🔧 Installation

Require the package using Composer:

```bash
composer require ibnu-sahid/laravel-storage-backup
```

🚀 Usage
Run the Artisan command to create a ZIP backup of the storage/app directory:

```bash
php artisan storage:backup
```

The backup file will be stored in:

```bash
storage/app/backup/storage_YYYYMMDD_HHMMSS.zip
```

Where `YYYYMMDD_HHMMSS` is the timestamp of when the backup was created.

📁 What’s Included?
This command will recursively include all files and folders under storage/app, preserving the folder structure inside the ZIP archive.

🖥 Example
After running:

php artisan storage:backup
You’ll get something like:

```bash
storage/app/backup/storage_20250409_123456.zip
```

And inside the ZIP file, you will find the entire contents of your `storage/app` directory.

❗Requirements
PHP >=8.0

Laravel 9.x or higher

ZipArchive extension enabled (enabled by default in most PHP installations)

🧪 Testing
You can manually test by running the backup command and checking the ZIP file in your storage folder.

📌 TODO
Option to specify custom folder(s) to backup

Option to store backup in other disks (e.g., S3, FTP)

Scheduling support via Laravel Scheduler

Cleanup old backups

🧑‍💻 Author
Developed by Ibnu Sahid
