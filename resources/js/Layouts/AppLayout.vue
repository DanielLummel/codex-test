<template>
  <div class="min-h-screen bg-slate-100 text-slate-900">
    <header class="bg-white border-b border-slate-200 shadow-sm">
      <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <div>
          <h1 class="text-2xl font-semibold text-blue-600">Project Platform</h1>
          <p class="text-sm text-slate-500">Interne Preview der Kernmodule</p>
        </div>
        <nav class="flex gap-4 text-sm font-medium text-slate-600">
          <a v-for="item in navigation" :key="item.label" :href="item.href" class="rounded px-3 py-2 transition hover:bg-blue-50 hover:text-blue-600">
            {{ item.label }}
          </a>
        </nav>
      </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-10">
      <slot />
    </main>

    <footer class="border-t border-slate-200 bg-white py-6">
      <div class="mx-auto max-w-6xl px-6 text-xs text-slate-500">
        Prototype Stand: {{ todaysDate }} · Nur zur internen Abstimmung
      </div>
    </footer>
  </div>
</template>

<script setup>
const navigation = [
  { label: "Dashboard", href: "#dashboard" },
  { label: "Vorlagen", href: "#templates" },
  { label: "Kompetenzen", href: "#competencies" }
];

const todaysDate = new Date().toLocaleDateString();
</script>

<style scoped>
a {
  text-decoration: none;
}
</style>
