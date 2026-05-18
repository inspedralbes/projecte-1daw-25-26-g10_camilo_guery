<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$idIncidencia = $_GET['id'];
$idIncidencia = (int)$_GET['id']; 
$resultado = $mysqli->prepare("SELECT i.idDepartament, i.descripcio, 
d.nom AS nomDepartament 
FROM INCIDENCIA i
JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
WHERE idIncidencia = ?
");

$resultado->bind_param("i", $idIncidencia);
$resultado->execute();

$resultadoQuery = $resultado->get_result();
$incidencias = $resultadoQuery->fetch_all(MYSQLI_ASSOC);
?>

<div class="container text-center py-5">
    <div class="card text-center">
        <div class="mt-5">
            <div class="text-success mb-3">✓</div>
            <h3>Incidència Registrada Correctament!</h3>
            <h4 >ID:
            <?php
            if (isset($_GET['id'])) {
                echo "<strong>" . $idIncidencia . "</strong>";
            }
            ?>
            </h4>
            <p class="text-muted">Guarda l'Id per futures consultes</p>
        </div>
        
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body">
            <p class="card-text">
            <?php
            foreach ($incidencias as $incidencia) {
            ?>
            <strong>Departament: </strong><?php echo $incidencia["nomDepartament"]?>
            <br>
            <strong>Descripció: </strong><?php echo $incidencia["descripcio"]?>
            <?php }; ?>
            </p>
        </div>
    </div>
    <div class=" mt-4 mb-5">
    <a href="professor.php" class="btn btn-primary m-2">Tornar Enrere</a>
    <div>
</div>

<?php
include_once "footer.php";
?>