<template>
  <!-- Loading State -->
  <div v-if="!authReady" class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center">
    <div class="text-center">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-[#003B7A] mb-4"></div>
      <p class="text-gray-600 text-lg">กำลังโหลด...</p>
    </div>
  </div>

  <!-- Main Content - New Modern Design -->
  <div v-else class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <!-- Hero Section with Profile -->
    <div class="bg-gradient-to-r from-[#003B7A] via-[#4A9FDB] to-[#003B7A] relative overflow-visible pb-24 lg:pb-32">
      <!-- Decorative elements -->
      <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-white rounded-full blur-3xl"></div>
      </div>
      
      <div class="relative w-full px-4 sm:px-6 lg:px-8 pt-6 pb-8">
        <!-- Header with Back Button -->
        <div class="flex items-center justify-between mb-8">
          <div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-2">
              โปรไฟล์ของฉัน
            </h1>
            <p class="text-blue-100 text-base lg:text-lg">จัดการบัญชีและดูความคืบหน้าการเรียนรู้ของคุณ</p>
          </div>
          <NuxtLink
            to="/dashboard"
            class="hidden lg:inline-flex items-center gap-2 px-6 py-3 bg-white text-[#003B7A] font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>กลับหน้าหลัก</span>
          </NuxtLink>
        </div>

        <!-- Centered Profile Card Container -->
        <div class="flex justify-center mb-12">
          <div class="w-full max-w-xl">
            <ProfileCard />
          </div>
        </div>
      </div>

      <!-- Stats Grid - Below the gradient, overlapping -->
      <div class="relative w-full px-4 sm:px-6 lg:px-8 -mt-16">
        <div class="max-w-5xl mx-auto">
          <div class="grid grid-cols-3 gap-4 lg:gap-6">
            <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-xl text-center transform hover:scale-105 transition-all duration-200">
              <div class="text-3xl mb-2">🎯</div>
              <div class="text-4xl lg:text-5xl font-bold text-[#003B7A] mb-2">8</div>
              <div class="text-sm lg:text-base text-gray-600 font-medium">คอร์สทั้งหมด</div>
            </div>
            <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-xl text-center transform hover:scale-105 transition-all duration-200">
              <div class="text-3xl mb-2">✅</div>
              <div class="text-4xl lg:text-5xl font-bold text-green-600 mb-2">5</div>
              <div class="text-sm lg:text-base text-gray-600 font-medium">จบแล้ว</div>
            </div>
            <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-xl text-center transform hover:scale-105 transition-all duration-200">
              <div class="text-3xl mb-2">⏱️</div>
              <div class="text-4xl lg:text-5xl font-bold text-purple-600 mb-2">156</div>
              <div class="text-sm lg:text-base text-gray-600 font-medium">ชั่วโมงเรียน</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Section -->
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
      <div class="max-w-7xl mx-auto space-y-8">
        <!-- Learning Progress -->
        <ClientOnly>
          <LearningProgress />
        </ClientOnly>

        <!-- Achievements -->
        <ClientOnly>
          <Achievements />
        </ClientOnly>

        <!-- Account Settings -->
        <ClientOnly>
          <AccountSettings />
        </ClientOnly>
      </div>
    </div>

    <!-- Mobile Back Button -->
    <div class="lg:hidden fixed bottom-6 right-6 z-50">
      <NuxtLink
        to="/dashboard"
        class="flex items-center justify-center w-14 h-14 bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-200 hover:scale-110"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
      </NuxtLink>
    </div>
  </div>
</template>

<script setup lang="ts">
const { checkAuth } = useAuth()
const authReady = ref(false)

definePageMeta({
  middleware: 'auth',
  layout: 'default'
})

// Page title
useHead({
  title: 'โปรไฟล์ของฉัน - E-Learning'
})

// Ensure auth is restored before rendering
onMounted(async () => {
  checkAuth()
  authReady.value = true
})
</script>
