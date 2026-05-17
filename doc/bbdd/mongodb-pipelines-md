# 📊 Documentació MongoDB - Panell d'Accés

En aquesta pàgina s'utilitza MongoDB per emmagatzemar i analitzar els logs d'accés de l'aplicació.  
S'han implementat diferents pipelines d'agregació per obtenir estadístiques sobre les visites i els accessos.

---

# 🔎 Consultes principals

- Total d'accessos
- Pàgines més visitades
- IPs més actives
- Accessos per dia

---

# 📋 1 - Pàgines més visitades

Aquest pipeline agrupa tots els accessos segons la URL visitada i calcula quantes vegades s'ha accedit a cada pàgina.  
Posteriorment ordena els resultats de major a menor nombre de visites i limita el resultat a les 10 pàgines més visitades.

```php
$paginesVisitades = $collection->aggregate([
    ['$match' => $match],
    ['$group' => [
        '_id' => '$url',
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);
🔹 Funcionament del pipeline
$match

Filtra els documents segons els criteris seleccionats per l’usuari:

Pàgina concreta
Data inicial
Data final
['$match' => $match]
$group

Agrupa els registres per URL i compta el nombre d'accessos.

['$group' => [
    '_id' => '$url',
    'count' => ['$sum' => 1]
]]
$sort

Ordena les pàgines de més a menys visitades.

['$sort' => ['count' => -1]]
$limit

Limita el resultat a les 10 pàgines més visitades.

['$limit' => 10]
🌐 2 - IPs més actives

Aquest pipeline obté les IPs amb més activitat dins del sistema.

$ipsMasActivas = $collection->aggregate([
    ['$match' => $match],
    ['$group' => [
        '_id' => '$ip',
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);
🔹 Funcionament del pipeline
$match

Aplica els filtres seleccionats.

['$match' => $match]
$group

Agrupa per IP i compta els accessos.

['$group' => [
    '_id' => '$ip',
    'count' => ['$sum' => 1]
]]
$sort

Ordena les IPs de més activa a menys activa.

['$sort' => ['count' => -1]]
$limit

Mostra només les 10 IPs amb més activitat.

['$limit' => 10]
📅 3 - Accessos per dia

Aquest pipeline genera estadístiques diàries dels accessos al sistema.

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
🔹 Funcionament del pipeline
$match

Filtra els registres segons els criteris seleccionats.

['$match' => $match]
$group

Agrupa els accessos per data.

Converteix timestamp a data amb $toDate
Formata la data amb $dateToString
['$group' => [
    '_id' => [
        '$dateToString' => [
            'format' => '%Y-%m-%d',
            'date' => ['$toDate' => '$timestamp']
        ]
    ],
    'count' => ['$sum' => 1]
]]
$sort

Ordena cronològicament els resultats.

['$sort' => ['_id' => 1]]
📈 Gràfic d'accessos

Les dades del pipeline es converteixen en array:

$accesosPorDia = iterator_to_array($accesosPorDia);

Després es passen a JSON per JavaScript:

$dades = json_encode($accesosPorDia);

Aquestes dades s'utilitzen per generar un gràfic amb <canvas> que mostra:

Accessos per dia
Evolució temporal
Estadístiques visuals d'activitat