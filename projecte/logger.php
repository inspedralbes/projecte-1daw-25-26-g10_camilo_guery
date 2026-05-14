<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() === 'cli') {
    return;
}
 
try {
$uri = getenv('MONGODB_URI') ?: 'mongodb://user:user1234@mongo:27017/';    
    $client = new MongoDB\Client($uri);
    $db = $client->gestorIncidencia;
    $collection = $db->logs;
 
    $documento = [
        'url' => $_SERVER['REQUEST_URI'],
        'metodo' => $_SERVER['REQUEST_METHOD'],
        'timestamp' => new MongoDB\BSON\UTCDateTime(time() * 1000),
        'navegador' => $_SERVER['HTTP_USER_AGENT'],
        'ip' => $_SERVER['REMOTE_ADDR']
    ];
 
    $collection->insertOne($documento);
} catch (Exception $e) {
    // Silenciar errores
}
?>