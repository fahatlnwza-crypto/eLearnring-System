<template>
  <div class="min-h-screen bg-gradient-to-br from-[#87CEEB] via-[#4A9FDB] to-[#003B7A] flex items-center justify-center px-4 py-8">
    <!-- Decorative wave background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <svg class="absolute bottom-0 w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </svg>
      <svg class="absolute bottom-0 w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,192L48,176C96,160,192,128,288,133.3C384,139,480,181,576,181.3C672,181,768,139,864,128C960,117,1056,139,1152,154.7C1248,171,1344,181,1392,186.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </svg>
    </div>
    <div class="w-full relative z-10">
      <LoginForm />
    </div>
  </div>
</template>

<script setup lang="ts">
const { isAuthenticated } = useAuth()
const router = useRouter()

// Define page meta
definePageMeta({
  layout: false,
  // Redirect to dashboard if already authenticated
  middleware: () => {
    const { isAuthenticated } = useAuth()
    if (isAuthenticated.value) {
      return navigateTo('/dashboard')
    }
  }
})

// Check if user is already authenticated
onMounted(() => {
  if (isAuthenticated.value) {
    router.push('/dashboard')
  }
})
</script>

<style scoped>
/* Page-specific styles */
</style>
