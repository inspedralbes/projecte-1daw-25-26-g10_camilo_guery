# 📊 Panell d'Accés - Documentació MongoDB

S'ha utilitzat MongoDB per analitzar els logs d'accés de l'aplicació.
A més s'han implementat diferents pipelines d'agregació per obtenir estadístiques sobre l'ús del sistema.

---

## 🔎 Consultes principals
- Pàgines més visitades
- IPs més actives
- Accessos per dia
- Filtres per pàgina i dates

---

## 📋 1- Pàgines més visitades

Aquest pipeline agrupa els accessos per URL i calcula quantes vegades s'ha visitat cada pàgina.
Després ordena els resultats de més a menys visites i mostra les 10 primeres.


$paginesVisitades = $collection->aggregate([
['$match' => $match],
['$group' => [
'_id' => '$url',
'count' => ['$sum' => 1]
]],
['$sort' => ['count' => -1]],
['$limit' => 10]
]);


---

## 🌐 2- IPs més actives

Aquest pipeline agrupa els logs per IP i calcula quines IPs han realitzat més accessos al sistema.
Posteriorment ordena i mostra les 10 IPs més actives.


$ipsMasActivas = $collection->aggregate([
['$match' => $match],
['$group' => [
'_id' => '$ip',
'count' => ['$sum' => 1]
]],
['$sort' => ['count' => -1]],
['$limit' => 10]
]);


---

## 📅 3- Accessos per dia

Aquest pipeline agrupa els accessos per data i genera estadístiques diàries.
Converteix el timestamp a format data per poder agrupar correctament.


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


---

## 📌 4- Filtre general ($match)

Aquest filtre s'aplica a tots els pipelines per restringir les dades segons:
- pàgina seleccionada
- rang de dates
- altres paràmetres


['$match' => $match]


---

## 📊 Resum

Els pipelines permeten obtenir estadístiques clares sobre:
- ús de l'aplicació
- pàgines més consultades
- activitat per IP
- evolució diària dels accessos