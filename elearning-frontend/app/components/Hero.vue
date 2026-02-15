<template>
  <div class="bg-gradient-to-r from-primary via-purple-500 to-secondary text-white rounded-lg p-8 mb-8 shadow-lg">
    <h2 class="text-3xl font-bold mb-2">{{ title }}</h2>
    <p class="text-lg opacity-90">{{ message }}</p>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: 'Welcome'
  },
  message: {
    type: String,
    default: 'This is a reusable component'
  }
})
</script>
