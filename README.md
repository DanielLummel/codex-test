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

> **Hinweis:** Dieses Repository enthält aktuell eine losgelöste Domänenschicht als Prototyp. Die hier beschriebenen Schritte decken den Domänen-Code ab und bilden die Grundlage für eine spätere Integration in eine vollständige Laravel/Vue-Anwendung.

1. Abhängigkeiten installieren:
   ```bash
   composer install
   npm install
   ```
2. Environment konfigurieren (für eine spätere Laravel-Integration):
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Domain-Tests und Quality Gates ausführen:
   ```bash
   composer test
   npm run lint
   ```
4. (Sobald das Laravel-Frontend angebunden ist) Datenbank migrieren & seeden:
   ```bash
   php artisan migrate --seed
   ```
5. Entwicklung starten:
   ```bash
   php artisan serve
   npm run dev
   ```

## Tests & Quality Gates
- **Domänentests** (PHPUnit):
  ```bash
  composer test
  ```
- **Integrationstests** (Laravel Test Suite, sobald verfügbar):
  ```bash
  php artisan test --testsuite=Feature
  ```
- **End-to-End / Browser-Tests** (Dusk, sofern eingerichtet):
  ```bash
  php artisan dusk
  ```
- **Quality Gates**:
  - `composer test` – stellt die Geschäftslogik sicher.
  - `composer qa` (geplant) für kombinierte Quality Checks (PHPStan, Pint, PHPUnit).
  - `npm run lint` und `npm run test` für Frontend-Qualität.

Stelle sicher, dass alle Tests erfolgreich durchlaufen, bevor Änderungen eingecheckt werden. Für neue Features sind passende Unit-, Feature- oder Dusk-Tests zu ergänzen.

## API-Dokumentation
Eine Postman Collection zur Dokumentation der API befindet sich im Verzeichnis `docs/postman/`. Importiere die Datei in Postman, um Endpunkte und Beispielanfragen zu testen.

## Domänenübersicht

Die Domänenschicht modelliert zentrale Bausteine der Plattform:

- **Projekt- und Angebotsvorlagen**: Der `TemplateService` erzeugt wiederverwendbare Vorlagen aus abgeschlossenen Projekten und erstellt daraus neue Projekte.
- **Kompetenzmatrix**: Der `CompetencyService` liefert eine zentrale Übersicht der Fähigkeiten und identifiziert Skill-Gaps für Projekte.
- **Projekt-Dashboard**: Der `DashboardService` aggregiert Kennzahlen wie Statusübersicht, Arbeitsaufwände, überfällige Projekte sowie Projekte kurz vor dem Abschluss.

Die Services sind vollständig getestet und nutzen In-Memory-Repositories. Für die Anbindung an Laravel können diese durch Eloquent-Implementierungen ersetzt werden.

## Continuous Integration
- CI-Pipelines sollten alle Quality Gates ausführen (Linting, statische Analyse, Tests).
- Pull Requests müssen eine aktuelle Testdokumentation enthalten.

## Lizenz
TBD.
