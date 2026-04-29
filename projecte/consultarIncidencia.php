<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$idIncidencia = $_POST["idIncidencia"];
$idIncidencia = (int)$idIncidencia;
$resultado = $mysqli->query("SELECT idIncidencia, descripcio, data, idDepartament, idTecnic, idTipo, dataFinalitzacio, prioritat FROM INCIDENCIA WHERE idIncidencia = $idIncidencia");
$incidencias = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<table>
            <thead>
                <tr>
                    <th>Id d'Incidencia</th>
                    <th>Descripcio</th>
                    <th>Data</th>
                    <th>Departament</th>
                    <th>Tecnic</th>
                    <th>Tipo</th>
                    <th>Data Finalitzacio</th>
                    <th>Prioritat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($incidencias as $incidencia) { ?>
                    <tr>
                        <td><?php echo $incidencia["idIncidencia"] ?></td>
                        <td><?php echo $incidencia["descripcio"] ?></td>
                        <td><?php echo $incidencia["data"] ?></td>
                        <td><?php echo $incidencia["idDepartament"] ?></td>
                        <td><?php echo $incidencia["idTecnic"] ?></td>
                        <td><?php echo $incidencia["idTecnic"] ?></td>
                        <td><?php echo $incidencia["idTipo"] ?></td>
                        <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                        <td><?php echo $incidencia["prioritat"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a class="" href="index.html">Volver</a>