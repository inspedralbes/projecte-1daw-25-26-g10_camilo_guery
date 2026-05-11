<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$idIncidencia = $_GET["idIncidencia"];
$idTecnic = $_GET["idTecnic"];
$idIncidencia = (int)$idIncidencia;
$resultado = $mysqli->prepare("SELECT i.idIncidencia, i.descripcio, i.data, i.dataFinalitzacio, i.prioritat,
    d.nom AS nomDepartament, 
    t.nom AS nomTecnic, 
    p.nom AS nomTipus  
FROM INCIDENCIA i 
LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
LEFT JOIN TECNIC t ON i.idTecnic = t.idTecnic
LEFT JOIN TIPUS p ON i.idTipus = p.idTipus
WHERE idIncidencia = ?");

$resultado->bind_param("i", $idIncidencia);
$resultado->execute();

$resultadoQuery = $resultado->get_result();
$incidencias = $resultadoQuery->fetch_all(MYSQLI_ASSOC);
?>

<?php
$sentencia = $mysqli->prepare("SELECT descripcio, data, visible, idIncidencia FROM ACTUACIO WHERE idIncidencia = ? AND visible = 1");
$sentencia->bind_param("i", $idIncidencia);
$sentencia->execute();
$result = $sentencia->get_result();
$actuacions = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php if (empty($incidencias)) { ?>
    <p class="alert alert-danger">No s'ha trobat incidència amb aquest ID.</p>
<?php } else { ?>

<?php
foreach ($incidencias as $incidencia) {
$prioritat = match($incidencia["prioritat"]) {
    'Alta' => 'bg-danger',
    'Mitja' => 'bg-warning',
    'Baixa' => 'bg-info',
    default => 'bg-light'
};
?>
<div class="container pb-5">
    <div class="container mt-5 mb-5">
        <h3 class="text-center">Incidència amb ID:</h3>
        <h4 class="text-center text-muted"><?php echo $incidencia["idIncidencia"]; ?></h4>
        
        <div class="card" style="max-width: 350px; margin: 20px auto;">

            <div class="card-header <?php echo $prioritat; ?>">
            </div>

            <div class="card-body">
                
                <p>
                    <strong>Departament:</strong> 
                    <?php echo $incidencia["nomDepartament"]; ?>
                </p>

                <p>
                    <strong>Descripció:</strong> 
                    <?php echo $incidencia["descripcio"]; ?>
                </p>

                <p>
                    <strong>Data:</strong> 
                    <?php echo $incidencia["data"]; ?>
                </p>

                <p>
                    <strong>Tècnic:</strong> 
                    <?php echo $incidencia["nomTecnic"] ?? "No assignat"; ?>
                </p>

                <p>
                    <strong>Tipus:</strong> 
                    <?php echo $incidencia["nomTipus"] ?? "No assignat"; ?>
                </p>

                <p>
                    <strong>Data Finalització:</strong> 
                    <?php echo $incidencia["dataFinalitzacio"] ?? "No finalitzat"; ?>
                </p>

                <p>
                    <strong>Prioritat:</strong> 
                    <?php echo $incidencia["prioritat"] ?? "No assignada"; ?>
                </p>

            </div>
        </div>
    </div>
    <?php
    };
    ?>

    <?php if (!empty($actuacions)) { ?>
    <div class="">
        <h3 class="text-center">Historial d'Actuacions</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descripció</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($actuacions as $actuacio) { ?>
                    <tr>
                        <td><?php echo $actuacio["data"]; ?></td>
                        <td><?php echo $actuacio["descripcio"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hi ha actuacions enregistrades.</p>
    <?php } ?>
    </div>
    <?php }; ?>

    <div class="text-center mb-4 mt-2">
        <a class="btn btn-primary" href="llistatIncidenciaTecnic.php?idTecnic=<?php echo $idTecnic ?>">Tornar Enrere</a>
    </div>
</div>
<?php 
include_once "footer.php";
?>