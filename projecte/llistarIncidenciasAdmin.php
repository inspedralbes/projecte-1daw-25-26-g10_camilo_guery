<?php
include_once "header.php";
$mysqli = include_once "conexio.php";
$resultadoIncidencia = $mysqli->query("SELECT idIncidencia, descripcio, data, idDepartament, idTecnic, idTipo, dataFinalitzacio, prioritat FROM INCIDENCIA");
$incidencias = $resultadoIncidencia->fetch_all(MYSQLI_ASSOC);
$resultadoTecnicos = $mysqli->query("SELECT idTecnic, nom FROM TECNIC");
$tecnicos = $resultadoTecnicos->fetch_all(MYSQLI_ASSOC);
?>
<form action="actualitzar.php" method="POST">
    <table>
        <thead>
            <tr>
                <th>Id d'Incidencia</th>
                <th>Descripcio</th>
                <th>Data</th>
                <th>Departament</th>
                <th>Tecnic</th>
                <th>Tipo</th>
                <th>Data Finalitzacio</th>
                <th>Prioritat</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($incidencias as $incidencia) { ?>
                <tr>
                    <td><?php echo $incidencia["idIncidencia"] ?></td>
                    <td><?php echo $incidencia["descripcio"] ?></td>
                    <td><?php echo $incidencia["data"] ?></td>
                    <td><?php echo $incidencia["idDepartament"] ?></td>
                    <td>
                        <select name="idTecnic[<?php echo $incidencia["idIncidencia"]; ?>]">
                            <option value="" <?php echo ($incidencia["idTecnic"] == null) ? "selected" : ""; ?>>
                                Sin asignar
                            </option>
                            <?php foreach ($tecnicos as $tecnico) { ?>
                                <option value="<?php echo $tecnico["idTecnic"]; ?>"
                                    <?php echo ($tecnico["idTecnic"] == $incidencia["idTecnic"]) ? "selected" : ""; ?>>
                                    <?php echo $tecnico["nom"]; ?>
                                </option>
                            <?php } ?>

                        </select>
                    </td>
                    <td><?php echo $incidencia["idTipo"] ?></td>
                    <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                    <td><?php echo $incidencia["prioritat"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <input type="submit" value="Guardar cambios">
</form>
        <a class="" href="index.html">Volver</a>