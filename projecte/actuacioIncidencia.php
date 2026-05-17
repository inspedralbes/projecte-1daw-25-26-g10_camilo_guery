<?php
$mysqli = include_once "conexio.php";

$idIncidencia = $_GET["idIncidencia"];
$idTecnic = $_GET["idTecnic"];

/* 🔵 OBTENER NOMBRE DEL TÉCNICO */
$sentenciaTecnic = $mysqli->prepare("SELECT nom FROM TECNIC WHERE idTecnic = ?");
$sentenciaTecnic->bind_param("i", $idTecnic);
$sentenciaTecnic->execute();
$resultTecnic = $sentenciaTecnic->get_result();
$tecnic = $resultTecnic->fetch_assoc();

$nomTecnic = $tecnic["nom"] ?? "Desconegut";

/* 🔵 TÍTULO DINÁMICO */
$titulo = "Gestor d'Incidències | Tècnics | " . $nomTecnic . " | Actuacions";

include_once "header.php";

/* ACTUACIONES */
$sentencia = $mysqli->prepare("SELECT descripcio, data, temps FROM ACTUACIO WHERE idIncidencia = ?");
$sentencia->bind_param("i", $idIncidencia);
$sentencia->execute();
$result = $sentencia->get_result();
$actuacions = $result->fetch_all(MYSQLI_ASSOC);

/* INCIDENCIA */
$sentencia2 = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data,
       d.nom AS nomDepartament,
       t.nom AS nomTipus,
       i.dataFinalitzacio, i.prioritat
FROM INCIDENCIA i
LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
LEFT JOIN TIPUS t ON i.idTipus = t.idTipus
WHERE i.idIncidencia = ?");

$sentencia2->bind_param("i", $idIncidencia);
$sentencia2->execute();
$resultado = $sentencia2->get_result();
$incidencias = $resultado->fetch_all(MYSQLI_ASSOC);

/* POST */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $qboton = isset($_POST["afegir"]) ? "afegir" : (isset($_POST["resoldre"]) ? "resoldre" : null);

    switch ($qboton) {
        case 'afegir':
            $descripcio = $_POST["descripcio"];
            $temps = $_POST["temps"];
            if ($temps < 0) {
                echo "<div class='alert alert-danger'>El temps no pot ser negatiu.</div>";
                return;
            }
            $visible = isset($_POST["visible"]) ? 1 : 0;

            $sentenciaInsert = $mysqli->prepare(
                "INSERT INTO ACTUACIO (idIncidencia, descripcio, temps, visible, data) VALUES (?, ?, ?, ?, NOW())"
            );
            $sentenciaInsert->bind_param("isii", $idIncidencia, $descripcio, $temps, $visible);

            if ($sentenciaInsert->execute()) {
                echo "<div class='alert alert-success'>Actuació afegida correctament.</div>";
                header("Refresh:1");
            } else {
                echo "<div class='alert alert-danger'>Error al afegir l'actuació.</div>";
            }
        break;

        case 'resoldre':
            $data = date("Y-m-d H:i:s");
            $descripcio2 = $_POST["descripcio"];
            $temps2 = $_POST["temps"];
                if ($temps2 < 0) {
                    echo "<div class='alert alert-danger'>El temps no pot ser negatiu.</div>";
                    return;
                }
            $visible2 = 1;

            $sentenciaInsert = $mysqli->prepare(
                "INSERT INTO ACTUACIO (idIncidencia, descripcio, temps, visible, data) VALUES (?, ?, ?, ?, ?)"
            );
            $sentenciaInsert->bind_param("isiis", $idIncidencia, $descripcio2, $temps2, $visible2, $data);

            $sentenciaUpdate = $mysqli->prepare(
                "UPDATE INCIDENCIA SET dataFinalitzacio = ? WHERE idIncidencia = ?"
            );
            $sentenciaUpdate->bind_param("si", $data, $idIncidencia);

            if ($sentenciaInsert->execute() && $sentenciaUpdate->execute()) {
                echo "<div class='alert alert-success'>Incidència tancada correctament.</div>";
                header("Refresh:1");
            } else {
                echo "<div class='alert alert-danger'>Error al tancar l'incidència.</div>";
            }
        break;
    }
}
?>

<!-- 🔵 TABLA INCIDENCIA -->
<div class="container">
    <div class="border border-dark rounded-3 overflow-hidden my-5 shadow">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Descripció</th>
                        <th>Data</th>
                        <th>Departament</th>
                        <th>Tipus</th>
                        <th>Data Finalització</th>
                        <th>Prioritat</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($incidencias as $incidencia) { 
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
                        <td><?php echo $incidencia["nomTipus"] ?></td>
                        <td><?php echo $incidencia["dataFinalitzacio"] ?? "No Finalitzada" ?></td>
                        <td><?php echo $incidencia["prioritat"] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- RESTO SIN CAMBIOS -->
<div class="container justify-content-center row">
<div class="col-6 mt-3 px-5 text-center">
    <h3>Afegir Actuació</h3>

    <form method="POST">
        <div class="mb-3">
            <label for="descripcio" class="form-label">Descripció</label>
            <textarea class="form-control" id="descripcio" name="descripcio" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="temps" class="form-label">Temps Invertit (min)</label>
            <input type="number" class="form-control" id="temps" name="temps" min="0" required> 
        </div>

        <div class="mb-3">
            <input class="form-check-input" type="checkbox" id="visible" name="visible">
            <label class="form-check-label" for="visible">
                Visible per al client
            </label>
        </div>

        <button type="submit" name="afegir" class="btn btn-success">Afegir Actuació</button>
        <br>
        <button type="submit" name="resoldre" class="btn btn-danger m-2">Tancar Incidència</button>
    </form>
</div>

<div class="col-6 mt-3">
    <h3>Historial d'Actuacions</h3>

    <?php if (!empty($actuacions)) { ?>
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th style="width: 15%;">Data</th>
                    <th style="width: 70%;">Descripció</th>
                    <th style="width: 15%;">Temps</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($actuacions as $actuacio) { ?>
                <tr>
                    <td><?php echo $actuacio["data"]; ?></td>
                    <td><?php echo $actuacio["descripcio"]; ?></td>
                    <td><?php echo $actuacio["temps"]; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No hi ha actuacions enregistrades.</p>
    <?php } ?>
</div>
</div>

<div class="d-flex justify-content-center p-5">
    <a class="btn btn-primary mb-5" href="llistatIncidenciaTecnic.php?idTecnic=<?php echo $idTecnic ?>">
        Tornar Enrere
    </a>
</div>

<?php include_once "footer.php"; ?>