<?php return array (
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'concurrency' => 
  array (
    'default' => 'process',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => '12',
      'verify' => true,
      'limit' => NULL,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'D:\\domain\\laravel_13.11\\resources\\views',
    ),
    'compiled' => 'D:\\domain\\laravel_13.11\\storage\\framework\\views',
  ),
  'app' => 
  array (
    'name' => 'AKSI',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://aksireborn.net',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:WCZ6obIzL5685+O2ICGGwHc7z65ZCSSg7VQXRDKoowY=',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      11 => 'Illuminate\\Hashing\\HashServiceProvider',
      12 => 'Illuminate\\Mail\\MailServiceProvider',
      13 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      14 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      15 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      16 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      17 => 'Illuminate\\Queue\\QueueServiceProvider',
      18 => 'Illuminate\\Redis\\RedisServiceProvider',
      19 => 'Illuminate\\Session\\SessionServiceProvider',
      20 => 'Illuminate\\Translation\\TranslationServiceProvider',
      21 => 'Illuminate\\Validation\\ValidationServiceProvider',
      22 => 'Illuminate\\View\\ViewServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\MenuServiceProvider',
    ),
    'aliases' => 
    array (
      'Helper' => 'App\\Helpers\\Helpers',
    ),
    'title' => 'Administrasi Kelulusan Sertifikat dan Ijazah',
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'cache' => 
  array (
    'default' => 'database',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'session' => 
      array (
        'driver' => 'session',
        'key' => '_cache',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'D:\\domain\\laravel_13.11\\storage\\framework/cache/data',
        'lock_path' => 'D:\\domain\\laravel_13.11\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'stores' => 
        array (
          0 => 'database',
          1 => 'array',
        ),
      ),
    ),
    'prefix' => 'aksi_cache_',
  ),
  'custom' => 
  array (
    'custom' => 
    array (
      'myLayout' => 'vertical',
      'myTheme' => 'light',
      'mySkins' => 'default',
      'hasSemiDark' => false,
      'myRTLMode' => false,
      'hasCustomizer' => true,
      'displayCustomizer' => true,
      'contentLayout' => 'compact',
      'navbarType' => 'sticky',
      'footerFixed' => false,
      'menuFixed' => true,
      'menuCollapsed' => false,
      'headerType' => 'fixed',
      'showDropdownOnHover' => true,
      'customizerControls' => 
      array (
        0 => 'color',
        1 => 'theme',
        2 => 'skins',
        3 => 'semiDark',
        4 => 'layoutCollapsed',
        5 => 'layoutNavbarOptions',
        6 => 'headerType',
        7 => 'contentLayout',
        8 => 'rtl',
      ),
    ),
  ),
  'database' => 
  array (
    'default' => 'mariadb',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'dbaksi_v2',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '172.30.13.26',
        'port' => '3306',
        'database' => 'dbaksi_v2',
        'username' => 'tegoeh',
        'password' => 'YzS3eeX9g8jlHB2',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '172.30.13.26',
        'port' => '3306',
        'database' => 'dbaksi_v2',
        'username' => 'tegoeh',
        'password' => 'YzS3eeX9g8jlHB2',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '172.30.10.61',
        'port' => '5432',
        'database' => 'db_myut_alumni_v1',
        'username' => 'app_myut_alumni',
        'password' => 'M4yVt41Mn!!',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '172.30.13.26',
        'port' => '3306',
        'database' => 'dbaksi_v2',
        'username' => 'tegoeh',
        'password' => 'YzS3eeX9g8jlHB2',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
      'dbaksi' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'dbaksi',
        'username' => NULL,
        'password' => NULL,
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
    ),
    'migrations' => 
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'aksi_database_',
        'persistent' => false,
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\domain\\laravel_13.11\\storage\\app/private',
        'serve' => true,
        'throw' => false,
        'report' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\domain\\laravel_13.11\\storage\\app/public',
        'url' => 'http://aksireborn.net/storage',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
        'report' => false,
      ),
    ),
    'links' => 
    array (
      'D:\\domain\\laravel_13.11\\public\\storage' => 'D:\\domain\\laravel_13.11\\storage\\app/public',
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'D:\\domain\\laravel_13.11\\storage\\logs/laravel.log',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'D:\\domain\\laravel_13.11\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'D:\\domain\\laravel_13.11\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'log',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'scheme' => NULL,
        'url' => NULL,
        'host' => 'smtp.office365.com',
        'port' => '587',
        'username' => 'aksi@ecampus.ut.ac.id',
        'password' => '4K5I!@UTterbuka',
        'timeout' => NULL,
        'local_domain' => 'aksireborn.net',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
      ),
    ),
    'from' => 
    array (
      'address' => 'aksi@ecampus.ut.ac.id',
      'name' => 'AKSI',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'D:\\domain\\laravel_13.11\\resources\\views/vendor/mail',
      ),
      'extensions' => 
      array (
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'deferred' => 
      array (
        'driver' => 'deferred',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'connections' => 
        array (
          0 => 'database',
          1 => 'deferred',
        ),
      ),
    ),
    'batching' => 
    array (
      'database' => 'mariadb',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mariadb',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
    'api_srs' => 
    array (
      'url' => 'https://api-srs.ut.ac.id/api-srs-mahasiswa/',
      'username' => 'aksi@ecampus.ut.ac.id',
      'password' => '4Ks1!UT24rfv',
    ),
    'lkam' => 
    array (
      'url' => 'http://10.2.1.10/index_non_pendas_lkam_per_mhs.php',
    ),
    'sika' => 
    array (
      'base_url' => 'https://api.sika.ika-ut.id',
      'username' => 'alumni@ecampus.ut.ac.id',
      'password' => 'Ut12345!',
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'D:\\domain\\laravel_13.11\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'aksi_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
  ),
  'variables' => 
  array (
    'creatorName' => 'Pixinvent',
    'creatorUrl' => 'https://pixinvent.com',
    'templateName' => 'Materialize',
    'templateSuffix' => 'Bootstrap Admin Template',
    'templateVersion' => '3.0.0',
    'templateFree' => false,
    'templateDescription' => 'Start your development with a Dashboard for Bootstrap 5',
    'templateKeyword' => 'dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5',
    'licenseUrl' => 'https://themeforest.net/licenses/standard',
    'livePreview' => 'https://demos.pixinvent.com/materialize-html-laravel-admin-template/demo-1/',
    'productPage' => 'https://1.envato.market/materialize_admin',
    'support' => 'https://pixinvent.ticksy.com/',
    'moreThemes' => 'https://themeforest.net/user/pixinvent/portfolio',
    'ogTitle' => 'Materialize bootstrap Dashboard by Pixinvent',
    'ogImage' => 'https://cdn.pixinvent.com/pi-assets/materialize/landing-page/materialize-hero-image.png',
    'ogType' => 'product',
    'documentation' => 'https://demos.pixinvent.com/materialize-html-admin-template/documentation',
    'generator' => '',
    'changelog' => 'https://demos.pixinvent.com/materialize/changelog.html',
    'repository' => 'https://github.com/pixinvent/materialize-html-laravel-admin-template',
    'gitRepo' => 'materialize-html-laravel-admin-template',
    'gitRepoAccess' => 'https://tools.pixinvent.com/github/github-access',
    'githubFreeUrl' => 'https://github.com/pixinvent',
    'facebookUrl' => 'https://www.facebook.com/pixinvents/',
    'twitterUrl' => 'https://x.com/pixinvents',
    'githubUrl' => 'https://github.com/pixinvent',
    'dribbbleUrl' => 'https://dribbble.com/pixinvent',
    'instagramUrl' => 'https://www.instagram.com/pixinvents/',
  ),
  'snappy' => 
  array (
    'pdf' => 
    array (
      'enabled' => true,
      'binary' => '/usr/local/bin/wkhtmltopdf',
      'timeout' => false,
      'options' => 
      array (
      ),
      'env' => 
      array (
      ),
    ),
    'image' => 
    array (
      'enabled' => true,
      'binary' => '/usr/local/bin/wkhtmltoimage',
      'timeout' => false,
      'options' => 
      array (
      ),
      'env' => 
      array (
      ),
    ),
  ),
  'captcha' => 
  array (
    'disable' => false,
    'characters' => 
    array (
      0 => 'A',
      1 => 'B',
      2 => 'C',
      3 => 'D',
      4 => 'E',
      5 => 'F',
      6 => 'G',
      7 => 'H',
      8 => 'I',
      9 => 'J',
      10 => 'K',
      11 => 'L',
      12 => 'M',
      13 => 'N',
      14 => 'O',
      15 => 'P',
      16 => 'Q',
      17 => 'R',
      18 => 'S',
      19 => 'T',
      20 => 'U',
      21 => 'V',
      22 => 'W',
      23 => 'X',
      24 => 'Y',
      25 => 'Z',
      26 => 'a',
      27 => 'b',
      28 => 'c',
      29 => 'd',
      30 => 'e',
      31 => 'f',
      32 => 'g',
      33 => 'h',
      34 => 'i',
      35 => 'j',
      36 => 'k',
      37 => 'l',
      38 => 'm',
      39 => 'n',
      40 => 'o',
      41 => 'p',
      42 => 'q',
      43 => 'r',
      44 => 's',
      45 => 't',
      46 => 'u',
      47 => 'v',
      48 => 'w',
      49 => 'x',
      50 => 'y',
      51 => 'z',
      52 => 0,
      53 => 1,
      54 => 2,
      55 => 3,
      56 => 4,
      57 => 5,
      58 => 6,
      59 => 7,
      60 => 8,
      61 => 9,
    ),
    'fontsDirectory' => 'D:\\domain\\laravel_13.11\\vendor\\mews\\captcha/assets/fonts',
    'bgsDirectory' => 'D:\\domain\\laravel_13.11\\vendor\\mews\\captcha/assets/backgrounds',
    'default' => 
    array (
      'length' => 6,
      'width' => 345,
      'height' => 65,
      'quality' => 90,
      'math' => false,
      'expire' => 60,
      'encrypt' => false,
    ),
    'flat' => 
    array (
      'length' => 6,
      'fontColors' => 
      array (
        0 => '#2c3e50',
        1 => '#c0392b',
        2 => '#16a085',
        3 => '#c0392b',
        4 => '#8e44ad',
        5 => '#303f9f',
        6 => '#f57c00',
        7 => '#795548',
      ),
      'width' => 345,
      'height' => 65,
      'math' => false,
      'quality' => 100,
      'lines' => 6,
      'bgImage' => true,
      'bgColor' => '#28faef',
      'contrast' => 0,
    ),
    'mini' => 
    array (
      'length' => 3,
      'width' => 60,
      'height' => 32,
    ),
    'inverse' => 
    array (
      'length' => 5,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'sensitive' => true,
      'angle' => 12,
      'sharpen' => 10,
      'blur' => 2,
      'invert' => false,
      'contrast' => -5,
    ),
    'math' => 
    array (
      'length' => 9,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
    ),
  ),
  'datatables' => 
  array (
    'search' => 
    array (
      'smart' => true,
      'multi_term' => true,
      'case_insensitive' => true,
      'use_wildcards' => false,
      'starts_with' => false,
    ),
    'index_column' => 'DT_RowIndex',
    'engines' => 
    array (
      'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
      'query' => 'Yajra\\DataTables\\QueryDataTable',
      'collection' => 'Yajra\\DataTables\\CollectionDataTable',
      'resource' => 'Yajra\\DataTables\\ApiResourceDataTable',
    ),
    'builders' => 
    array (
    ),
    'nulls_last_sql' => ':column :direction NULLS LAST',
    'error' => NULL,
    'columns' => 
    array (
      'excess' => 
      array (
        0 => 'rn',
        1 => 'row_num',
      ),
      'escape' => '*',
      'raw' => 
      array (
        0 => 'action',
      ),
      'blacklist' => 
      array (
        0 => 'password',
        1 => 'remember_token',
      ),
      'whitelist' => '*',
    ),
    'json' => 
    array (
      'header' => 
      array (
      ),
      'options' => 0,
    ),
    'callback' => 
    array (
      0 => '$',
      1 => '$.',
      2 => 'function',
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
    'trust_project' => 'always',
  ),
);
