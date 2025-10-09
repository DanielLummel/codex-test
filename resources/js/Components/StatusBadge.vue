<template>
  <span :class="badgeClasses" class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-medium">
    <span class="h-2 w-2 rounded-full" :class="dotClasses" />
    {{ label }}
  </span>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  status: {
    type: String,
    required: true
  }
});

const statusStyles = {
  "In Planung": ["bg-amber-100 text-amber-700", "bg-amber-500"],
  "Aktiv": ["bg-emerald-100 text-emerald-700", "bg-emerald-500"],
  "Überfällig": ["bg-rose-100 text-rose-700", "bg-rose-500"],
  "Abgeschlossen": ["bg-slate-200 text-slate-600", "bg-slate-400"]
};

const label = computed(() => props.status);
const badgeClasses = computed(() => statusStyles[props.status]?.[0] ?? "bg-slate-200 text-slate-600");
const dotClasses = computed(() => statusStyles[props.status]?.[1] ?? "bg-slate-400");
</script>
