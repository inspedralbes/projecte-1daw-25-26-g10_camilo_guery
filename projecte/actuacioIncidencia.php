<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$idIncidencia = $_GET["idIncidencia"];
$sentencia = $mysqli->prepare("SELECT descripcio, data, temps FROM ACTUACIO WHERE idIncidencia = ?");

$sentencia->bind_param("i", $idIncidencia);
$sentencia->execute();
$result = $sentencia->get_result();
$actuacions = $result->fetch_all(MYSQLI_ASSOC);
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $qboton = isset($_POST["afegir"]) ? "afegir" : (isset($_POST["resoldre"]) ? "resoldre" : null);

    switch ($qboton) {
        case 'afegir':
            $descripcio = $_POST["descripcio"];
            $temps = $_POST["temps"];
            $visible = isset($_POST["visible"]) ? 1 : 0;
        
        // Insertar la nova actuació
            $sentenciaInsert = $mysqli->prepare("INSERT INTO ACTUACIO (idIncidencia, descripcio, temps, visible, data) VALUES (?, ?, ?, ?, NOW())");
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
            $visible2 = 1;

            $sentenciaInsert = $mysqli->prepare("INSERT INTO ACTUACIO (idIncidencia, descripcio, temps, visible, data) VALUES (?, ?, ?, ?, ?)");
            $sentenciaInsert->bind_param("isiis", $idIncidencia, $descripcio2, $temps2, $visible2, $data);

            $sentenciaUpdate = $mysqli->prepare("UPDATE INCIDENCIA SET dataFinalitzacio = ? WHERE idIncidencia = ?");
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

<div class="container justify-content-center row">
<div class="col-6 mt-5 text-center">
    <h3>Afegir Actuació</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="descripcio" class="form-label">Descripció</label>
            <textarea class="form-control" id="descripcio" name="descripcio" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="temps" class="form-label">Temps Invertit (min)</label>
            <input type="number" class="form-control" id="temps" name="temps" required>
        </div>

        <div class="mb-3">
                <input class="form-check-input" type="checkbox" id="visible" name="visible">
                <label class="form-check-label" for="visible">
                    Visible per al client
                </label>
        </div>

        <button type="submit" name="afegir" class="btn btn-primary">Afegir Actuació</button>
        <br>
        <button type="submit" name="resoldre" class="btn btn-danger m-2">Tancar Incidència</button>
    </form>
</div>


<div class="col-6 mt-5">
    <h3>Historial d'Actuacions</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Descripció</th>
                <th>Temps (minuts)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($actuacions)) { ?>
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
<?php
$idTecnic = $_GET["idTecnic"];
?>
<div class="position-fixed bottom-0 start-0 end-0 d-flex justify-content-center p-3">
    <a class="btn btn-danger mb-5" href="llistatIncidenciaTecnic.php?idTecnic=<?php echo $idTecnic ?>">Enrere</a>
</div>



<?php include_once "footer.php"; ?>