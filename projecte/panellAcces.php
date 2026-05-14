<?php
require_once "header.php";
require __DIR__ . '/vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: 'mongodb://user:user1234@mongo:27017/';
$client = new MongoDB\Client($uri);
$db = $client->gestorIncidencia;
$collection = $db->logs;

// Total de accesos
$totalAccesos = $collection->countDocuments([]);

// Páginas más visitadas
$paginesVisitades = $collection->aggregate([
    ['$group' => ['_id' => '$url', 'count' => ['$sum' => 1]]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);

// Usuarios más activos (IPs más frecuentes)
$ipsMasActivas = $collection->aggregate([
    ['$group' => ['_id' => '$ip', 'count' => ['$sum' => 1]]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);

// Accesos por día
$accesosPorDia = $collection->aggregate([
    ['$group' => [
        '_id' => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => ['$toDate' => '$timestamp']]],
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['_id' => 1]]
]);

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
?>

<div class="container p-4 mb-5">
    <div class="text-center">
        <h2>Panell d'Accès</h2>
    </div>

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