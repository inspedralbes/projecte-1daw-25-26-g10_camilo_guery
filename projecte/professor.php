<?php 
$titulo = "Gestor d'Incidències - Professor";
include_once "header.php"; 
$mysqli = include_once "conexio.php";
$resultadoDepartaments = $mysqli->query("SELECT idDepartament, nom FROM DEPARTAMENT");
$departaments = $resultadoDepartaments->fetch_all(MYSQLI_ASSOC);
?>
<div class="row justify-content-center container mb-3">
    <div class="col-lg-8 col-md-10 mt-5 d-md-flex gap-3">
        <div class="form-floating mb-3" style="flex-basis: 60%;">
            <h3 class="border-bottom border-3 border-dark d-inline-block pb-1 mb-2">Registrar Incidència</h3>
            <em class="text-danger d-block"><sup>*</sup>Camps obligatoris</em>
            <form action="registrar.php" method="POST">
                <label for="idDepartament">Departament: <sup class="text-danger">*</sup></label>
                <select class="form-select" for="idDepartament" name="idDepartament" id="idDepartament" aria-label="Departament" required>
                    <option selected hidden>Tria un: </option>
                    <?php foreach ($departaments as $departament) { ?>
                        <option value="<?php echo $departament["idDepartament"] ?>"><?php echo $departament["nom"]; ?></option>
                    <?php } ?>
                </select>
                <br>
                <label for="descripcio">Descripció: <sup class="text-danger">*</sup></label>
                <textarea class="form-control" name="descripcio" id="descripcio" placeholder="Descripció de l'incidència" rows="3" aria-label="Descripció"></textarea>
                <br>
                <input class="btn btn-success" type="submit" value="Enviar">
            </form>
        </div>
        <div style="flex-basis: 40%;">
            <h3 class="border-bottom border-3 border-dark d-inline-block pb-1 mb-4">Consultar Incidència</h3>
            <br>
            <span>Col·loca l'id de la teva incidència: </span>
            <form action="consultarIncidencia.php" method="POST">
                <div class="input-group mt-2">
                    <label class="input-group-text" for="idIncidencia">ID</label>
                    <input type="text" class="form-control" name="idIncidencia" id="idIncidencia" placeholder="ID d'Incidencia: " aria-label="Id d'Incidencia">
                </div>
                <br>
                <button type="submit" value="Enviar" class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once "footer.php"; ?>