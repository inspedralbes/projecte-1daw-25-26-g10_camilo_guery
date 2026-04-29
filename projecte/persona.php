<?php 
$titulo = "Gestor d'Incidències - Persona";
include_once "header.php"; 
?>
    <header>

    </header>
    <main>
        <div>
            <div>
                <h3>Registrar Incidència</h3>
                <form action="registrar.php" method="POST">
                    <label for="idDepartament">Departament:</label>
                    <input type="text" name="idDepartament" id="idDepartament" placeholder="Introdueix l'ID del departament" required>
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
    </main>
<?php include_once "footer.php"; ?>
