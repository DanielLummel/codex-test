<template>
  <AppLayout>
    <PageSection
      anchor="templates"
      title="Vorlagenbibliothek"
      description="Projekt- und Angebotsvorlagen zum schnellen Start"
    >
      <div class="grid gap-6 md:grid-cols-2">
        <article v-for="template in templates" :key="template.title" class="flex h-full flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
          <div>
            <header class="mb-3 flex items-start justify-between gap-3">
              <div>
                <h3 class="text-lg font-semibold text-slate-900">{{ template.title }}</h3>
                <p class="text-sm text-slate-500">{{ template.industry }} · {{ template.duration }}</p>
              </div>
              <StatusBadge :status="template.maturity" />
            </header>
            <p class="text-sm text-slate-600">{{ template.description }}</p>
          </div>
          <footer class="mt-6 flex items-center justify-between text-xs text-slate-500">
            <span>Letztes Update: {{ template.updatedAt }}</span>
            <button class="rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white shadow-sm">Ansehen</button>
          </footer>
        </article>
      </div>
    </PageSection>

    <PageSection
      title="Bausteine & Assets"
      description="Wiederverwendbare Artefakte nach Phase"
    >
      <div class="grid gap-4 md:grid-cols-3">
        <article v-for="asset in assets" :key="asset.category" class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
          <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">{{ asset.category }}</h3>
          <ul class="mt-3 space-y-2 text-sm text-slate-700">
            <li v-for="entry in asset.items" :key="entry" class="rounded-lg bg-white px-3 py-2 shadow-sm">
              {{ entry }}
            </li>
          </ul>
        </article>
      </div>
    </PageSection>
  </AppLayout>
</template>

<script setup>
import AppLayout from "../Layouts/AppLayout.vue";
import PageSection from "../Components/PageSection.vue";
import StatusBadge from "../Components/StatusBadge.vue";

const templates = [
  {
    title: "Digital Workplace Rollout",
    industry: "Energie",
    duration: "18 Wochen",
    description: "End-to-End Vorlage inkl. Change-Konzept, Stakeholder Mapping und Kommunikationsplan.",
    maturity: "Aktiv",
    updatedAt: "29. Mai"
  },
  {
    title: "CRM Konsolidierung",
    industry: "Retail",
    duration: "12 Wochen",
    description: "Standardisiertes Vorgehen zur Datenmigration und Prozessharmonisierung.",
    maturity: "Abgeschlossen",
    updatedAt: "24. Mai"
  },
  {
    title: "Machine Learning POC",
    industry: "Finanzen",
    duration: "8 Wochen",
    description: "Vorlage für explorative Projekte mit schnellem Business-Value-Fokus.",
    maturity: "In Planung",
    updatedAt: "03. Juni"
  },
  {
    title: "IT Due Diligence",
    industry: "Private Equity",
    duration: "6 Wochen",
    description: "Checklisten, Risiko-Frameworks und Kommunikationspakete für kurzfristige Prüfungen.",
    maturity: "Aktiv",
    updatedAt: "31. Mai"
  }
];

const assets = [
  {
    category: "Vorbereitung",
    items: ["Scoping Canvas", "Stakeholder Radar", "Risikofrühwarnliste"]
  },
  {
    category: "Durchführung",
    items: ["Sprint-Planungsboard", "Kommunikationspaket", "Quality-Gate Checkliste"]
  },
  {
    category: "Abschluss",
    items: ["Lessons Learned Template", "Transition Plan", "Erfolgsmetriken Dashboard"]
  }
];
</script>
