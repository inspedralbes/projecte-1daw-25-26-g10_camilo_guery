# 🛠️ Gestor d'Incidències (Grup 10)

Una solució web integral i eficient dissenyada per centralitzar, optimitzar i fer el seguiment de la resolució d'incidències tècniques i de manteniment dins de l'entorn educatiu.

---

## 👥 Integrants del Projecte
*   **Camilo Prado**
*   **Guery Rodríguez**

---

## 📝 Descripció del Projecte

Aquesta aplicació web estructura la gestió de problemes i avaries mitjançant un sistema de rols clarament definits per garantir un flux de treball àgil i organitzat:

*   **Professors:** Poden reportar noves incidències de forma ràpida i consultar en temps real l'estat dels seus tiquets enviats.
*   **Responsables:** Administren la plataforma, reben les alertes, prioritzen els problemes i assignen les tasques als tècnics disponibles.
*   **Tècnics:** Visualitzen les tasques assignades al seu perfil, gestionen el procés de reparació i es responsabilitzen de tancar-les un cop solucionades.

---

## 🔗 Enllaços de l'Ecosistema


| Recurs | Descripció | Enllaç d'Accés |
| :--- | :--- | :--- |
| 📊 **Gestor de Tasques** | Planificació i Sprint Backlog a Taiga | [Accedir al Taiga](https://tree.taiga.io/project/a25guerodmar-daw1pj10/timeline) |
| 🎨 **Prototip Gràfic** | Disseny d'interfície i fluxos a Penpot | [Veure Disseny Penpot](https://design.penpot.app/#/view?file-id=1060707d-bef0-807f-8007-eae2d755747a&page-id=1060707d-bef0-807f-8007-eae2d755747b&section=interactions&frame-id=b106cf31-2ecd-80dd-8007-eae2d9c94101&index=0&interactions-mode=show&share-id=8043e0a6-4681-8067-8007-eb06efb231b9) |
| 🌐 **Plataforma Online** | Entorn de producció operatiu | [Visitar Aplicació Web](http://g10.daw.inspedralbes.cat/) |

---

## 📈 Estat del Projecte

🟢 **Finalitzat i Operatiu**

El nucli del sistema està completament desenvolupat i supera les proves de funcionament crítiques, complint amb els fluxos d'usuari principals de manera correcta.

### 🚀 Futures Millores
Com a línies de treball futures per fer créixer el programari, es plantegen:
*   **Evolució Estètica:** Polir detalls visuals de la interfície de l'usuari per aconseguir un disseny més modern i intuïtiu.
*   **Noves Funcionalitats:** Implementar sistemes de notificacions automàtiques per correu electrònic o panells gràfics estadístics més avançats per als responsables.


# 🗺️ Guia de Desplegament i Requisits

Per posar en marxa el **Gestor d'Incidències**, l'ecosistema utilitza una arquitectura en contenidors que facilita la seva execució immediata sense configuracions manuals al sistema local.

---

## 📌 Requisits del Sistema

Abans de començar, assegura't de disposar del següent programari:
*   **Motor de Contenidors:** Docker juntament amb la utilitat Docker Compose.
*   **Entorn d'Execució:** PHP (versió 8.0 o posterior recomanada per compatibilitat).
*   **Client Web:** Qualsevol navegador d'última generació (Chrome, Firefox, Edge).

---

## ⌨️ Comandes Obligatòries

Abans de llançar l'aplicació per primera vegada, és indispensable preparar les dependències del codi font. Des del terminal, accedeix a la ruta de l'aplicació i executa els passos següents:

1.  **Navegar fins al directori de treball:**
    ```bash
    cd /projecte
    ```
2.  **Descarregar els paquets del projecte:**
    ```bash
    composer install
    ```
3.  **Instal·lar el gestor de configuració:**
    ```bash
    composer require vlucas/phpdotenv
    ```
    *(Aquesta llibreria és necessària per permetre que l'aplicació llegeixi correctament les variables del sistema).*

---

## 📦 Arquitectura de l'Entorn (Docker)

El projecte s'aixeca de forma aïllada en una xarxa local virtualitzada que interconnecta directament els següents serveis:

1.  **Capa d'Aplicació:** Servidor web HTTP Apache configurat per processar la lògica de programació en PHP.
2.  **Estructura Relacional:** Motor MySQL per emmagatzemar la informació de base (com el control d'usuaris, rols i l'estat dels tiquets).
3.  **Magatzem NoSQL:** Base de dades MongoDB dedicada en exclusiva al registre de l'historial d'accés, auditoria i mètriques.
4.  **Utilitats Integrades:** Eines de control gràfic per interactuar amb les dades fàcilment des del navegador.

> 💡 **Inici ràpid:** Només cal llançar l'orquestrador de Docker des de l'arrel de l'espai de treball per activar tots els mòduls i carregar la URL local.

---

## 🎛️ Panells de Control de Dades

Depenent de l'entorn de treball, les eines per visualitzar i modificar les bases de dades es divideixen d'aquesta manera:

### ⚙️ Entorn de Proves (Local)
*   **Interfície MySQL:** Gestionat de manera lleugera amb **Adminer** accessible a [http://localhost:8081](http://localhost:8081).
*   **Interfície MongoDB:** Monitoritzat mitjançant la consola web de **mongo-express** a [http://localhost:8082](http://localhost:8082).

### ☁️ Entorn d'Explotació (Producció)
*   **Interfície MySQL:** Administrat mitjançant el programari tradicional **phpMyAdmin** de la infraestructura del centre.
*   **Interfície MongoDB:** Allotjat directament de forma externa a la plataforma **MongoDB Atlas** al núvol.
