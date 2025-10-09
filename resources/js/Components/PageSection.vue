<template>
  <section :id="anchor" class="mb-10 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
    <header class="mb-6 flex items-center justify-between gap-4">
      <div>
        <h2 class="text-xl font-semibold text-slate-900">{{ title }}</h2>
        <p v-if="description" class="mt-1 text-sm text-slate-500">{{ description }}</p>
      </div>
      <div v-if="$slots.actions">
        <slot name="actions" />
      </div>
    </header>
    <div>
      <slot />
    </div>
  </section>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  description: {
    type: String,
    default: ""
  },
  anchor: {
    type: String,
    default: null
  }
});
</script>
