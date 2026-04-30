<?php
$mysqli = include_once "conexio.php";

foreach ($_POST["idTecnic"] as $idIncidencia => $idTecnic) {
    $idTipus = $_POST["idTipus"][$idIncidencia] ?? null;
    if ($idTecnic === "") {
        $idTecnic = null;
    }
    if ($idTipus === "") {
        $idTipus = null;
    }
    $sentencia = $mysqli->prepare("
        UPDATE INCIDENCIA 
        SET idTecnic = ?, idTipus = ?
        WHERE idIncidencia = ?
    ");
    $sentencia->bind_param("iii", $idTecnic, $idTipus, $idIncidencia);
    $sentencia->execute();
}
?>