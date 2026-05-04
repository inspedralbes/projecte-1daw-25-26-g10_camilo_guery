<?php 
$titulo = "Gestor d'Incidències - Llistat de Tècnics";
include_once "header.php"; 
$mysqli = include_once "conexio.php";
$resultadoTecnicos = $mysqli->query("SELECT idTecnic, nom FROM TECNIC");
$tecnicos = $resultadoTecnicos->fetch_all(MYSQLI_ASSOC);
?>
    <main>
        <div>
            <ul>
                <?php foreach ($tecnicos as $tecnico) { ?>
                   <a href="llistatTecnic.php?idTecnic=<?php echo $tecnico["idTecnic"] ?>"> <li> <?php echo $tecnico["nom"]; ?> </li> </a>
                <?php } ?>
            </ul>
        </div>
    </main>    
<?php include_once "footer.php"; ?>
