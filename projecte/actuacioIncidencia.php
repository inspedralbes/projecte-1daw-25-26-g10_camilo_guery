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
    $descripcio = $_POST["descripcio"];
    $temps = $_POST["temps"];
    $visible = isset($_POST["visible"]) ? 1 : 0;
    
    // Insertar la nueva actuación
    $sentenciaInsert = $mysqli->prepare("INSERT INTO ACTUACIO (idIncidencia, descripcio, temps, visible, data) VALUES (?, ?, ?, ?, NOW())");
    $sentenciaInsert->bind_param("isii", $idIncidencia, $descripcio, $temps, $visible);
    
    if ($sentenciaInsert->execute()) {
        echo "<div class='alert alert-success'>Actuació afegida correctament.</div>";
        header("Refresh:0");
    } else {
        echo "<div class='alert alert-danger'>Error al afegir l'actuació.</div>";
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

        <button type="submit" class="btn btn-primary">Agregar Actuació</button>
        <br>
        <button type="submit" name="resuelta" class="btn btn-success m-2">Marcar com a Resolta</button>
    </form>
</div>



<?php if (!empty($actuacions)) { ?>
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

<?php include_once "footer.php"; ?>