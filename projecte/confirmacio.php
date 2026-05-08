<?php
include_once "header.php";
?>

<div class="card">
    <div class="card-header pt-5">
    </div>
    <div class="card-body text-center mt-5">
        <h3 class="card-title">Incidència Registrada Correctament!</h3>
        
        <?php
        if (isset($_GET['id'])) {
            $idIncidencia = $_GET['id'];
            echo "<h5>El ID de la teva incidència es: <strong>" . $idIncidencia . "</strong></h5>";
        }
        ?>
        <p class="card-text">Guarda aquest ID per consultar l'estat de la teva incidència més endevant.</p>
        <br>
        <a href="persona.php" class="btn btn-primary mb-5">Tornar Enrere</a>
    </div>
</div>

<?php
include_once "footer.php";
?>