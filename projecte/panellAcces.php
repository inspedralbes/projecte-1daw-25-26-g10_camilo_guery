<?php
require_once "header.php";
require __DIR__ . '/vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: 'mongodb://ususari:usuari1234@mongo:27017/';
$client = new MongoDB\Client($uri);
$db = $client->gestorIncidencia;
$collection = $db->logs;

$nomsUrl = [
    '/index.php' => 'Inici',
    '/incidenciesPendent.php' => 'Incidències Pendents',
    '/consultarIncidencia.php' => 'Consultar Incidència',
    '/panellAcces.php' => 'Panell d Accés',
    '/actuacioIncidendia.php' => 'Registrar Actuació',
    '/confirmacio.php' => 'Confirmació de Registre',
    '/filtrarTecnic.php' => 'Filtrar Tecnics',
    '/gestionarIncidencia.php' => 'Gestionar Incidència',
    '/llistatIncidenciaTecnic.php' => 'Llistat d Incidències per Tecnics',
    '/modificarIncidencies.php' => 'Pàgina Responsable Informàtic',
    '/professor.php' => 'Registrar Incidència',
    '/tecnic.php' => 'Llistat Tècnics',
];

// Filtres

$fechaInici = $_GET['fecha_inici'] ?? '';
$fechaFi = $_GET['fecha_fi'] ?? '';
$pagina = $_GET['pagina'] ?? '';

$filtres = [];

if($pagina) {
    $filtres['url'] = $pagina;
}


// Total de accesos
$totalAccesos = $collection->countDocuments($filtres);

// Páginas más visitadas
$paginesVisitades = $collection->aggregate([
    ['$match' => (object)$filtres],
    ['$group' => [
        '_id' => '$url', 'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);

// Usuarios más activos (IPs más frecuentes)
$ipsMasActivas = $collection->aggregate([
    ['$match' => (object)$filtres],
    ['$group' => [
        '_id' => '$ip', 'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);

// Accesos por día
$accesosPorDia = $collection->aggregate([
    ['$match' => (object)$filtres],
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
        <h2>Panell d'Accés</h2>
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

        <button type="submit">
            Filtrar
        </button>

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
// MongoDB retorna cursor
$accesosPorDia = $collection->aggregate([
        ['$match' => (object)$filtres],
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

// A ARRAY
$accesosPorDia = iterator_to_array($accesosPorDia);

$dades = json_encode($accesosPorDia);
?>
<hr class="m-5">
<div class="container d-flex justify-content-center mb-5">
    <h3>Gràfic d'Accesos per Día</h3>
</div>
<canvas id="grafic" width="1200" height="350" style="border:1px solid #ffffff;" class="container d-flex justify-content-center mb-5">
Your browser does not support the HTML canvas tag.
</canvas>

<script>
const dades = <?php echo $dades; ?>;
const canvas = document.getElementById('grafic');
const ctx = canvas.getContext('2d');

const altoMaximo = 200;
const valorMaximo = 500;
const espacioEntre = 80;
const posicionIzquierda = 40;
const posicionAbajo = 300;

//blocs, dada (count) i data (_id)
dades.forEach((dada, index) => {
    const altura = (dada.count / valorMaximo) * altoMaximo;
    const x = posicionIzquierda + index * espacioEntre;
    const y = posicionAbajo - altura;
    
    
    ctx.fillStyle = '#2077B4';
    ctx.fillRect(x + 5, y, 30, altura);

    ctx.fillStyle = '#103d5e';
    ctx.font = '14px Arial';
    ctx.fillText(dada.count, x + 5, y - 5);

    ctx.fillStyle = 'black';
    ctx.font = '14px Arial';
    ctx.textAlign = 'center';
    ctx.fillText(dada._id, x + 20, posicionAbajo + 20);
});            

const valores = [100, 200, 300, 400, 500];

//numeros verticals
valores.forEach(num => {
    const y = posicionAbajo - (num / valorMaximo) * altoMaximo;

    ctx.fillStyle = '#000';
    ctx.font = '12px Arial';
    ctx.textAlign = 'right';
    ctx.fillText(num, posicionIzquierda - 10, y + 5);
});

// Eix vertical
ctx.strokeStyle = '#000';
ctx.lineWidth = 1;
ctx.beginPath();
ctx.moveTo(posicionIzquierda - 5, 40);
ctx.lineTo(posicionIzquierda - 5, posicionAbajo);
ctx.stroke();

// Eix horitzontal
ctx.beginPath();
ctx.moveTo(posicionIzquierda - 5, posicionAbajo);
ctx.lineTo(1150, posicionAbajo);
ctx.stroke();
</script>

<?php
include_once "footer.php";
?>