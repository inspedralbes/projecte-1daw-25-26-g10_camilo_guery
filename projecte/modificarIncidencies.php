<?php
$titulo = "Gestor d'Incidències - Modificació d'Incidències";
include_once "header.php";
$mysqli = include_once "conexio.php";
$resultadoIncidencia = $mysqli->query("SELECT i.idIncidencia, i.descripcio, i.data,
       d.nom AS nomDepartament,
       te.nom AS nomTecnic,
       t.nom AS nomTipus,
       i.idTecnic, i.idTipus,
       i.dataFinalitzacio, i.prioritat
FROM INCIDENCIA i
LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
LEFT JOIN TECNIC te ON i.idTecnic = te.idTecnic
LEFT JOIN TIPUS t ON i.idTipus = t.idTipus");
$incidencias = $resultadoIncidencia->fetch_all(MYSQLI_ASSOC);

$resultadoTecnicos = $mysqli->query("SELECT idTecnic, nom FROM TECNIC");
$tecnicos = $resultadoTecnicos->fetch_all(MYSQLI_ASSOC);

$resultadoTipus = $mysqli->query("SELECT idTipus, nom FROM TIPUS");
$tipus = $resultadoTipus->fetch_all(MYSQLI_ASSOC);



// IF PARA CONTROLAR LOS POST DEL FORMULARIO
$incidenciasFiltradas = [];
$idTecnicSeleccionado = "";

if (isset($_POST["tipusInforme"])) {
    if($_POST["tipusInforme"] == "informeTecnics") {
        $idTecnicSeleccionado = $_POST["idTecnic"];
        
        $sentencia = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data,
            d.nom AS nomDepartament,
            te.nom AS nomTecnic,
            t.nom AS nomTipus,
            i.idTecnic, i.idTipus,
            i.dataFinalitzacio, i.prioritat
        FROM INCIDENCIA i
        LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
        LEFT JOIN TECNIC te ON i.idTecnic = te.idTecnic
        LEFT JOIN TIPUS t ON i.idTipus = t.idTipus
        WHERE i.idTecnic = ?");

        $sentencia->bind_param("i", $idTecnicSeleccionado);
        $sentencia->execute();

        $incidenciasFiltradas = $sentencia->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

?>
<!-- funcion para filtrar orden -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET["prioritat"])) {
        $qboton = "prioritat";
    } elseif (isset($_GET["departament"])) {
        $qboton = "departament";
    } elseif (isset($_GET["data"])) {
        $qboton = "data";
    } else { 
        $qboton = null;
    }

    switch ($qboton) {
        case 'prioritat':
            $resultadoIncidencia = $mysqli->query("SELECT i.idIncidencia, i.descripcio, i.data,
            d.nom AS nomDepartament,
            te.nom AS nomTecnic,
            t.nom AS nomTipus,
            i.idTecnic, i.idTipus,
            i.dataFinalitzacio, i.prioritat
            FROM INCIDENCIA i
            LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
            LEFT JOIN TECNIC te ON i.idTecnic = te.idTecnic
            LEFT JOIN TIPUS t ON i.idTipus = t.idTipus
            ORDER BY CASE 
                WHEN i.prioritat = 'Alta' THEN 1
                WHEN i.prioritat = 'Mitja' THEN 2
                WHEN i.prioritat = 'Baixa' THEN 3
                ELSE 4
            END");
            $incidencias = $resultadoIncidencia->fetch_all(MYSQLI_ASSOC);
            break;
        
        case 'departament':
            $resultadoIncidencia = $mysqli->query("SELECT i.idIncidencia, i.descripcio, i.data,
            d.nom AS nomDepartament,
            te.nom AS nomTecnic,
            t.nom AS nomTipus,
            i.idTecnic, i.idTipus,
            i.dataFinalitzacio, i.prioritat
            FROM INCIDENCIA i
            LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
            LEFT JOIN TECNIC te ON i.idTecnic = te.idTecnic
            LEFT JOIN TIPUS t ON i.idTipus = t.idTipus
            ORDER BY d.nom ASC");
            $incidencias = $resultadoIncidencia->fetch_all(MYSQLI_ASSOC);
            break;

        case 'data':
            $resultadoIncidencia = $mysqli->query("SELECT i.idIncidencia, i.descripcio, i.data,
            d.nom AS nomDepartament,
            te.nom AS nomTecnic,
            t.nom AS nomTipus,
            i.idTecnic, i.idTipus,
            i.dataFinalitzacio, i.prioritat
            FROM INCIDENCIA i
            LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
            LEFT JOIN TECNIC te ON i.idTecnic = te.idTecnic
            LEFT JOIN TIPUS t ON i.idTipus = t.idTipus
            ORDER BY i.data ASC");
            $incidencias = $resultadoIncidencia->fetch_all(MYSQLI_ASSOC);
            break;       
    }
}
?>

<form method="GET">
    <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
        <button type="submit" name="prioritat" class="btn btn-outline-dark" value="prioritat">Prioritat</button>
        <button type="submit" name="departament" class="btn btn-outline-dark" value="departament">Departament</button>
        <button type="submit" name="data" class="btn btn-outline-dark" value="data">Data</button>
        <input type="hidden" name="idTecnic" value="<?php echo $idTecnic ?>">
    </div>
</form>

<nav>
    <button id="btn-incidencies" onclick="showWindow('incidencies')">Incidencies</button>
    <button id="btn-informeTecnics" onclick="showWindow('informeTecnics')">Informe Tècnics</button>
    <button id="btn-informeDepartamental" onclick="showWindow('informeDepartamental')">Informe Departamental</button>
    <button id="btn-informeAcceso" onclick="showWindow('informeAcceso')">Panel d'Accés</button>
</nav>
<main>

<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- SECCION DE MODIFICAR INCIDENCIAS ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <div id="incidencies" class="window-info active">
        <form action="actualitzar.php" method="POST">
            <table class="table">
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
                    foreach ($incidencias as $incidencia) { 
                        $prioritat = match($incidencia["prioritat"]) {
                            'Alta' => 'table-danger',
                            'Mitja' => 'table-warning',
                            'Baixa' => 'table-info',
                            default => 'tabla-light'
                        };
                    ?>
                        <tr class="<?php echo $prioritat?>">
                            <td><?php echo $incidencia["idIncidencia"] ?></td>
                            <td><?php echo $incidencia["descripcio"] ?></td>
                            <td><?php echo $incidencia["data"] ?></td>
                            <td><?php echo $incidencia["nomDepartament"] ?></td>
                            <td>
                                <select name="idTecnic[<?php echo $incidencia["idIncidencia"]; ?>]">
                                    <option value="" <?php echo ($incidencia["idTecnic"] == null) ? "selected" : ""; ?>>
                                        Sin asignar
                                    </option>
                                    <?php foreach ($tecnicos as $tecnico) { ?>
                                        <option value="<?php echo $tecnico["idTecnic"]; ?>"
                                            <?php echo ($tecnico["idTecnic"] == $incidencia["idTecnic"]) ? "selected" : ""; ?>>
                                            <?php echo $tecnico["nom"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <select name="idTipus[<?php echo $incidencia["idIncidencia"]; ?>]">
                                    <option value="" <?php echo ($incidencia["idTipus"] == null) ? "selected" : ""; ?>>
                                        Sin asignar
                                    </option>
                                    <?php foreach ($tipus as $tipo) { ?>
                                        <option value="<?php echo $tipo["idTipus"]; ?>"
                                            <?php echo ($tipo["idTipus"] == $incidencia["idTipus"]) ? "selected" : ""; ?>>
                                            <?php echo $tipo["nom"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                            <td>
                                <select name="prioritat[<?php echo $incidencia["idIncidencia"]; ?>]">
                                    <option value="" <?php echo ($incidencia["prioritat"] == null) ? "selected" : ""; ?>>
                                        Sin asignar
                                    </option>
                                    <option value="Alta" <?php echo ($incidencia["prioritat"] == "Alta") ? "selected" : ""; ?>>
                                        Alta
                                    </option>
                                    <option value="Mitja" <?php echo ($incidencia["prioritat"] == "Mitja") ? "selected" : ""; ?>>
                                        Mitja
                                    </option>
                                    <option value="Baixa" <?php echo ($incidencia["prioritat"] == "Baixa") ? "selected" : ""; ?>>
                                        Baixa
                                    </option>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <input type="submit" value="Guardar cambios">
        </form>
    </div>

    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- SECCION DE INFORME TECNICOS ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <div id="informeTecnics" class="window-info">
        <h3>Informe de Tècnics</h3>
        <form action="modificarIncidencies.php" method="POST">
            <input type="hidden" name="tipusInforme" value="informeTecnics">
            <select name="idTecnic">
                <?php foreach ($tecnicos as $tecnico) { ?>
                    <option value="<?php echo $tecnico["idTecnic"]; ?>"
                    <?php echo ($tecnico["idTecnic"] == $idTecnicSeleccionado) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($tecnico["nom"]); ?>
                    </option>
                <?php } ?>
            </select>
            <input type="submit" value="Filtrar">
        </form>
        <table>
            <thead>
                <tr>
                    <th>Id d'Incidència</th>
                    <th>Descripció</th>
                    <th>Data</th>
                    <th>Departament</th>
                    <th>Tipus</th>
                    <th>Data Finalització</th>
                    <th>Prioritat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($incidenciasFiltradas as $incidencia) { ?>
                    <tr>
                        <td><?php echo $incidencia["idIncidencia"] ?></td>
                        <td><?php echo htmlspecialchars($incidencia["descripcio"]) ?></td>
                        <td><?php echo $incidencia["data"] ?></td>
                        <td><?php echo htmlspecialchars($incidencia["nomDepartament"]) ?></td>
                        <td><?php echo htmlspecialchars($incidencia["nomTipus"]) ?></td>
                        <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                        <td><?php echo $incidencia["prioritat"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- SECCION DE CONSUMO POR DEPARTAMENTO ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    
    <div id="informeDepartamental" class="window-info">
        <p>Hola</p>   
    </div>

    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- SECCION DE PANEL DE ACCESO---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <div id="informeAcceso" class="window-info">
        <p>Hola</p>
    </div>

    <a class="" href="index.php">Volver</a>
</main>
<script>

</script>
<?php include_once "footer.php"; ?>