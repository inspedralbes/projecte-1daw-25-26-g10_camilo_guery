<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$idTecnic = $_GET["idTecnic"];
$sentencia = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data,
       d.nom AS nomDepartament,
       t.nom AS nomTipus,
       i.dataFinalitzacio, i.prioritat
FROM INCIDENCIA i
LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
LEFT JOIN TIPUS t ON i.idTipus = t.idTipus
WHERE i.idTecnic = ?");

$sentencia->bind_param("i", $idTecnic);
$sentencia->execute();

$result = $sentencia->get_result();
$incidencias = $result->fetch_all(MYSQLI_ASSOC);
# Obtenemos solo una fila, que será el videojuego a editar
if (!$incidencias) {
    ?>
    <div class="container mt-5">
        <p class="text-center">No hi ha incidències per a aquest tècnic.</p>
        
        <form method="GET" action="gestionarIncidencia.php">
            <div class="input-group mt-2">
                <span class="input-group-text">ID</span>
                <div class="form-floating">
                    <input type="text" class="form-control" id="buscarId" name="idIncidencia" placeholder="Buscar">
                    <label for="buscarId">Buscar per ID</label>
                </div>
                <input type="hidden" name="idTecnic" value="<?php echo $idTecnic; ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
    </div>
    <?php
    include_once "footer.php";
    exit;
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
            $snt = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data,
            d.nom AS nomDepartament,
            t.nom AS nomTipus,
            i.dataFinalitzacio, i.prioritat
            FROM INCIDENCIA i
            JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
            JOIN TIPUS t ON i.idTipus = t.idTipus
            WHERE i.idTecnic = ?
            ORDER BY CASE 
                WHEN i.prioritat = 'Alta' THEN 1
                WHEN i.prioritat = 'Mitja' THEN 2
                WHEN i.prioritat = 'Baixa' THEN 3
                ELSE 4
            END");

            $snt->bind_param("i", $idTecnic);
            $snt->execute();

            $resultat = $snt->get_result();
            $incidencias = $resultat->fetch_all(MYSQLI_ASSOC);
            break;
        
        case 'departament':
            $snt = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data,
            d.nom AS nomDepartament,
            t.nom AS nomTipus,
            i.dataFinalitzacio, i.prioritat
            FROM INCIDENCIA i
            JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
            JOIN TIPUS t ON i.idTipus = t.idTipus
            WHERE i.idTecnic = ?
            ORDER BY CASE 
                WHEN d.nom = 'Programacio' THEN 1
                WHEN d.nom = 'Sistemes' THEN 2
                WHEN d.nom = 'Base de Dades' THEN 3
                ELSE 4
            END");

            $snt->bind_param("i", $idTecnic);
            $snt->execute();

            $resultat = $snt->get_result();
            $incidencias = $resultat->fetch_all(MYSQLI_ASSOC);
            break;

        case 'data':
            $snt = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data,
            d.nom AS nomDepartament,
            t.nom AS nomTipus,
            i.dataFinalitzacio, i.prioritat
            FROM INCIDENCIA i
            JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
            JOIN TIPUS t ON i.idTipus = t.idTipus
            WHERE i.idTecnic = ?
            ORDER BY i.data ASC");

            $snt->bind_param("i", $idTecnic);
            $snt->execute();

            $resultat = $snt->get_result();
            $incidencias = $resultat->fetch_all(MYSQLI_ASSOC);
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

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Descripció</th>
            <th>Data</th>
            <th>Departament</th>
            <th>Tipus</th>
            <th>Data Finalització</th>
            <th>Prioritat</th>
            <th>Actuacions</th>
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
                    <td><?php echo $incidencia["nomTipus"] ?></td>
                    <td><?php echo $incidencia["dataFinalitzacio"] ?? "No Finalitzada" ?></td>
                    <td><?php echo $incidencia["prioritat"] ?></td>
                    <td><a class="btn btn-success btn-sm" href="actuacioIncidencia.php?idIncidencia=<?php echo $incidencia["idIncidencia"] ?>&idTecnic=<?php echo $idTecnic?>">Veure</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<form method="GET" action="gestionarIncidencia.php">
  <div class="input-group mt-2 px-4">
    <span class="input-group-text">ID</span>
    <div class="form-floating">
      <input type="text" class="form-control" id="buscarId" name="idIncidencia" placeholder="Buscar">
      <label for="buscarId">Buscar per ID</label>
    </div>
    <input type="hidden" name="idTecnic" value="<?php echo $idTecnic ?>">
    <button type="submit" class="btn btn-primary">Buscar</button>
  </div>
</form>
<?php include_once "footer.php"; ?>