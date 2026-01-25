# PROJECTE IAW: CineManager

CineManager és una aplicació web de gestió cinematogràfica que permet als usuaris organitzar i descobrir contingut de forma personalitzada. L'aplicació integra el catàleg local amb la base de dades internacional **OMDb** mitjançant la seva API pública, facilitant la descoberta de contingut i el control personalitzat de l'estat de visionat.

---

## 1. Usuaris de prova
Per provar l'aplicació s'han creat els següents perfils:

| Rol | Email | Contrasenya |
| :--- | :--- | :--- |
| **Moderador** | `admin@cine.com` | `admin123` |
| **Usuari** | `usuari@cine.com` | `usuari123` |

---

## 2. Funcionalitats principals
* **Sistema d'autenticació:** Sistema de registre i login amb sessions PHP i xifrat de dades.
* **Gestió de rols:** Interfície dinàmica que adapta el header.php i els permisos segons el perfil.
* **CRUD complet 1 (Pel·lícules):** El moderador pot crear, llegir, editar i esborrar pel·lícules del catàleg. El contingut creix automàticament amb les importacions des de l'API.
* **CRUD complet 2 (Seguiment):** L'usuari pot gestionar la seva llista personal, canviar estats (Pendent/Vista), escriure comentaris i eliminar-les.
* **Ordenació dinàmica:** Des del panell d'administració i el catàleg es pot ordenar per títol i any (ASC/DESC).
* **Cerca i filtratge:** Cercador dinàmic amb paràmetres (Títol, Any) i filtres per estat de visionat a la llista d'usuari.
* **Header dinàmic:** Navegació que mostra informació diferent segons l'estat de la sessió i el rol de l'usuari.
* **Gestió d'errors:** Pàgina error.php per gestionar accessos no autoritzats i validacions de formulari.

---

## 3. Funcionalitats extra
* **Integració d'API externa:** Consum de l'API OMDb per a la importació automàtica de dades (Director, Sinopsi, Puntuació) al catàleg local.
* **Sistema de valoracions:** Visualització de puntuacions oficials de l'API integrades a la base de dades.
* **Notificacions:** Sistema d'alertes visuals i missatges de confirmació quan es completen accions (afegir, editar o eliminar registres).
* **Estadístiques:** Tauler amb el total de pel·lícules, nota mitjana del catàleg i recompte de pel·lícules populars (Nota superior a 8).
* **Panel d'administració:** Interfície exclusiva pel moderador amb estadístiques globals i control total del catàleg.
* **Exportació de dades:** L'usuari pot descarregar la seva llista personal de seguiment en formats PDF i CSV.

---

## 4. Instruccions d'instal·lació
En el fitxer `config/db_connect.php` s'ha d'actualitzar les següents dades:
* Modificar las credencials segons la vostra BBDD.
* Introduir la vostra pròpia API KEY d'OMDb a la variable `$MOVIE_API_KEY`. Pots obtenir-ne una de gratuïta a [omdbapi.com](http://www.omdbapi.com/apikey.aspx).

---

**Desenvolupat per:** Eduardo Badoyan Ayvazyan
<br>
**Mòdul:** Projecte final IAW