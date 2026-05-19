# Disseny d'Interfícies Web
## Els 10 heurístics de Nielsen aplicats al projecte

---

### 🟢 1. Visibilitat de l'estat del sistema
El sistema manté l'usuari informat en tot moment sobre el resultat de les seves accions. 
* **Exemple pràctic**: En afegir una actuació o tancar un tiquet (`actuacioIncidencia.php`), es mostren alertes visuals de confirmació o d'error.
* **Dinamisme**: Les llistes de tasques es refresquen automàticament en aplicar filtres, garantint que l'usuari sàpiga exactament què està veient.

### 🤝 2. Correspondència entre el sistema i el món real
L'aplicació utilitza un llenguatge natural, proper i totalment adaptat a l'entorn de l'usuari final.
* **Vocabulari entenedor**: S'empren conceptes familiars del centre educatiu com *incidència*, *tècnic*, *departament* o *prioritat*.
* **Estructura de rols**: La navegació es divideix segons figures reals de l'organització (*professor*, *tècnic*, *responsable informàtic*).

### 🔄 3. Control i llibertat de l'usuari
Els usuaris disposen de total autonomia per navegar i rectificar accions lliurement de forma senzilla.
* **Navegació segura**: S'inclouen botons directes com *Tornar enrere* o enllaços ràpids a l'*Inici*.
* **Cancel·lació d'accions**: És possible revertir canvis o modificar dades en els formularis i filtres abans de processar l'enviament definitiu.

### 📐 4. Consistència i estàndards
Es manté una línia visual i estructural unificada a totes les pantalles de la plataforma.
* **Disseny modular**: S'utilitzen fitxers globals com `header.php` i `footer.php` per garantir la coherència del disseny.
* **Components comuns**: S'apliquen elements estàndards de *Bootstrap* (botons, taules i formularis) amb un mateix criteri visual.

### 🛡️ 5. Prevenció d'errors
El disseny està pensat per evitar que l'usuari cometi errades abans que aquestes arribin a produir-se.
* **Validació dual**: Es comprova la informació tant al frontend com al backend (per exemple, a `actuacioIncidencia.php` es prohibeixen temps negatius o textos massa curts).
* **Entrades guiades**: S'utilitzen camps obligatoris (`required`) i desplegables de selecció en lloc de caixes de text lliure.

### 🧠 6. Reconeixement abans que record s'imposi
L'aplicació mostra les opcions de forma explícita per evitar sobrecarregar la memòria de l'usuari.
* **Dades directes**: Els desplegables de personal tècnic, departaments i tipologies mostren els noms reals extrets de la base de dades.
* **Sense codis**: L'usuari no necessita memoritzar identificadors numèrics ni codis interns del sistema per operar.

### ⚡ 7. Flexibilitat i eficiència d'ús
La interfície s'adapta de manera eficient tant a usuaris novells com a perfils experts.
* **Dreceres tècniques**: El personal de suport pot filtrar de cop per urgència, data o àrea per anar per feina.
* **Panell avançat**: Els administradors disposen de logs i gràfiques en MongoDB per a una analítica profunda del sistema.

### ✨ 8. Disseny estètic i minimalista
L'apartat visual es concentra únicament en el contingut rellevant, eliminant qualsevol distracció.
* **Interfície neta**: L'estil basat en *Bootstrap* dona prioritat absoluta a les taules de dades i als formularis operatius.
* **Codi de colors**: S'utilitzen tons cromàtics específics per diferenciar les prioritats de forma visual i immediata.

### 🚨 9. Ajuda als usuaris a reconèixer, diagnosticar i recuperar-se d'errors
Els missatges de fallada estan escrits en llenguatge clar, identifiquen el problema i suggereixen una sortida.
* **Notificacions clares**: El sistema detalla exactament l'error com, per exemple, avisar si una descripció és insuficient.
* **Preservació del context**: En cas d'error, es retorna l'usuari al formulari mantenint les dades introduïdes per facilitar la correcció.

### 📖 10. Ajuda i documentació
La plataforma està dissenyada per ser completament autoexplicativa sense requerir manuals externs.
* **Interfície intuïtiva**: Els textos explicatius, les etiquetes i la iconografia guien l'usuari de manera natural en cada acció.
* **Flux per rols**: L'organització visual segons el perfil d'accés deixa clar quines operacions té permeses cada persona.


# WCAG AA
## Formulari amb accessibilitat WCAG AA: professor.php

Els formularis d'aquesta pàgina compleixen els requisits **WCAG AA** perquè estan estructurats correctament i són totalment compatibles amb tecnologies d'assistència. 

* **Vinculació d'etiquetes**: Cada camp d'entrada de dades està associat a la seva etiqueta corresponent mitjançant els atributs `label` i `for`. Això permet que els lectors de pantalla identifiquin clarament quina informació se sol·licita en cada moment (satisfent els criteris d'èxit **WCAG 1.3.1 i 4.1.2**).
* **Prevenció d'errors**: S'utilitzen atributs de obligatorietat i marcadors visuals per indicar els camps requerits. Això ajuda a evitar equivocacions abans de l'enviament i millora la comprensió global de l'usuari, contribuint a una entrada de dades accessible.
* **Robustesa i estàndards**: L'ús d'elements semàntics natius d'HTML com `input`, `select` i `textarea` garanteix una compatibilitat total amb navegadors i dispositius d'assistència. A més, l'estructura neta recolzada en *Bootstrap* potència la llegibilitat i la navegació visual.

---

## Llistat amb WCAG AA: modificarIncidencies.php

El llistat de tasques i incidències compleix les pautes **WCAG AA**, assegurant una correcta interpretació de la informació tant de forma visual com per mitjà de lectors de pantalla.

* **Estructura semàntica**: Les capçaleres de les taules i dades estan organitzades per seccions ben definides. Això facilita la navegació seqüencial i ajuda a relacionar immediatament cada dada amb el seu significat conceptual.
* **Ús no exclusiu del color**: Tot i que s'utilitzen colors específics per diferenciar les prioritats de les incidències, el color serveix únicament com a suport visual complementari. La informació mai depèn d'un sol codi cromàtic, complint el principi de percepció.
* **Propostes de millora**: Per optimitzar encara més el nivell d'accessibilitat, es podria reforçar l'experiència afegint atributs `ARIA` en els elements més dinàmics de la pàgina i polint la navegació exclusiva per teclat (*focus*) en els botons i filtres de cerca.
