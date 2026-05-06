<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$idIncidencia = $_POST["idIncidencia"];
$idIncidencia = (int)$idIncidencia;
$resultado = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data, i.dataFinalitzacio, i.prioritat,
    d.nom AS nomDepartament, 
    t.nom AS nomTecnic, 
    p.nom AS nomTipus  
FROM INCIDENCIA i 
JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
JOIN TECNIC t ON i.idTecnic = t.idTecnic
JOIN TIPUS p ON i.idTipus = p.idTipus
WHERE idIncidencia = ?");

$resultado->bind_param("i", $idIncidencia);
$resultado->execute();

$resultadoQuery = $resultado->get_result();
$incidencias = $resultadoQuery->fetch_all(MYSQLI_ASSOC);
?>

<?php
$sentencia = $mysqli->prepare("SELECT descripcio, data, visible, idIncidencia FROM ACTUACIO WHERE idIncidencia = ? AND visible = 1");
$sentencia->bind_param("i", $idIncidencia);
$sentencia->execute();
$result = $sentencia->get_result();
$actuacions = $result->fetch_all(MYSQLI_ASSOC);
?>

<table class="table">
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
                        <td><?php echo $incidencia["nomDepartament"] ?></td>
                        <td><?php echo $incidencia["nomTecnic"] ?></td>
                        <td><?php echo $incidencia["nomTipus"] ?></td>
                        <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                        <td><?php echo $incidencia["prioritat"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>


<?php if (!empty($actuacions)) { ?>
<div>
    <h3>Historial d'Actuacions</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Descripció</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($actuacions as $actuacio) { ?>
                <tr>
                    <td><?php echo $actuacio["data"]; ?></td>
                    <td><?php echo $actuacio["descripcio"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>No hi ha actuacions enregistrades.</p>
<?php } ?>
</div>

<a class="" href="index.php">Volver</a>

<?php include_once "footer.php"; ?>