<?php
require_once "header.php";
require __DIR__ . '/vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: 'mongodb://ususari:usuari1234@mongo:27017/';
$client = new MongoDB\Client($uri);
$db = $client->gestorIncidencies;
$collection = $db->logs;

$nomsUrl = [
    '/index.php' => 'Inici',
    '/incidenciesPendent.php' => 'Incidències Pendents',
    '/consultarIncidencia.php' => 'Consultar Incidència',
    '/panellAcces.php' => 'Panell d Accès',
    '/actuacioIncidendia.php' => 'Registrar Actuació',
    '/confirmacio.php' => 'Confirmació de Registre',
    '/filtrarTecnic.php' => 'Filtrar Tecnics',
    '/gestionarIncidencia.php' => 'Gestionar Incidència',
    '/llistatIncidenciaTecnic.php' => 'Llistat d Incidències per Tecnics',
    '/modificarIncidencies.php' => 'Pàgina Responsable Informàtic',
    '/professor.php' => 'Registrar Incidència',
    '/tecnic.php' => 'Llistat Tècnics',
];

// =====================
// FILTROS
// =====================
$fechaInici = $_GET['fecha_inici'] ?? '';
$fechaFi = $_GET['fecha_fi'] ?? '';
$pagina = $_GET['pagina'] ?? '';

$filtres = [];

// filtro por página
if ($pagina) {
    $filtres['url'] = $pagina;
}

// filtro por fechas
if ($fechaInici || $fechaFi) {

    $timestamp = [];

    if ($fechaInici) {
        $timestamp['$gte'] = new MongoDB\BSON\UTCDateTime(
            strtotime($fechaInici . ' 00:00:00') * 1000
        );
    }

    if ($fechaFi) {
        $timestamp['$lte'] = new MongoDB\BSON\UTCDateTime(
            strtotime($fechaFi . ' 23:59:59') * 1000
        );
    }

    if (!empty($timestamp)) {
        $filtres['timestamp'] = $timestamp;
    }
}

// FIX IMPORTANTE PARA MONGODB
if (empty($filtres)) {
    $match = new stdClass();
} else {
    $match = (object)$filtres;
}

// =====================
// CONSULTAS
// =====================

// Total accesos
$totalAccesos = $collection->countDocuments($filtres);

// Páginas más visitadas
$paginesVisitades = $collection->aggregate([
    ['$match' => $match],
    ['$group' => [
        '_id' => '$url',
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);

// IPs más activas
$ipsMasActivas = $collection->aggregate([
    ['$match' => $match],
    ['$group' => [
        '_id' => '$ip',
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);

// Accesos por día
$accesosPorDia = $collection->aggregate([
    ['$match' => $match],
    ['$group' => [
        '_id' => [
            '$dateToString' => [
                'format' => '%Y-%m-%d',
                'date' => ['$toDate' => '$timestamp']
            ]
        ],
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['_id' => 1]]
]);

?>

<div class="container p-4 mb-5">
    <div class="text-center">
        <h2>Panell d'Accès</h2>
    </div>

    <form method="GET" class="mb-4">

        <select name="pagina">
            <option value="">Todas las páginas</option>

            <?php foreach ($nomsUrl as $url => $nom): ?>
                <option value="<?php echo $url; ?>"
                    <?php echo ($pagina == $url) ? 'selected' : ''; ?>>
                    <?php echo $nom; ?>
                </option>
            <?php endforeach; ?>

        </select>

        <label>Desde:</label>
        <input type="date" name="fecha_inici" value="<?php echo $fechaInici; ?>">

        <label>Hasta:</label>
        <input type="date" name="fecha_fi" value="<?php echo $fechaFi; ?>">

        <button type="submit">Filtrar</button>

    </form>

    <div class="p-3" style="background-color: gainsboro;">
        <h3>Total d'Accesos: <?php echo $totalAccesos; ?></h3>
    </div>

    <hr>

    <h3>Páginas més visitades</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>URL</th>
                    <th>Visites</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paginesVisitades as $pagina): ?>
                    <tr>
                        <td><?php echo $nomsUrl[$pagina['_id']] ?? $pagina['_id']; ?></td>
                        <td><?php echo $pagina['count']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h3>IPs més activas</h3>
    <table class="table">
        <thead>
            <tr>
                <th>IP</th>
                <th>Accesos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ipsMasActivas as $ip): ?>
                <tr>
                    <td><?php echo $ip['_id']; ?></td>
                    <td><?php echo $ip['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Accesos per día</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Accesos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accesosPorDia as $dia): ?>
                <tr>
                    <td><?php echo $dia['_id']; ?></td>
                    <td><?php echo $dia['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include_once "footer.php";
?>