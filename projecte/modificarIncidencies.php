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

$resultadoDepartamentos = $mysqli->query("SELECT idDepartament, nom FROM DEPARTAMENT");
$departamentos = $resultadoDepartamentos->fetch_all(MYSQLI_ASSOC);

// IF PARA CONTROLAR LOS POST DEL FORMULARIO
$incidenciasTecnicos = [];
$incidenciasDepartamentos = [];
$idTecnicSeleccionado = "";
$idDepartamentSeleccionado = "";

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

        $incidenciasTecnicos = $sentencia->get_result()->fetch_all(MYSQLI_ASSOC);
    } else if ($_POST["tipusInforme"] == "informeDepartamental") {
        $idDepartamentSeleccionado = $_POST["idDepartament"];
        
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
        WHERE i.idDepartament = ?");

        $sentencia->bind_param("i", $idDepartamentSeleccionado);
        $sentencia->execute();

        $incidenciasDepartamentos = $sentencia->get_result()->fetch_all(MYSQLI_ASSOC);
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

<form method="GET" class="mt-3" >
    <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
        <button type="submit" name="prioritat" class="btn btn-outline-dark" value="prioritat">Prioritat</button>
        <button type="submit" name="departament" class="btn btn-outline-dark" value="departament">Departament</button>
        <button type="submit" name="data" class="btn btn-outline-dark" value="data">Data</button>
    </div>
</form>

<nav class="container mt-2">
    <button class="btn btn-light" id="btn-incidencies" onclick="showWindow('incidencies')">Incidencies</button>
    <button class="btn btn-light" id="btn-informeTecnics" onclick="showWindow('informeTecnics')">Informe Tècnics</button>
    <button class="btn btn-light" id="btn-informeDepartamental" onclick="showWindow('informeDepartamental')">Informe Departamental</button>
    <a class="btn btn-light" id="btn-panellAcces" href="panellAcces.php">Panel d'Accés</a>
</nav>

<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- SECCION DE MODIFICAR INCIDENCIAS ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="container">
    <div id="incidencies" class="window-info active">
        <form action="actualitzar.php" method="POST">
            <div class="border border-dark rounded-3 overflow-hidden w-100 my-5 shadow">
                <div class="table-responsive">
                    <table class="table mb-0">
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
                                    default => 'table-light'
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
                </div>
            </div>
            <input type="submit" value="Guardar cambios" class="btn btn-success">
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
        <div class="border border-dark rounded-3 overflow-hidden w-100 my-5 shadow">
            <div class="table-responsive">
                <table class="table mb-0">
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
                    foreach ($incidenciasTecnicos as $incidencia) { 

                        $prioritat = match($incidencia["prioritat"]) {
                            'Alta' => 'table-danger',
                            'Mitja' => 'table-warning',
                            'Baixa' => 'table-info',
                            default => 'table-light'
                        };
                    ?>
                        <tr class="<?php echo $prioritat; ?>">
                            <td><?php echo $incidencia["idIncidencia"] ?></td>
                            <td><?php echo htmlspecialchars($incidencia["descripcio"]) ?></td>
                            <td><?php echo $incidencia["data"] ?></td>
                            <td><?php echo htmlspecialchars($incidencia["nomDepartament"]) ?></td>
                            <td><?php echo htmlspecialchars($incidencia["nomTipus"] ?? "Sin asignar") ?></td>
                            <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                            <td><?php echo htmlspecialchars($incidencia["prioritat"] ?? "Sin asignar") ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- SECCION DE CONSUMO POR DEPARTAMENTO ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    
    <div id="informeDepartamental" class="window-info">
         <h3>Informe de consum per departament</h3>
        <form action="modificarIncidencies.php" method="POST">
            <input type="hidden" name="tipusInforme" value="informeDepartamental">
            <select name="idDepartament">
                <?php foreach ($departamentos as $departamento) { ?>
                    <option value="<?php echo $departamento["idDepartament"]; ?>"
                    <?php echo ($departamento["idDepartament"] == $idDepartamentSeleccionado) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($departamento["nom"]); ?>
                    </option>
                <?php } ?>
            </select>
            <input type="submit" value="Filtrar">
        </form>
        <div class="border border-dark rounded-3 overflow-hidden w-100 my-5 shadow">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Id d'Incidència</th>
                            <th>Descripció</th>
                            <th>Data</th>
                            <th>Tècnic</th>
                            <th>Tipus</th>
                            <th>Data Finalització</th>
                            <th>Prioritat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($incidenciasDepartamentos as $incidencia) { 

                            $prioritat = match($incidencia["prioritat"]) {
                                'Alta' => 'table-danger',
                                'Mitja' => 'table-warning',
                                'Baixa' => 'table-info',
                                default => 'table-light'
                            };
                        ?>
                            <tr class="<?php echo $prioritat; ?>">
                                <td><?php echo $incidencia["idIncidencia"] ?></td>
                                <td><?php echo htmlspecialchars($incidencia["descripcio"]) ?></td>
                                <td><?php echo $incidencia["data"] ?></td>
                                <td><?php echo htmlspecialchars($incidencia["nomTecnic"] ?? "Sin asignar") ?></td>
                                <td><?php echo htmlspecialchars($incidencia["nomTipus"] ?? "Sin asignar") ?></td>
                                <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                                <td><?php echo htmlspecialchars($incidencia["prioritat"] ?? "Sin asignar") ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div> 
        </div>
    </div>

    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- SECCION DE PANEL DE ACCESO---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    
    <div class="d-flex justify-content-start"> 
        <a class="btn btn-primary mt-3" href="index.php">Tornar enrere</a>
    </div>
    <div class="d-flex justify-content-end">     
        <a class="btn btn-warning mb-5" href="incidenciesPendents.php">Incidències Pendents</a>
    </div>

</div>
<?php include_once "footer.php"; ?>