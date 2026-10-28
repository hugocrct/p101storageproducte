# 🛍️ p101 · Gestió de productes amb Laravel i File Storage

> **MP0486 Accés a dades · Escola Pia Santa Anna-Mataró**
> Pràctica entregada per **Hugo** (`hugocrct`)

Hola, professor/a! 👋
Aquest repositori conté la resolució de la pràctica **p101storageproducte**: un aplicatiu web Laravel que recull dades de productes mitjançant un formulari, les desa en **dos fitxers** (JSON i XML) i les torna a llegir per mostrar-les en taules.

---

## 📦 Què hi ha en aquest repositori

Tal com demana l'enunciat, només s'inclouen els fitxers que cal entregar (no és el projecte Laravel complet):

```
├── app/Http/Controllers/
│   ├── Controller.php
│   └── ProducteController.php      ← tota la lògica (validació, escriptura i lectura)
├── routes/
│   └── web.php                     ← arxiu de rutes
├── resources/views/
│   ├── master.blade.php            ← plantilla mestra amb el NAV
│   ├── welcome.blade.php           ← vista de benvinguda
│   ├── register.blade.php          ← formulari d'entrada de dades
│   ├── json.blade.php              ← llistat de les dades del fitxer JSON
│   └── xml.blade.php               ← llistat de les dades del fitxer XML
└── storage/app/
    ├── private/productes.json      ← fitxer JSON generat per l'aplicatiu (disc local)
    └── public/productes.xml        ← fitxer XML generat per l'aplicatiu (disc public)
```

Els dos fitxers de `storage` són **exemples reals** generats per l'aplicatiu en registrar productes des del formulari.

---

## 🧭 Rutes

| Mètode | Ruta        | Descripció                                              |
|--------|-------------|---------------------------------------------------------|
| GET    | `/`         | Vista de benvinguda a l'aplicatiu                       |
| GET    | `/register` | Vista amb el formulari per introduir les dades          |
| POST   | `/register` | Valida i guarda les dades; torna a carregar el formulari |
| GET    | `/xml`      | Llegeix l'arxiu XML i en mostra les dades               |
| GET    | `/json`     | Llegeix l'arxiu JSON i en mostra les dades              |

---

## ✅ Compliment dels requeriments

**Entrada de dades**

- [x] Formulari HTML en una vista (`register.blade.php`)
- [x] Camps: nom, descripció, preu (sense IVA), % IVA, color i talla
- [x] **% IVA per defecte: 21 %**
- [x] **Tots els camps obligatoris** al *front-end* (`required`) i al *back-end* (`$request->validate()` amb missatges en català)
- [x] El **preu de venda** (amb IVA aplicat) es calcula al controlador i es guarda juntament amb la resta de dades:
  `preu_venda = preu × (1 + iva / 100)`, arrodonit a 2 decimals

**Escriptura**

- [x] El *submit* afegeix el producte a **dos fitxers**: JSON i XML
- [x] Si el fitxer ja existeix, el producte **s'afegeix** al final; si no, es **crea** amb el primer registre
- [x] **JSON → unitat LOCAL** (`Storage::disk('local')`), emmagatzemat com a **objectes JSON**
- [x] **XML → unitat PUBLIC** (`Storage::disk('public')`), emmagatzemat com a **nodes XML**

**Lectura**

- [x] Dues vistes separades: `/json` i `/xml`
- [x] Les dades es preparen al controlador i es mostren en **format taula**

**Navegació**

- [x] `master.blade.php` amb un **NAV** que enllaça totes les vistes (Inici, Registrar, Veure JSON, Veure XML)

---

## 🔍 Com funciona (resum del controlador)

1. `registerPost()` valida la petició amb `validar()`.
2. `store()` calcula el `preu_venda` i escriu en els dos fitxers:
   - **JSON:** llegeix l'array existent, hi afegeix el producte i el torna a desar amb `Storage::disk('local')`.
   - **XML:** carrega l'arbre existent amb `SimpleXMLElement` (o crea l'arrel `<productes/>`), hi afegeix un node `<producte>` i el desa amb `Storage::disk('public')`.
3. Es redirigeix a `/register` amb un missatge d'èxit.
4. `json()` i `xml()` llegeixen el fitxer corresponent, el converteixen en un array de productes i el passen a la vista.

### Exemple de registre

**JSON** (`storage/app/private/productes.json`)

```json
{
    "nom": "Camisa",
    "descripcio": "Una camisa rosa",
    "preu": "10",
    "iva": "21",
    "color": "Azul",
    "talla": "XL",
    "preu_venda": 12.1
}
```

**XML** (`storage/app/public/productes.xml`)

```xml
<producte>
  <nom>Camisa</nom>
  <descripcio>Una camisa rosa</descripcio>
  <preu>10</preu>
  <iva>21</iva>
  <color>Azul</color>
  <talla>XL</talla>
  <preu_venda>12.1</preu_venda>
</producte>
```

---

## ▶️ Com provar-ho

Com que el repositori només porta els fitxers de la pràctica, cal copiar-los dins d'un projecte Laravel net:

```bash
composer create-project laravel/laravel p101
cd p101
```

1. Copia `app/`, `routes/`, `resources/views/` i `storage/` del repositori sobre el projecte (sobreescrivint).
2. Esborra les dades d'exemple si vols començar de zero:
   `storage/app/private/productes.json` i `storage/app/public/productes.xml`.
3. Arrenca el servidor:

```bash
php artisan serve
```

4. Obre `http://127.0.0.1:8000/register`, registra un parell de productes i consulta `/json` i `/xml`.

> 💡 Les vistes carreguen **Bootstrap 5 per CDN**, per tant cal connexió a Internet per veure'n els estils.
> El fitxer XML es llegeix amb `Storage`, així que **no cal** executar `php artisan storage:link` perquè l'aplicatiu funcioni.

---

## 🛠️ Tecnologies

- PHP + **Laravel** (Routing, Blade, Validation, **File Storage**)
- `SimpleXMLElement` / `DOMDocument` per escriure i llegir XML
- Bootstrap 5 (CDN)

---

Moltes gràcies per la revisió! Qualsevol dubte, estic a la vostra disposició. 🙌

**Hugo** · [@hugocrct](https://github.com/hugocrct)
