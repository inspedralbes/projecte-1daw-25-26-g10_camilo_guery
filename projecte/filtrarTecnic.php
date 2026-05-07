<?php 
    $conexio = include_once "conexio.php";
    $idTecnic = $_POST["idTecnic"];
    $sentencia = $mysqli->prepare("SELECT * FROM INCIDENCIA WHERE idTecnic = ?");

    $sentencia->bind_param("i", $idTecnic);
    $sentencia->execute();

    header("Location: modificarIncidencies.php?seccion=incidencies");
    exit();
?>