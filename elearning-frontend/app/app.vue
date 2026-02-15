<template>
  <div>
    <NuxtPage />
  </div>
</template>

<script setup lang="ts">
// Check authentication status on app mount
onMounted(() => {
  const { checkAuth } = useAuth()
  checkAuth()
})
</script>
