<?php

use Dotenv\Dotenv;

// Charger le fichier .env seulement s'il existe (développement local)
if (file_exists(__DIR__ . '/../../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

// Support pour Render (DATABASE_URL) et autres variables d'environnement
if (isset($_ENV['DATABASE_URL'])) {
    $databaseUrl = parse_url($_ENV['DATABASE_URL']);
    define('DB_HOST', $databaseUrl['host']);
    define('DB_PORT', $databaseUrl['port'] ?? 5432);
    define('DB_NAME', ltrim($databaseUrl['path'], '/'));
    define('DB_USER', $databaseUrl['user']);
    define('DB_PASSWORD', $databaseUrl['pass']);
    define('DB_CONNECTION', 'pgsql');
} else {
    // Configuration depuis variables d'environnement ou .env
    define('DB_USER', $_ENV['DB_USER'] ?? 'postgres');
    define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
    define('DB_NAME', $_ENV['DB_NAME'] ?? 'postgres');
    define('DB_HOST', $_ENV['DB_HOST'] ?? '127.0.0.1');
    define('DB_PORT', $_ENV['DB_PORT'] ?? '5432');
    define('DB_CONNECTION', $_ENV['DB_CONNECTION'] ?? 'pgsql');
}

$DSN_POSTGRES = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
$DSN_MYSQL = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
$BASE_DSN_MYSQL = "mysql:host=" . DB_HOST . ";port=" . DB_PORT;
$BASE_DSN_PGSQL = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT;

if (DB_CONNECTION === 'pgsql') {
    define('DSN', $DSN_POSTGRES);
} elseif (DB_CONNECTION === 'mysql') {
    define('DSN', $DSN_MYSQL);
}

define('BASE_DSN_MYSQL', $BASE_DSN_MYSQL);
define('BASE_DSN_PGSQL', $BASE_DSN_PGSQL);

define('API_URL', $_ENV['API_URL'] ?? 'http://localhost:8006');
define('WEB_ROUTE', $_ENV['WEB_ROUTE'] ?? '/');
define('UPLOAD_DIR', $_ENV['UPLOAD_DIR'] ?? 'images/');
