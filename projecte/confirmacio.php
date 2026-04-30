<?php
include_once "header.php";
?>

<main>
    <div>
        <h3>Incidència Registrada Correctament!</h3>
        
        <?php
        if (isset($_GET['id'])) {
            $idIncidencia = $_GET['id'];
            echo "<p>El ID de la teva incidència es: <strong>" . $idIncidencia . "</strong></p>";
            echo "<p>Guarda aquest ID per consultar l'estat de la teva incidència més endevant.</p>";
        }
        ?>
        
        <a href="persona.php">Tornar Enrere</a>
    </div>
</main>

<?php
include_once "footer.php";
?>