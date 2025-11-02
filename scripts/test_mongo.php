<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    $host = getenv('MONGODB_HOST') ?: 'mongodb';
    $port = getenv('MONGODB_PORT') ?: 27017;
    $user = getenv('MONGODB_USERNAME');
    $pass = getenv('MONGODB_PASSWORD');
    $authDb = getenv('MONGODB_AUTHENTICATION_DATABASE') ?: getenv('MONGO_AUTHDB') ?: 'admin';

    // If env vars are not loaded in this plain PHP script, fall back to the known test creds
    if (!$user) {
        $user = 'admin';
        $pass = 'admin';
    }

    $dsn = sprintf('mongodb://%s:%s@%s:%s/?authSource=%s', $user, $pass, $host, $port, $authDb);

    $client = new MongoDB\Client($dsn);
    $databases = iterator_to_array($client->listDatabases());
    echo "OK: " . count($databases) . " databases\n";
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
