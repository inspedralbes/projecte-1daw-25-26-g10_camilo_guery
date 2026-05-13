<?php 
$titulo = "Gestor d'Incidències - Persona";
include_once "header.php"; 
?>
    <main class="container">
        <div class="d-flex justify-content-center py-5">
            <div class="me-5">
                <h3>Registrar Incidència</h3>
                <form action="registrar.php" method="POST">
                    <label for="idDepartament" class="d-block">Departament:</label>
                    <input type="text" name="idDepartament" id="idDepartament" placeholder="Introdueix l'ID del departament" required>
                    <br>
                    <label for="descripcio" class="d-block">Descripcio:</label>
                    <textarea name="descripcio" id="descripcio" placeholder="Incidència: ">
                    </textarea>
                    <br>
                    <input type="submit" value="Enviar"  class="btn btn-dark">
                </form>
            </div>
            <div>
                <h3>Consultar Incidència</h3>
                <form action="consultarIncidencia.php" method="POST">
                    <label for="idIncidencia" class="d-block">ID de l'incidència: </label>
                    <input type="number" name="idIncidencia" id="idIncidencia" placeholder="ID d'Incidencia: ">
                    <br>
                    <input type="submit" value="Enviar" class="btn btn-dark mt-2">
                </form>
            </div>
        </div>
        <a href="index.php" class="btn btn-primary">Tornar enrere</a>
    </main>
<?php include_once "footer.php"; ?>