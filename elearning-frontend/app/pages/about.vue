<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="max-w-4xl mx-auto px-4 py-12">
      <h1 class="text-5xl font-bold text-primary mb-6">About</h1>
      <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <p class="text-lg text-gray-700 leading-relaxed">
          This is a modern Nuxt.js frontend application built with Vue 3 and Tailwind CSS.
        </p>
        <p class="text-lg text-gray-700 leading-relaxed mt-4">
          Tailwind CSS provides a utility-first approach to styling, allowing rapid UI development
          with a comprehensive set of pre-built classes.
        </p>
      </div>
      <NuxtLink to="/" class="btn-primary">
        ← Back to Home
      </NuxtLink>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  title: 'About'
})
</script>
