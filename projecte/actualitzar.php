<?php
$mysqli = include_once "conexio.php";

foreach ($_POST["idTecnic"] as $idIncidencia => $idTecnic) {
    $idTipus = $_POST["idTipus"][$idIncidencia] ?? null;
    $prioritat = $_POST["prioritat"][$idIncidencia] ?? null;

    if ($idTecnic === "") {
        $idTecnic = null;
    }
    if ($idTipus === "") {
        $idTipus = null;
    }
    if ($prioritat === "") {
        $prioritat = null;
    }

    $sentencia = $mysqli->prepare("
        UPDATE INCIDENCIA 
        SET idTecnic = ?, idTipus = ?, prioritat = ?
        WHERE idIncidencia = ?
    ");
    $sentencia->bind_param("iisi", $idTecnic, $idTipus, $prioritat, $idIncidencia);

    $sentencia->execute();
}
header("Location: modificarIncidencies.php");
?>