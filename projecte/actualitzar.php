<?php
$mysqli = include_once "conexio.php";

foreach ($_POST["idTecnic"] as $idIncidencia => $idTecnic) {
    if ($idTecnic === "") {
        $idTecnic = null;
    }
    $sentencia = $mysqli->prepare("
        UPDATE INCIDENCIA 
        SET idTecnic = ? 
        WHERE idIncidencia = ?
    ");
    $sentencia->bind_param("ii", $idTecnic, $idIncidencia);
    $sentencia->execute();
}
?>