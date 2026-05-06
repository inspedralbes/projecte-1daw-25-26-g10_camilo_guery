<?php 
$titulo = "Gestor d'Incidències - Persona";
$mysqli = include_once "conexio.php";

$result = $mysqli->prepare("SELECT idDepartament, nom FROM DEPARTAMENT");
$result->execute();
$resultDepartaments = $result->get_result();
$departaments = $resultDepartaments->fetch_all(MYSQLI_ASSOC);

?>

<?php
include_once "header.php"; 
?>

        <div>
            <div>
                <h3>Registrar Incidència</h3>
                <form action="registrar.php" method="POST">
                    <label for="idDepartament">Departament:</label>
                    <select name="select">
                    <?php foreach($departaments as $departament) {?>
                    <option value=<?php echo $departament ["idDepartament"]?>> <?php echo $departament["nom"]; ?> </option>
                    <?php } ?>
                    </select>

                    <br>
                    <label for="descripcio">Descripcio</label>
                    <textarea name="descripcio" id="descripcio" placeholder="Incidència: ">

                    </textarea>
                    <br>
                    <input type="submit" value="Enviar">
                </form>

            </div>
            <div>
                <h3>Consultar Incidència</h3>
                <form action="consultarIncidencia.php" method="POST">
                    <label for="idIncidencia">ID de l'incidència</label>
                    <input type="number" name="idIncidencia" id="idIncidencia" placeholder="ID d'Incidencia: ">
                    <input type="submit" value="Enviar">
                </form>
            </div>
        </div>
        <a href="index.php">Tornar enrere</a>

<?php include_once "footer.php"; ?>
