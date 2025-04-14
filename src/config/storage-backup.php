<?php

return [
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
    'scheduling' => [
        'enabled' => env('STORAGE_BACKUP_SCHEDULING_ENABLED', false),
        'frequency' => env('STORAGE_BACKUP_SCHEDULING_FREQUENCY', 'daily'),
        'time' => env('STORAGE_BACKUP_SCHEDULING_TIME', '00:00'),
        'day' => env('STORAGE_BACKUP_SCHEDULING_DAY', 'monday'),
    ],
    'cleanup' => [
        'enabled' => env('STORAGE_BACKUP_CLEANUP_ENABLED', false),
        'keep_last' => env('STORAGE_BACKUP_CLEANUP_KEEP_LAST', 10),
        'keep_days' => env('STORAGE_BACKUP_CLEANUP_KEEP_DAYS', 30),
        'keep_size' => env('STORAGE_BACKUP_CLEANUP_KEEP_SIZE', '10GB'),
    ],
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
]; 