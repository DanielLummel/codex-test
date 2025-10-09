# Domänenarchitektur

Dieser Prototyp fokussiert die fachliche Logik der Projektmanagement-Plattform. Die Implementierung ist so aufgebaut, dass sie später nahtlos in ein Laravel-Backend mit Vue-Frontend integriert werden kann.

## Bausteine

- **Domänenmodelle** (`app/Domain/Model`): Entitäten wie `Project`, `TeamMember`, `ProjectTemplate` und Value Objects (`Skill`, `Task`, `WorkPackage`).
- **Services** (`app/Domain/Service`):
  - `TemplateService` generiert Vorlagen aus Projekten und leitet daraus neue Projekte ab.
  - `CompetencyService` aggregiert die Kompetenzmatrix und identifiziert Skill-Gaps.
  - `DashboardService` erzeugt Kennzahlen für das Projekt-Dashboard.
- **DTOs** (`app/Domain/DTO`): Datenstrukturen für Snapshots und Matrix-/Gap-Darstellungen.
- **Repository-Schnittstellen** (`app/Domain/Repository`): Abstraktion für spätere Persistence-Schichten.
- **In-Memory-Implementierungen** (`app/Infrastructure/Repository/InMemory`): Erleichtern Tests ohne Datenbank.

## Integrationshinweise

1. **Persistenz**: Die In-Memory-Repositories werden durch Eloquent-Repositories ersetzt. Die Interfaces sind bereits definiert.
2. **Anwendungsschicht**: Laravel-Controller können die Services injizieren, um Vorlagen, Kompetenzmatrizen und Dashboards bereitzustellen.
3. **Frontend**: Vue-Komponenten konsumieren die Daten über Inertia-Endpunkte. Für die Kompetenzmatrix bietet sich eine tabellarische Darstellung mit Filterung nach Skills und Verfügbarkeit an.
4. **Tests**: Die vorhandenen PHPUnit-Tests dienen als Referenz für erwartetes Verhalten. Beim Wechsel auf Eloquent sollten zusätzliche Integrationstests ergänzt werden.

## Nächste Schritte

- Ablage der Templates, Projekte und Team-Mitglieder in einer relationalen Datenbank.
- Aufbau der REST- und Inertia-Routen auf Basis der definierten Services.
- Ergänzung eines Frontend-Prototyps für Dashboard, Kompetenzübersicht und Vorlagenverwaltung.
- Einrichtung automatisierter Quality Gates (PHPStan, Laravel Pint, ESLint, Vitest) in der CI.
