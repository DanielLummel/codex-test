# Projektleitfaden

## Geltungsbereich
Dieses Dokument gilt für das gesamte Repository.

## Architekturvorgaben
- Backend basiert auf Laravel.
- Frontend wird mit Vue.js über Inertia und Vite umgesetzt.
- Neue Features sollen die Wiederverwendbarkeit von Projektdaten für Projektmanager unterstützen (Vorlagen für Angebote/Projekte, Kompetenzübersichten, Projekt-Dashboard).

## Funktionsanforderungen
- Stelle sicher, dass Vorlagen aus vergangenen Projekten und Angeboten generiert bzw. wiederverwendet werden können.
- Implementiere eine zentrale Übersicht über alle Kompetenzen der Teammitglieder und deren Zuordnung zu Projekten.
- Baue ein Dashboard mit Statusübersicht aller Projekte.

## Qualitätsanforderungen
- Richte Quality Gates ein (z.\u202fB. statische Analysen, Testabdeckung, Linting). Dokumentiere sie in der README.
- Ergänze Integrationstests für neue Funktionalitäten und stelle sicher, dass bestehende Integrationstests laufen.
- Schreibe zusätzliche Tests für jedes neue Feature (Unit, Feature oder Dusk, je nach Ebene).

## Dokumentation
- Halte die README aktuell (Setup, Tests, Quality Gates, Architektur).
- Dokumentiere die API über eine Postman Collection im Verzeichnis `docs/postman/`. Aktualisiere die README mit Importhinweisen.

## Arbeitsweise
- Nach größeren Änderungen an Tests oder Dokumentation die entsprechenden Dateien erwähnen.
- Beachte diese Vorgaben bei allen Änderungen an Code, Tests und Dokumentation.
