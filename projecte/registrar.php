<?php 
$mysqli = include_once "conexio.php";
$descripcio = $_POST["descripcio"];
$data = date("Y-m-d H:i:s");
$idDepartament = $_POST["idDepartament"];
$sentencia = $mysqli->prepare("INSERT INTO INCIDENCIA
(descripcio, data, idDepartament)
VALUES
(?, ?, ?)");
$sentencia->bind_param("ssi", $descripcio, $data, $idDepartament);
$sentencia->execute();
// header("Location: listar.php");