# Storage Backup 📦

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ibnu-sahid/laravel-storage-backup.svg?style=flat-square)](https://packagist.org/packages/ibnu-sahid/laravel-storage-backup)
[![Total Downloads](https://img.shields.io/packagist/dt/ibnu-sahid/laravel-storage-backup.svg?style=flat-square)](https://packagist.org/packages/ibnu-sahid/laravel-storage-backup)
[![License](https://img.shields.io/packagist/l/ibnu-sahid/laravel-storage-backup.svg?style=flat-square)](https://packagist.org/packages/ibnu-sahid/laravel-storage-backup)

This package allows you to backup folders to different types of storage.

## 🚀 Installation

```bash
composer require ibnu-sahid/laravel-storage-backup
```

## ⚙️ Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="IbnuSahid\StorageBackup\StorageBackupServiceProvider" --tag="config"
```

## 📋 Usage

### 🔄 Simple Backup

```bash
php artisan storage:backup
```

### 📁 Backup with specific folders

```bash
php artisan storage:backup --folders=public --folders=app
```

### 💾 Backup with specific storage type

```bash
php artisan storage:backup --storage=s3
```

### ⏰ Scheduled Backup

```bash
php artisan storage:backup:schedule --frequency=daily --time=00:00
```

### 🧹 Cleanup Backups

```bash
php artisan storage:backup:clean --keep-last=10
```

### 💡 Folder Suggestions

```bash
php artisan storage:backup --suggest
```

## 🔧 Options

### 🔄 Backup

| Option | Description |
|--------|-------------|
| `--folders` | List of folders to backup |
| `--storage` | Storage type to use (local, s3, ftp, sftp, gcs, azure) |
| `--schedule` | Enable scheduling |
| `--frequency` | Backup frequency (hourly, daily, weekly, monthly) |
| `--time` | Time for daily/weekly/monthly backup |
| `--day` | Day for weekly/monthly backup |
| `--keep-last` | Number of backups to keep |
| `--keep-days` | Number of days to keep backups |
| `--keep-size` | Maximum size of backups to keep |
| `--suggest` | Show folder suggestions |

### ⏰ Schedule

| Option | Description |
|--------|-------------|
| `--folders` | List of folders to backup |
| `--storage` | Storage type to use (local, s3, ftp, sftp, gcs, azure) |
| `--frequency` | Backup frequency (hourly, daily, weekly, monthly) |
| `--time` | Time for daily/weekly/monthly backup |
| `--day` | Day for weekly/monthly backup |
| `--keep-last` | Number of backups to keep |
| `--keep-days` | Number of days to keep backups |
| `--keep-size` | Maximum size of backups to keep |

### 🧹 Clean

| Option | Description |
|--------|-------------|
| `--keep-last` | Number of backups to keep |
| `--keep-days` | Number of days to keep backups |
| `--keep-size` | Maximum size of backups to keep |
| `--storage` | Storage type to use (local, s3, ftp, sftp, gcs, azure) |

## ⚙️ Configuration

### 💾 Storage

```php
'default_storage' => env('STORAGE_BACKUP_DEFAULT_STORAGE', 'local'),
'storages' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app/backups'),
    ],
    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    ],
    'ftp' => [
        'driver' => 'ftp',
        'host' => env('FTP_HOST'),
        'username' => env('FTP_USERNAME'),
        'password' => env('FTP_PASSWORD'),
        'port' => env('FTP_PORT', 21),
        'root' => env('FTP_ROOT', ''),
        'passive' => env('FTP_PASSIVE', true),
        'ssl' => env('FTP_SSL', false),
        'timeout' => env('FTP_TIMEOUT', 30),
    ],
    'sftp' => [
        'driver' => 'sftp',
        'host' => env('SFTP_HOST'),
        'username' => env('SFTP_USERNAME'),
        'password' => env('SFTP_PASSWORD'),
        'port' => env('SFTP_PORT', 22),
        'root' => env('SFTP_ROOT', ''),
        'timeout' => env('SFTP_TIMEOUT', 30),
        'privateKey' => env('SFTP_PRIVATE_KEY'),
        'passphrase' => env('SFTP_PASSPHRASE'),
    ],
    'gcs' => [
        'driver' => 'gcs',
        'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'),
        'key_file' => env('GOOGLE_CLOUD_KEY_FILE'),
        'bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET'),
        'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX'),
        'storage_api_uri' => env('GOOGLE_CLOUD_STORAGE_API_URI'),
    ],
    'azure' => [
        'driver' => 'azure',
        'name' => env('AZURE_STORAGE_NAME'),
        'key' => env('AZURE_STORAGE_KEY'),
        'container' => env('AZURE_STORAGE_CONTAINER'),
        'url' => env('AZURE_STORAGE_URL'),
        'prefix' => env('AZURE_STORAGE_PREFIX'),
    ],
],
```

### ⏰ Scheduling

```php
'scheduling' => [
    'enabled' => env('STORAGE_BACKUP_SCHEDULING_ENABLED', false),
    'frequency' => env('STORAGE_BACKUP_SCHEDULING_FREQUENCY', 'daily'),
    'time' => env('STORAGE_BACKUP_SCHEDULING_TIME', '00:00'),
    'day' => env('STORAGE_BACKUP_SCHEDULING_DAY', 'monday'),
],
```

### 🧹 Cleanup

```php
'cleanup' => [
    'enabled' => env('STORAGE_BACKUP_CLEANUP_ENABLED', false),
    'keep_last' => env('STORAGE_BACKUP_CLEANUP_KEEP_LAST', 10),
    'keep_days' => env('STORAGE_BACKUP_CLEANUP_KEEP_DAYS', 30),
    'keep_size' => env('STORAGE_BACKUP_CLEANUP_KEEP_SIZE', '10GB'),
],
```

### 💡 Suggestions

```php
'suggestions' => [
    'recent' => [
        'enabled' => env('STORAGE_BACKUP_SUGGESTIONS_RECENT_ENABLED', true),
        'days' => env('STORAGE_BACKUP_SUGGESTIONS_RECENT_DAYS', 7),
    ],
    'size' => [
        'enabled' => env('STORAGE_BACKUP_SUGGESTIONS_SIZE_ENABLED', true),
        'min_size' => env('STORAGE_BACKUP_SUGGESTIONS_SIZE_MIN', '100MB'),
    ],
    'type' => [
        'enabled' => env('STORAGE_BACKUP_SUGGESTIONS_TYPE_ENABLED', true),
        'types' => [
            'images' => ['jpg', 'jpeg', 'png', 'gif'],
            'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
            'media' => ['mp3', 'mp4', 'avi', 'mov'],
            'config' => ['json', 'yml', 'yaml', 'ini'],
        ],
    ],
    'critical' => [
        'enabled' => env('STORAGE_BACKUP_SUGGESTIONS_CRITICAL_ENABLED', true),
        'folders' => [
            'storage/framework',
            'storage/logs',
            'storage/cache',
            'public/uploads',
        ],
    ],
    'patterns' => [
        'enabled' => env('STORAGE_BACKUP_SUGGESTIONS_PATTERNS_ENABLED', true),
        'names' => [
            'uploads',
            'media',
            'documents',
        ],
    ],
    'permissions' => [
        'enabled' => env('STORAGE_BACKUP_SUGGESTIONS_PERMISSIONS_ENABLED', true),
        'permissions' => [
            'writable' => true,
            'system' => true,
        ],
    ],
    'metadata' => [
        'enabled' => env('STORAGE_BACKUP_SUGGESTIONS_METADATA_ENABLED', true),
        'access' => true,
        'modification' => true,
        'importance' => true,
    ],
],
```

## 📝 TODO

- [ ] Implement pattern detection in folder names
- [ ] Add unit and integration tests
- [ ] Improve documentation with advanced usage examples
- [ ] Add support for additional storage types
  - [ ] Dropbox
  - [ ] OneDrive
- [ ] Implement backup compression
- [ ] Add backup restoration functionality

---

## 👨‍💻 Author

_Developed by [Ibnu Sahid](https://github.com/ibnu-sahid/)_

_Contributors: [martin-lechene](https://github.com/martin-lechene/)_
