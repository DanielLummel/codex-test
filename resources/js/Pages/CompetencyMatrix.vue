<template>
  <AppLayout>
    <PageSection
      anchor="competencies"
      title="Kompetenzmatrix"
      description="Überblick über Skills, Auslastung und Skill-Gaps"
    >
      <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
          <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
            <tr>
              <th class="px-6 py-4">Teammitglied</th>
              <th class="px-6 py-4">Kompetenzen</th>
              <th class="px-6 py-4">Aktuelle Rolle</th>
              <th class="px-6 py-4">Verfügbarkeit</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            <tr v-for="member in members" :key="member.name" class="align-top">
              <td class="whitespace-nowrap px-6 py-4">
                <div class="font-semibold text-slate-900">{{ member.name }}</div>
                <div class="text-xs text-slate-500">{{ member.level }}</div>
              </td>
              <td class="px-6 py-4">
                <ul class="flex flex-wrap gap-2">
                  <li v-for="skill in member.skills" :key="skill" class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                    {{ skill }}
                  </li>
                </ul>
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-slate-600">{{ member.assignment }}</td>
              <td class="whitespace-nowrap px-6 py-4">
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ member.availability }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </PageSection>

    <PageSection
      title="Identifizierte Skill-Gaps"
      description="Basis: Matching der Projektanforderungen für Q3"
    >
      <div class="space-y-4">
        <article v-for="gap in skillGaps" :key="gap.title" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
          <header class="mb-2 flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-900">{{ gap.title }}</h3>
            <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Priorität {{ gap.priority }}</span>
          </header>
          <p class="text-sm text-slate-600">{{ gap.description }}</p>
          <footer class="mt-3 text-xs text-slate-500">Empfohlene Maßnahme: {{ gap.action }}</footer>
        </article>
      </div>
    </PageSection>
  </AppLayout>
</template>

<script setup>
import AppLayout from "../Layouts/AppLayout.vue";
import PageSection from "../Components/PageSection.vue";

const members = [
  {
    name: "Julia Stein",
    level: "Senior Project Manager",
    skills: ["Programm-Management", "Change Enablement", "Stakeholder Mapping"],
    assignment: "Lead PM · Customer Portal Relaunch",
    availability: "30 % ab Juli"
  },
  {
    name: "David Yilmaz",
    level: "Technical Architect",
    skills: ["Cloud Infrastruktur", "API Governance", "Security Reviews"],
    assignment: "Solution Lead · IoT Rollout",
    availability: "10 %"
  },
  {
    name: "Laura Hoffmann",
    level: "Data Scientist",
    skills: ["Forecasting", "ML Ops", "Data Storytelling"],
    assignment: "Squad Member · Fraud Detection POC",
    availability: "50 %"
  },
  {
    name: "Benjamin Krüger",
    level: "Business Analyst",
    skills: ["Prozessmodellierung", "Requirements Engineering", "UAT Koordination"],
    assignment: "Projektteam · SAP S/4 Migration",
    availability: "70 %"
  }
];

const skillGaps = [
  {
    title: "Kubernetes Expertise für Hybrid-Deployments",
    priority: "Hoch",
    description: "Notwendig für Phase 3 des IoT Rollouts, aktuell keine dedizierte Senior-Ressource.",
    action: "Externes Training buchen & Pool an Freelancern evaluieren"
  },
  {
    title: "UX Research für Serviceprozesse",
    priority: "Mittel",
    description: "Customer Portal benötigt zusätzliche Customer-Journey-Validierung bis Juli.",
    action: "Temporäre Unterstützung durch Partner anfragen"
  },
  {
    title: "Data Engineer für KPI-Automatisierung",
    priority: "Hoch",
    description: "Dashboard Automatisierung hängt von belastbarem ETL-Setup ab.",
    action: "Interne Umschulung von Analytics-Team prüfen"
  }
];
</script>
