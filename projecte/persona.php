<?php 
$titulo = "Gestor d'Incidències - Persona";
include_once "header.php"; 
$mysqli = include_once "conexio.php";
$resultadoDepartaments = $mysqli->query("SELECT idDepartament, nom FROM DEPARTAMENT");
$departaments = $resultadoDepartaments->fetch_all(MYSQLI_ASSOC);
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 mt-5">
            <div class="form-floating mb-3">
                <h3>Registrar Incidència</h3>
                <form action="registrar.php" method="POST">
                    <select class="form-select" for="idDepartament" name="idDepartament" id="idDepartament" required>
                    <option selected>Departament:</option>
                    <?php foreach ($departaments as $departament) { ?>
                        <option value="<?php echo $departament["idDepartament"] ?>"><?php echo $departament["nom"]; ?></option>
                    <?php } ?>
                    </select>
                    <br>
                    <label for="descripcio">Descripcio</label>
                    <textarea class="form-control" name="descripcio" id="descripcio" placeholder="Incidència: "  rows="3">
                    </textarea>
                    <br>
                    <input class="btn btn-success" type="submit" value="Enviar">
                </form>
            </div>
            <div>
                <h3>Consultar Incidència</h3>
                <form action="consultarIncidencia.php" method="POST">
                    <div class="input-group mt-2">
                        <span class="input-group-text">ID</span>
                        <input type="text" class="form-control" name="idIncidencia" id="idIncidencia" placeholder="ID d'Incidencia: ">
                    </div>
                    <br>
                    <button type="submit" value="Enviar" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "footer.php"; ?>