## 📁 Estructura del Projecte

* **projecte/**: Aqui es on esta la aplicació.
  * **css/**: Fulls d'estil.
     * `style.css`: Full d'estils on hi ha les classes amb display block i none.
  * **js/**: Validacions i funcions JavaScript.
    * `script`: Mòdul per commutar pestanyes ocultant `.window-info` i activant la vista seleccionada.
  * **header.php y footer.php/**: Capçalera i peu de pàgina comuns.
  * **index.php**: Pàgina d'inici.
  * **professor.php / tecnic.php / modificarIncidencies.php**: Menús segons el rol i en el cas de modificarIncidencies.php aquesta la gestió de totes les incidències.
  * **actualitzar.php / registrar.php**: Arxius que inserten y actualitzen les dades en la base de dades.
  * **logger.php**: Arxiu que agafa e inserta els logs a mongodb.
  * **panellAcces**: Pàgina que mostra el consum i el acces de totes les pàgines.
  * **llistatIncidenciaTecnic**: Mostra les incidencies nomes per el tecnic escogit.
  * **incidenciesPendents**: Mostra les incidencies pendentes i permet filtrar-les per tecnic.
  * **gestionarIncidencia.php**: Pàgina que permet veure les dades y actuacions d'una incidència per el seu ID desde l'apartat de tècnics.
  * **consultarIncidencia.php**: Permet veure l'usuari normal mitjançant l'id de la seva incidència, les dades i les seves actuacions.
  * **confirmacio.php**: Alerta que diu que l'incidencia s'ha creat correctament y mostra l'ID de l'incidència.
  * **actuacioIncidencia.php**: Pàgina que permet afegir una actuacio a una incidència.
* **sql/init.sql**: Script SQL per inicialitzar la base de dades.
* **doc/**: Documentació del sistema.
* **docker-compose.yml**: Configuració de l'entorn Docker per poder aixecar-lo.

## 🛠️ Funcionalitats Implementades

### Gestió d'Incidencies
- Obertura de noves peticions detallant el departament i el problema
- Ajust de la prioritat, tecnic i tipus per el responsable
- Consulta de la fitxa completa i de l'estat de l'incidència
- Resolució i finalització del cas per part del personal de suport

### Seguidament de la Incidència
- Incorporar actuacions al registre del full de ruta
- Restricció de comentaris interns perquè no els vegi el client
- Sumatori automàtic de les hores invertides en cada problema

### Auditoria del Sistema (MongoDB)
- Emmagatzematge continu de cada entrada a la plataforma
- Cerca d'historial per rang de dates, perfil i pantalla visitada
- Analítica visual de l'activitat d'usuaris per jornades

### Analítica i Rendiment
- Balanç de recursos utilitzats segons el sector i el professional
- Quadre de comandament amb mètriques d'ús i mètriques globals