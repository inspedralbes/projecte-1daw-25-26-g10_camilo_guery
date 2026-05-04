<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$idTecnic = $_GET["idTecnic"];
$resultadoIncidencia = $mysqli->query("SELECT idIncidencia, descripcio, data, idDepartament, idTecnic, idTipus, dataFinalitzacio, prioritat FROM INCIDENCIA WHERE idTecnic = $idTecnic");
$incidencias = $resultadoIncidencia->fetch_all(MYSQLI_ASSOC);
# Obtenemos solo una fila, que será el videojuego a editar
if (!$incidencias) {
    echo "No hi ha incidències per a aquest tècnic.";
    include_once "footer.php";
    exit;
}
?>

 <table>
        <thead>
            <tr>
                <th>Id d'Incidència</th>
                <th>Descripció</th>
                <th>Data</th>
                <th>Departament</th>
                <th>Tècnic</th>
                <th>Tipus</th>
                <th>Data Finalització</th>
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
                    <td><?php echo $incidencia["idTipus"] ?></td>
                    <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                    <td><?php echo $incidencia["prioritat"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php include_once "footer.php"; ?>