# Resum de Gestió del Projecte (TAIGA)

Aquest document sintetitza els objectius de desenvolupament i el conjunt de tasques planificades per a l'aplicació de gestió d'incidències, organitzades cronològicament per sprints.

---

## 📋 SPRINT 0: Infraestructura, Disseny i Planificació
*Objectiu: Establir les bases tècniques, el model de dades inicial i el flux de treball de l'equip.*

* **Gestió i Backlog:** Creació del projecte a TAIGA i organització de les tasques inicials.
* **Base de Dades:** Disseny de l'esquema E/R i creació de les taules mestres (`tècnics`, `departaments`, `tipus`) amb dades de prova.
* **DevOps:** Configuració del repositori de GitHub compartit.
* **Disseny Conceptual:** Disseny del diagrama de casos d’ús i de l’esquema inicial de pantalles (mockups).

---

## 🚀 SPRINT 1: Funcionalitats Bàsiques i CRUD Inicial
*Objectiu: Implementar la interfície d'inici i les operacions essencials de creació, lectura i edició d'incidències.*

* **Landing Page:** Creació d'una pàgina inicial amb un índex de navegació general.
* **Registre (INSERT):** Creació de la taula `incidència`, formulari HTML de registre i connexió amb el backend per inserir dades.
* **Llistat Administrador (SELECT):** Pàgina de consulta senzilla amb totes les incidències registrades per a supervisió.
* **Gestió (UPDATE):** Pàgina de lectura i formulari de modificació restringit (només per assignar prioritat, tipus i tècnic).

---

## 🔄 SPRINT 2: Resolució, Històric i Disseny Visual
*Objectiu: Permetre la interacció dels tècnics, el seguiment dels professors i aplicar una capa de disseny professional.*

* **Tancament d'Incidències:** Pantalla de lectura per ID d'incidència i lògica amb selector de data per marcar-la com a resolta.
* **Històric d'Actuacions:** Accés per ID i formulari per afegir el detall de les actuacions tècniques realitzades.
* **Consulta de l'Usuari:** Retorn de l'ID en crear la incidència, formulari de cerca d'estat i llistat de les actuacions visibles.
* **Identitat Visual (UX/UI):** Maquetació estructural amb components reutilitzables (*includes*/*partials*) i aplicació global del framework Bootstrap.

---

## 📊 SPRINT 3: Informes, Validació Avançada, Usabilitat i Accessibilitat
*Objectiu: Optimitzar el panell de gestió, afegir seguretat en el client, generar mètriques i garantir l'accés universal.*

* **Priorització Visual:** Redisseny del llistat d'incidències amb codis de colors i ordenació automàtica segons la gravetat.
* **Mòdul Analític:** Codificació de dues pàgines d'informes per analitzar la resolució dels tècnics i el consum per departaments.
* **Validació (JS):** Control d'errors al navegador per evitar camps buits en incidències i requerir un mínim de 20 caràcters en actuacions.
* **Accessibilitat (A11y):** Implementació d'etiquetes `aria-label`, revisió del contrast de colors (WCAG) i optimització de la navegació per teclat (`tabindex`).
* **Experiència d'Usuari (UX):** Integració d'alertes de confirmació tipus "Toasts" i disseny de pàgines d'error personalitzades.
