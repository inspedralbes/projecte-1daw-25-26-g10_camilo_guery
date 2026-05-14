<?php

require 'vendor/autoload.php';

try {
    $client = new MongoDB\Client(
        "mongodb://usuari:usuari1234@mongo:27017"
    );

    echo "OK: conectado a MongoDB";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}