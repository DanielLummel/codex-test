<template>
  <AppLayout>
    <PageSection
      anchor="dashboard"
      title="Projektstatus"
      description="Schnappschuss über laufende und kritische Projekte"
    >
      <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
          <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Statusübersicht</h3>
          <dl class="grid grid-cols-2 gap-4 text-sm">
            <div v-for="item in statusSummary" :key="item.label" class="rounded-xl bg-white p-4 shadow-sm">
              <dt class="text-slate-500">{{ item.label }}</dt>
              <dd class="mt-2 text-2xl font-semibold text-slate-900">{{ item.value }}</dd>
            </div>
          </dl>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
          <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Anstehende Deadlines</h3>
          <ul class="space-y-3 text-sm">
            <li v-for="deadline in deadlines" :key="deadline.project" class="flex items-center justify-between rounded-xl border border-slate-100 p-3">
              <div>
                <p class="font-medium text-slate-900">{{ deadline.project }}</p>
                <p class="text-xs text-slate-500">{{ deadline.phase }} · Verantwortlich: {{ deadline.owner }}</p>
              </div>
              <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">{{ deadline.due }}</span>
            </li>
          </ul>
        </div>
      </div>
    </PageSection>

    <PageSection
      title="Arbeitsauslastung"
      description="Welche Teams sind ausgelastet und wo haben wir Puffer?"
    >
      <div class="grid gap-4 md:grid-cols-3">
        <article v-for="workload in workloadByTeam" :key="workload.team" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
          <header class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">{{ workload.team }}</h3>
            <span class="text-xs font-medium text-slate-500">Kapazität: {{ workload.capacity }}%</span>
          </header>
          <p class="text-sm text-slate-600">{{ workload.focus }}</p>
          <div class="mt-5 h-2 rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-blue-500" :style="{ width: workload.capacity + '%' }" />
          </div>
        </article>
      </div>
    </PageSection>

    <PageSection
      title="Risiken & Blocker"
      description="Manuelle Erfassung aus den Projekt-Weeklies"
    >
      <div class="space-y-4">
        <article v-for="risk in risks" :key="risk.title" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
          <header class="mb-2 flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-900">{{ risk.title }}</h3>
            <StatusBadge :status="risk.severity" />
          </header>
          <p class="text-sm text-slate-600">{{ risk.description }}</p>
          <footer class="mt-3 text-xs text-slate-500">Gegenmaßnahmen: {{ risk.mitigation }}</footer>
        </article>
      </div>
    </PageSection>
  </AppLayout>
</template>

<script setup>
import AppLayout from "../Layouts/AppLayout.vue";
import PageSection from "../Components/PageSection.vue";
import StatusBadge from "../Components/StatusBadge.vue";

const statusSummary = [
  { label: "Aktive Projekte", value: 8 },
  { label: "Überfällige Meilensteine", value: 3 },
  { label: "Projekte in Planung", value: 4 },
  { label: "Abgeschlossene Projekte (Q2)", value: 5 }
];

const deadlines = [
  { project: "Customer Portal Relaunch", due: "12. Juni", phase: "UAT-Abschluss", owner: "Lisa" },
  { project: "IoT Rollout Phase 2", due: "18. Juni", phase: "Hardware-Bestellung", owner: "Jonas" },
  { project: "SAP S/4 Migration", due: "21. Juni", phase: "Cutover-Plan", owner: "Marta" }
];

const workloadByTeam = [
  { team: "UX & Research", capacity: 92, focus: "Lieferung finaler Figma-Prototypen für Portal und HR-Suite" },
  { team: "Backend", capacity: 76, focus: "Stabilisierungsmaßnahmen und API-Erweiterungen für B2B" },
  { team: "Data & AI", capacity: 54, focus: "Vorbereitung POC Fraud Detection & Exploratives Dashboard" }
];

const risks = [
  {
    title: "Externe Abhängigkeit: Lieferant für Spezialhardware",
    severity: "Überfällig",
    description: "Vertragliche Freigabe verzögert sich um 10 Tage; mögliche Auswirkungen auf Go-Live.",
    mitigation: "Alternative Lieferanten prüfen, Eskalation an Einkauf am 07. Juni"
  },
  {
    title: "Ressourcenengpass Analytics-Team",
    severity: "In Planung",
    description: "Zweites Data-Team wird ab Juli benötigt, aktuell nur 60 % Kapazität verfügbar.",
    mitigation: "Freelancer-Sourcing vorbereiten, Entscheidung im Steering am 15. Juni"
  },
  {
    title: "Unklare Anforderungen MVP Kundenportal",
    severity: "Aktiv",
    description: "Fehlende Freigabe der Serviceprozesse; Tickets blocken Entwicklung sprint-übergreifend.",
    mitigation: "Workshops mit Service-Team planen, Product Owner unterstützen"
  }
];
</script>
