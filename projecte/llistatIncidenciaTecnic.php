<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$idTecnic = $_GET["idTecnic"];
$sentencia = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data,
       d.nom AS nomDepartament,
       t.nom AS nomTipus,
       i.dataFinalitzacio, i.prioritat
FROM INCIDENCIA i
JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
JOIN TIPUS t ON i.idTipus = t.idTipus
WHERE i.idTecnic = ?");

$sentencia->bind_param("i", $idTecnic);
$sentencia->execute();

$result = $sentencia->get_result();
$incidencias = $result->fetch_all(MYSQLI_ASSOC);
# Obtenemos solo una fila, que será el videojuego a editar
if (!$incidencias) {
    echo "No hi ha incidències per a aquest tècnic.";
    include_once "footer.php";
    exit;
}
?>

 <table class="table">
        <thead>
            <tr>
                <th>Id d'Incidència</th>
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
            foreach ($incidencias as $incidencia) { ?>
                <tr>
                    <td><?php echo $incidencia["idIncidencia"] ?></td>
                    <td><?php echo $incidencia["descripcio"] ?></td>
                    <td><?php echo $incidencia["data"] ?></td>
                    <td><?php echo $incidencia["nomDepartament"] ?></td>
                    <td><?php echo $incidencia["nomTipus"] ?></td>
                    <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                    <td><?php echo $incidencia["prioritat"] ?></td>
                    <td><a href="actuacioIncidencia.php?idIncidencia=<?php echo $incidencia["idIncidencia"] ?>&idTecnic=<?php echo $idTecnic?>">Veure</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<form method="GET" action="gestionarIncidencia.php">
  <div class="input-group mt-2">
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