<?php
$titulo = "Gestor d'Incidències - Modificació d'Incidències";
include_once "header.php";
$mysqli = include_once "conexio.php";
$resultadoIncidencia = $mysqli->query("SELECT i.idIncidencia, i.descripcio, i.data,
       d.nom AS nomDepartament,
       i.idTecnic, i.idTipus,
       i.dataFinalitzacio, i.prioritat
FROM INCIDENCIA i
LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament");
$incidencias = $resultadoIncidencia->fetch_all(MYSQLI_ASSOC);
$resultadoTecnicos = $mysqli->query("SELECT idTecnic, nom FROM TECNIC");
$tecnicos = $resultadoTecnicos->fetch_all(MYSQLI_ASSOC);
$resultadoTipus = $mysqli->query("SELECT idTipus, nom FROM TIPUS");
$tipus = $resultadoTipus->fetch_all(MYSQLI_ASSOC);
?>
<form action="actualitzar.php" method="POST">
    <table>
        <thead>
            <tr>
                <th>Id d'Incidència</th>
                <th>Descripció</th>
                <th>Data</th>
                <th>Departament</th>
                <th>Tècnic</th>
                <th>Tipus</th>
                <th>Data Finalització</th>
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
                    <td><?php echo $incidencia["nomDepartament"] ?></td>
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
                    <td>
                        <select name="idTipus[<?php echo $incidencia["idIncidencia"]; ?>]">
                            <option value="" <?php echo ($incidencia["idTipus"] == null) ? "selected" : ""; ?>>
                                Sin asignar
                            </option>
                            <?php foreach ($tipus as $tipo) { ?>
                                <option value="<?php echo $tipo["idTipus"]; ?>"
                                    <?php echo ($tipo["idTipus"] == $incidencia["idTipus"]) ? "selected" : ""; ?>>
                                    <?php echo $tipo["nom"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><?php echo $incidencia["dataFinalitzacio"] ?></td>
                    <td>
                        <select name="prioritat[<?php echo $incidencia["idIncidencia"]; ?>]">
                            <option value="" <?php echo ($incidencia["prioritat"] == null) ? "selected" : ""; ?>>
                                Sin asignar
                            </option>
                            <option value="Alta" <?php echo ($incidencia["prioritat"] == "Alta") ? "selected" : ""; ?>>
                                Alta
                            </option>
                            <option value="Mitja" <?php echo ($incidencia["prioritat"] == "Mitja") ? "selected" : ""; ?>>
                                Mitja
                            </option>
                            <option value="Baixa" <?php echo ($incidencia["prioritat"] == "Baixa") ? "selected" : ""; ?>>
                                Baixa
                            </option>
                        </select>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <input type="submit" value="Guardar cambios">
</form>
        <a class="" href="index.php">Volver</a>