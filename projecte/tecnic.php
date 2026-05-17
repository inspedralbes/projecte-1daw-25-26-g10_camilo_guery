<?php 
$titulo = "Gestor d'Incidències | Tècnics";
include_once "header.php"; 
$mysqli = include_once "conexio.php";
$resultadoTecnicos = $mysqli->query("SELECT idTecnic, nom FROM TECNIC");
$tecnicos = $resultadoTecnicos->fetch_all(MYSQLI_ASSOC);
?>
    <div class="text-center m-5">
    <h1>Qui ets?</h1>
    </div>


    <div class="justify-content-center d-flex">
        <div class="d-grid gap-3" style="width: 300px;">
            <?php foreach ($tecnicos as $tecnico) { ?>
               <a href="llistatIncidenciaTecnic.php?idTecnic=<?php echo $tecnico["idTecnic"] ?>" class="btn btn-warning">  <?php echo $tecnico["nom"]; ?> </a>
            <?php } ?>
            <a class="btn btn-primary m-4" href="index.php">Tornar enrere</a>
        </div>
    </div>    
<?php include_once "footer.php"; ?>
