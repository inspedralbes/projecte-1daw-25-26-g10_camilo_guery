<?php
$host = "db";
$usuario = "usuari";
$contrasenia = "usuari1234";
$base_de_datos = "gestorIncidencia";
$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
return $mysqli;
