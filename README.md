# 🍕 Pizza-Service – EWA Praktikum

> 🇬🇧 English | 🇩🇪 [Deutsch](#-deutsch)

---

University project built during the *Entwicklung webbasierter Anwendungen* course at Hochschule Darmstadt (WS 2025/26).

A pizza ordering web app — customers order, bakers prepare, drivers deliver. All pages update live without reloading.

---

## 🛠️ Tech Stack

| | |
|---|---|
| **PHP** | Backend logic, MVC architecture (EWA Framework) |
| **MariaDB** | Database |
| **HTML / CSS** | Structure & Flexbox layout |
| **JavaScript** | Fetch API, DOM manipulation, live polling |
| **Docker** | Local dev environment (Apache + phpMyAdmin) |

---

## 📄 Pages

| Page | Description |
|------|-------------|
| 🧑 Customer | Browse menu, add to cart, place order |
| 👨‍🍳 Baker | View incoming orders, mark as ready |
| 🚗 Driver | See orders ready for delivery |

---

## 🚀 Run it locally

> Requires [Docker](https://www.docker.com/) installed

```bash
git clone https://github.com/soukainaelhafif/pizza-service-webapp.git
cd pizza-service-webapp
docker compose up -d
```

- App → `http://localhost/`
- phpMyAdmin → `http://localhost:8080`

Then import the `.sql` file via phpMyAdmin to set up the database.

---

## 🎓 Course

Hochschule Darmstadt · Fachbereich Informatik · Prof. Thomas Hofmann · WS 2025/26

---
---

## 🇩🇪 Deutsch

Universitätsprojekt im Kurs *Entwicklung webbasierter Anwendungen* an der Hochschule Darmstadt (WS 2025/26).

Eine Pizza-Bestellapp — Kunden bestellen, Bäcker bereiten vor, Fahrer liefern aus. Alle Seiten aktualisieren sich live ohne Neuladen.

---

## 🛠️ Technologien

| | |
|---|---|
| **PHP** | Backend-Logik, MVC-Architektur (EWA Framework) |
| **MariaDB** | Datenbank |
| **HTML / CSS** | Struktur & Flexbox-Layout |
| **JavaScript** | Fetch API, DOM-Manipulation, Live-Polling |
| **Docker** | Lokale Entwicklungsumgebung (Apache + phpMyAdmin) |

---

## 📄 Seiten

| Seite | Beschreibung |
|-------|--------------|
| 🧑 Kunde | Speisekarte, Warenkorb, Bestellung aufgeben |
| 👨‍🍳 Bäcker | Bestellungen sehen, als fertig markieren |
| 🚗 Fahrer | Fertige Bestellungen zur Auslieferung sehen |

---

## 🚀 Lokal starten

> Docker muss installiert sein

```bash
git clone https://github.com/soukainaelhafif/pizza-service-webapp.git
cd pizza-service-webapp
docker compose up -d
```

- App → `http://localhost/`
- phpMyAdmin → `http://localhost:8080`

Danach die `.sql` Datei über phpMyAdmin importieren, um die Datenbank einzurichten.

---

## 🎓 Kurs

Hochschule Darmstadt · Fachbereich Informatik · Prof. Thomas Hofmann · WS 2025/26
