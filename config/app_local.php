<?php
/*
 * Local configuration file for Rudransh's CESS Portal
 */
return [
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),

    'Security' => [
        'salt' => env('SECURITY_SALT', 'cbb99b60aac4db4deebfb00252fc9ee6c863f1b237c424b86724836fc4ff4366'),
    ],

    /*
     * MERGED EMAIL TRANSPORTS
     */
    'EmailTransport' => [
        'gmail' => [
            'className' => 'Smtp',
            'host' => env('EMAIL_HOST', 'smtp.gmail.com'),
            'port' => env('EMAIL_PORT', 587),
            'timeout' => 30,
            'username' => env('EMAIL_USERNAME'),
            'password' => env('EMAIL_APP_PASSWORD'),
            'client' => null,
            'tls' => filter_var(env('EMAIL_TLS', true), FILTER_VALIDATE_BOOLEAN),
        ],
        'default' => [
            'className' => 'Smtp',
            'host' => env('EMAIL_HOST', 'smtp.gmail.com'),
            'port' => env('EMAIL_PORT', 587),
            'username' => env('EMAIL_USERNAME'),
            'password' => env('EMAIL_PASSWORD'),
            'tls' => filter_var(env('EMAIL_TLS', true), FILTER_VALIDATE_BOOLEAN),
        ],
    ],

    

    'Email' => [
        'default' => [
            'transport' => 'gmail',
            'from' => [
                env('EMAIL_FROM_ADDRESS', 'no-reply@example.com') => env('EMAIL_FROM_NAME', 'Cess Portal')
            ],
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
        ],
    ],

    /*
     * MSG91 CONFIGURATION (Top Level)
     */
    'msg91' => [
        'auth_key' => env('MSG91_AUTH_KEY'), 
        'template_id' => env('MSG91_TEMPLATE_ID'),
        'base_url' => env('MSG91_BASE_URL', 'https://api.msg91.com/api/v5/otp'),
    ],

    'Bindings' => [
        'SMSProvider' => \App\Services\Msg91SMSProvider::class,
        'EmailProvider' => \App\Services\GmailEmailProvider::class,
    ],

    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Postgres',
            'persistent' => false,
            'host' => env('DB_HOST', 'localhost'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'postgres'),
            'database' => env('DB_DATABASE', 'cess'),
            'schema' => 'public',
            'timezone' => 'UTC',
            'encoding' => 'utf8',
            'log' => filter_var(env('DB_LOG', false), FILTER_VALIDATE_BOOLEAN),
        ],
        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Postgres',
            'persistent' => false,
            'host' => env('TEST_DB_HOST', 'localhost'),
            'username' => env('TEST_DB_USERNAME', 'postgres'),
            'password' => env('TEST_DB_PASSWORD', 'postgres'),
            'database' => env('TEST_DB_DATABASE', 'test_myapp'),
            'schema' => 'public',
            'timezone' => 'UTC',
            'encoding' => 'utf8',
            'log' => false,
        ],
    ],

    'SECRET_KEY' => env('APP_SECRET_KEY', 'c5452404eb46b4dbfb669165c61efa20c7f1074705c7fa01ab74e1a80c9490c8'),
];
