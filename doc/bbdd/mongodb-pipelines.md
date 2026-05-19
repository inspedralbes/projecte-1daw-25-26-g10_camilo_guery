# 📊 Documentació de Pipelines d'Agregació (MongoDB)

Aquest document detalla els processos d'agregació utilitzats per generar les estadístiques del **Panell d'Accés**. Tots els pipelines incorporen un estadi de filtratge dinàmic previ.

---

## 🌐 1- Pàgines més visitades
**Objectiu:** Identificar el contingut més popular de la web mitjançant el recompte de clics per URL.

Aquest pipeline analitza quines seccions de l'aplicació tenen més trànsit. Agrupa els documents per la seva URL, calcula el total de visites per cada una i retorna el **Top 10** en ordre descendent.

```php
$paginesVisitades = $collection->aggregate([
    ['$match' => $match], // Filtre dinàmic aplicat per l'usuari
    ['$group' => [
        '_id' => '$url',
        'count' => ['$sum' => 1] // Suma 1 per cada coincidència
    ]],
    ['$sort' => ['count' => -1]], // Ordena de més a menys visites
    ['$limit' => 10] // Limita el resultat als 10 primers
]);
```

---

## 💻 2- IPs més actives
**Objectiu:** Detectar l'origen de la càrrega del servidor per identificar usuaris intensius, bots o possibles atacs.

Pipeline dissenyat per identificar l'origen de les peticions. Agrupa els registres per l'adreça IP del client per detectar quins nodes estan generant més activitat al servidor de logs.

```php
$ipsMasActivas = $collection->aggregate([
    ['$match' => $match],
    ['$group' => [
        '_id' => '$ip',
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 10]
]);
```

---

## 📅 3- Accessos cronològics per dia
**Objectiu:** Mostrar l'evolució temporal del trànsit per analitzar tendències de comportament segons el dia.

Aquest pipeline realitza una transformació de dades. Converteix el camp `timestamp` (BSON) a un format de cadena llegible (`YYYY-MM-DD`) per poder agrupar els accessos per dies naturals i generar una línia temporal.

```php
$accesosPorDia = $collection->aggregate([
    ['$match' => $match],
    ['$group' => [
        '_id' => [
            '$dateToString' => [
                'format' => '%Y-%m-%d',
                'date' => ['$toDate' => '$timestamp'] // Conversió a objecte Date
            ]
        ],
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['_id' => 1]] // Ordenació cronològica ascendent
]);
```

---

## ⚙️ Estadi Comú: $match
**Objectiu:** Reduir el volum de dades inicial per optimitzar el rendiment de la base de dades eliminant registres innecessaris.

Tots els pipelines utilitzen la variable `$match` com a primer estadi. Aquesta variable conté l'objecte de filtres (dates i pàgina) per optimitzar la consulta i processar només les dades sol·licitades.
```php
// Exemple de l'estat del filtre abans de l'agregació
$match = (object)[
    'url' => '/index.php',
    'timestamp' => ['$gte' => UTCDateTime, '$lte' => UTCDateTime]
];
```
