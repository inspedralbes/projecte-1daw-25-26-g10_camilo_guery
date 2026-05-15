<?php
require __DIR__ . '/vendor/autoload.php';

// =====================
// LOAD .ENV
// =====================
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// =====================
// MONGODB URI
// =====================
$uri = $_ENV['MONGODB_URI'] ?? $_SERVER['MONGODB_URI'] ?? null;

if (!$uri) {
    throw new Exception("MONGODB_URI no definida");
}

// =====================
// MONGO CLIENT
// =====================
$client = new MongoDB\Client($uri);
$collection = $client->gestorIncidencies->logs;

// =====================
// INSERT LOG
// =====================
$collection->insertOne([
    'url' => $_SERVER['REQUEST_URI'],
    'metodo' => $_SERVER['REQUEST_METHOD'],
    'timestamp' => new MongoDB\BSON\UTCDateTime(),
    'navegador' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'ip' => $_SERVER['REMOTE_ADDR'] ?? ''
]);