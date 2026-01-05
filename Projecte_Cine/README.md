# PROJECTE IAW: CineManager

CineManager és una aplicació web de gestió cinematogràfica que permet als usuaris organitzar el seu historial de pel·lícules. L'aplicació integra el catàleg local amb la base de dades internacional **OMDb** mitjançant la seva API pública, facilitant la descoberta de contingut i el control personalitzat de l'estat de visionat.

---

## 1. Usuaris de prova
Per provar l'aplicació he creat els següents perfils:

| Rol | Email | Contrasenya |
| :--- | :--- | :--- |
| **Moderador** | `admin@cine.com` | `admin123` |
| **Usuari** | `usuari@cine.com` | `usuari123` |

---

## 2. Funcionalitats principals
* **Sistema d'autenticació:** Registre amb validacions i Login amb sessions segures.
* **Sistema de rols:** Interfície i permisos diferenciats per a Moderadors i Usuaris.
* **CRUD complet 1 (Pel·lícules):** El moderador pot crear, llegir, editar i esborrar el catàleg.
* **CRUD complet 2 (Seguiment):** L'usuari pot afegir pel·lícules a la seva llista, canviar l'estat (Pendent/Vista), escriure comentaris i eliminar-les.
* **Ordenació dinàmica:** Llistat de pel·lícules ordenable per títol i any (ASC/DESC).
* **Cerca i filtratge:** Filtre d'estat a la llista de l'usuari.
* **Header dinàmic:** Navegació que canvia segons l'usuari que ha iniciat sessió.
* **Gestió d'errors:** Pàgina `error.php` per a validacions i permisos.

---

## 3. Funcionalitats extra
* **Sistema de valoracions:** Els usuaris poden afegir comentaris personals i veure la puntuació oficial de cada títol.
* **Notificacions:** Sistema d'alertes visuals i missatges de confirmació quan es completa accions (afegir, editar o eliminar registres).
* **Estadístiques:** Tauler amb el total de pel·lícules, nota mitjana del catàleg i recompte de pel·lícules populars.
* **Panel d'administració:** Interfície exclusiva pel moderador amb les estadístiques anteriors i on pot controlar el catàleg de pel·lícules.

---

**Desenvolupat per:** Eduardo Badoyan Ayvazyan
**Mòdul:** Projecte final IAW