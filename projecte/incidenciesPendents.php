<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$sentencia = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data, i.dataFinalitzacio, i.prioritat, i.idTecnic,
t.nom AS nomTecnic,
COUNT(a.idActuacio) AS numActuacions,
SUM(a.temps) AS tempsTotal
FROM INCIDENCIA i
JOIN TECNIC t ON i.idTecnic = t.idTecnic
LEFT JOIN ACTUACIO a ON i.idIncidencia = a.idIncidencia
WHERE dataFinalitzacio IS NULL
GROUP BY i.idIncidencia
ORDER BY CASE 
WHEN i.prioritat = 'Alta' THEN 1
WHEN i.prioritat = 'Mitja' THEN 2
WHEN i.prioritat = 'Baixa' THEN 3
ELSE 4
END;");
$sentencia->execute();
$result = $sentencia->get_result();
$incidencias = $result->fetch_all(MYSQLI_ASSOC);

$sentenciaTecnics = $mysqli->prepare("SELECT idTecnic, nom FROM TECNIC ORDER BY nom;");
$sentenciaTecnics->execute();
$tecnics = $sentenciaTecnics->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["idTecnic"])) {
        $idTecnic = $_POST['idTecnic'];
        $sentencia = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data, i.dataFinalitzacio, i.prioritat, i.idTecnic,
        t.nom AS nomTecnic,
        COUNT(a.idActuacio) AS numActuacions,
        SUM(a.temps) AS tempsTotal
        FROM INCIDENCIA i
        JOIN TECNIC t ON i.idTecnic = t.idTecnic
        LEFT JOIN ACTUACIO a ON i.idIncidencia = a.idIncidencia
        WHERE i.dataFinalitzacio IS NULL AND i.idTecnic = ?
        GROUP BY i.idIncidencia
        ORDER BY CASE 
        WHEN i.prioritat = 'Alta' THEN 1
        WHEN i.prioritat = 'Mitja' THEN 2
        WHEN i.prioritat = 'Baixa' THEN 3
        ELSE 4
        END;");
        $sentencia->bind_param("i", $idTecnic);
        $sentencia->execute();
        $result = $sentencia->get_result();
        $incidencias = $result->fetch_all(MYSQLI_ASSOC);

    } if (empty($_POST["idTecnic"])) {
        $sentencia = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data, i.dataFinalitzacio, i.prioritat, i.idTecnic,
        t.nom AS nomTecnic,
        COUNT(a.idActuacio) AS numActuacions,
        SUM(a.temps) AS tempsTotal
        FROM INCIDENCIA i
        JOIN TECNIC t ON i.idTecnic = t.idTecnic
        LEFT JOIN ACTUACIO a ON i.idIncidencia = a.idIncidencia
        WHERE dataFinalitzacio IS NULL
        GROUP BY i.idIncidencia
        ORDER BY CASE 
        WHEN i.prioritat = 'Alta' THEN 1
        WHEN i.prioritat = 'Mitja' THEN 2
        WHEN i.prioritat = 'Baixa' THEN 3
        ELSE 4
        END;");
        $sentencia->execute();
        $result = $sentencia->get_result();
        $incidencias = $result->fetch_all(MYSQLI_ASSOC);    
    }
}
?>

<form method="POST">
    <div class ="input-group mt-3 px-5">
        <select name="idTecnic" class="form-select">
                <option value="" selected>Total incidències pendents</option>
            <?php foreach ($tecnics as $tecnic) { ?>
                <option value="<?php echo $tecnic["idTecnic"]; ?>"><?php echo $tecnic["nom"]?></option>
            <?php }; ?>
        </select>
        <div >
            <input type="submit" value="Filtrar" class="btn btn-primary py-3">
        </div>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Descripció</th>
            <th>Data</th>
            <th>Prioritat</th>
            <th>Tecnic</th>
            <th>Actuacions</th>
            <th>Temps Invertit</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach ($incidencias as $incidencia) { 
        $prioritat = match($incidencia["prioritat"]) {
            'Alta' => 'table-danger',
            'Mitja' => 'table-warning',
            'Baixa' => 'table-info',
            default => 'table-light'
        };
?>
    <tr class="<?php echo $prioritat; ?>">
        <td><?php echo $incidencia["idIncidencia"]; ?></td>
        <td><?php echo $incidencia["descripcio"]; ?></td>
        <td><?php echo $incidencia["data"]; ?></td>
        <td><?php echo $incidencia["prioritat"]; ?></td>
        <td><?php echo $incidencia["nomTecnic"]; ?></td>
        <td><?php echo $incidencia["numActuacions"] ?? "Sense Actuacions"; ?></td>
        <td><?php echo $incidencia["tempsTotal"] ?? "0"; ?> min</td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <a class="btn btn-primary" href="modificarIncidencies.php">Tornar Enrere</a>
</div>
<?php
include_once "footer.php";
?>