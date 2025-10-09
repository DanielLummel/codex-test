<template>
  <component :is="activeComponent" />

  <aside class="fixed bottom-6 right-6 flex items-center gap-3 rounded-full border border-slate-200 bg-white px-4 py-2 shadow-lg">
    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Ansicht wechseln</span>
    <div class="flex gap-2">
      <button
        v-for="option in options"
        :key="option.value"
        type="button"
        class="rounded-full px-3 py-1 text-xs font-semibold"
        :class="option.value === currentView ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600'"
        @click="currentView = option.value"
      >
        {{ option.label }}
      </button>
    </div>
  </aside>
</template>

<script setup>
import { computed, ref } from "vue";
import Dashboard from "./Pages/Dashboard.vue";
import ProjectTemplates from "./Pages/ProjectTemplates.vue";
import CompetencyMatrix from "./Pages/CompetencyMatrix.vue";

const currentView = ref("dashboard");

const options = [
  { label: "Dashboard", value: "dashboard" },
  { label: "Vorlagen", value: "templates" },
  { label: "Kompetenzen", value: "competencies" }
];

const components = {
  dashboard: Dashboard,
  templates: ProjectTemplates,
  competencies: CompetencyMatrix
};

const activeComponent = computed(() => components[currentView.value]);
</script>
