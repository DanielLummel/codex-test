# Codex Projektmanagement-Plattform

Dieses Repository enthält den Quellcode für eine Laravel-Anwendung mit Vue.js, Inertia und Vite. Ziel ist eine Plattform, die Projektmanager:innen bei der Wiederverwendung von Angebots- und Projektvorlagen unterstützt, Kompetenzen von Teammitgliedern verwaltet und ein Dashboard mit Projektstatus bietet.

## Kernfunktionen
- **Vorlagen-Management**: Angebote und Projekte lassen sich anhand historischer Daten als Vorlage erstellen und wiederverwenden.
- **Kompetenzübersicht**: Alle Teammitglieder und deren Kompetenzen können gepflegt und Projekten zugeordnet werden.
- **Projekt-Dashboard**: Übersicht aller Projekte inklusive Statusindikatoren.

## Architektur
- **Backend**: Laravel (PHP) mit REST- und Inertia-Routen.
- **Frontend**: Vue 3 via Inertia und Vite.
- **Persistenz**: MySQL oder PostgreSQL (konfigurierbar über `.env`).

## Lokale Entwicklung
1. Abhängigkeiten installieren:
   ```bash
   composer install
   npm install
   ```
2. Environment konfigurieren:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Datenbank migrieren & seeden:
   ```bash
   php artisan migrate --seed
   ```
4. Entwicklung starten:
   ```bash
   php artisan serve
   npm run dev
   ```

## Tests & Quality Gates
- **Integrationstests** (Laravel Test Suite):
  ```bash
  php artisan test --testsuite=Feature
  ```
- **End-to-End / Browser-Tests** (Dusk, sofern eingerichtet):
  ```bash
  php artisan dusk
  ```
- **Quality Gates**:
  - `composer qa` für kombinierte Quality Checks (PHPStan, Pint, PHPUnit). Füge zusätzliche Tools bei Bedarf hinzu.
  - `npm run lint` und `npm run test` für Frontend-Qualität.

Stelle sicher, dass alle Tests erfolgreich durchlaufen, bevor Änderungen eingecheckt werden. Für neue Features sind passende Unit-, Feature- oder Dusk-Tests zu ergänzen.

## API-Dokumentation
Eine Postman Collection zur Dokumentation der API befindet sich im Verzeichnis `docs/postman/`. Importiere die Datei in Postman, um Endpunkte und Beispielanfragen zu testen.

## Continuous Integration
- CI-Pipelines sollten alle Quality Gates ausführen (Linting, statische Analyse, Tests).
- Pull Requests müssen eine aktuelle Testdokumentation enthalten.

## Lizenz
TBD.
