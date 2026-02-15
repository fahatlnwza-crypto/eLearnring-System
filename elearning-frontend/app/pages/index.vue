<template>
  <div class="min-h-screen bg-gradient-to-br from-[#E8F4F8] via-white to-[#D6EAF8]">
    <!-- Navigation -->
    <nav class="bg-white shadow-md border-b-4 border-[#003B7A]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">
              E-Learning
            </h1>
          </div>
          <div class="flex items-center space-x-4">
            <NuxtLink
              v-if="!isAuthenticated"
              to="/login"
              class="text-[#003B7A] hover:text-[#4A9FDB] px-3 py-2 rounded-md text-sm font-medium transition duration-200"
            >
              เข้าสู่ระบบ
            </NuxtLink>
            <NuxtLink
              v-if="isAuthenticated"
              to="/dashboard"
              class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 shadow-md"
            >
              Dashboard
            </NuxtLink>
            <button
              v-if="isAuthenticated"
              @click="handleLogout"
              class="text-[#003B7A] hover:text-[#4A9FDB] px-3 py-2 rounded-md text-sm font-medium transition duration-200"
            >
              ออกจากระบบ
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
            ยินดีต้อนรับสู่
            <span class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">
              E-Learning Platform
            </span>
          </h1>
          <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
            แพลตฟอร์มการเรียนรู้ออนไลน์ที่ทันสมัย พัฒนาทักษะของคุณด้วยคอร์สเรียนคุณภาพจากผู้เชี่ยวชาญ
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <NuxtLink
              v-if="!isAuthenticated"
              to="/login"
              class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-lg hover:shadow-xl"
            >
              เริ่มต้นใช้งาน
            </NuxtLink>
            <NuxtLink
              v-if="isAuthenticated"
              to="/dashboard"
              class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-lg hover:shadow-xl"
            >
              ไปที่ Dashboard
            </NuxtLink>
            <NuxtLink
              to="/about"
              class="bg-white hover:bg-gray-50 text-gray-900 font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-lg hover:shadow-xl border-2 border-gray-200"
            >
              เรียนรู้เพิ่มเติม
            </NuxtLink>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
          ทำไมต้องเลือกเรา?
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div class="bg-gradient-to-br from-[#E8F4F8] to-[#87CEEB] rounded-lg p-8 shadow-md hover:shadow-xl transition duration-300">
            <div class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] w-14 h-14 rounded-full flex items-center justify-center mb-4 shadow-lg">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">คอร์สเรียนหลากหลาย</h3>
            <p class="text-gray-700">
              เลือกเรียนได้จากคอร์สมากมายในหลากหลายสาขา
            </p>
          </div>

          <!-- Feature 2 -->
          <div class="bg-gradient-to-br from-[#D6EAF8] to-[#4A9FDB] rounded-lg p-8 shadow-md hover:shadow-xl transition duration-300 opacity-95">
            <div class="bg-gradient-to-r from-[#4A9FDB] to-[#003B7A] w-14 h-14 rounded-full flex items-center justify-center mb-4 shadow-lg">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">เรียนรู้แบบยืดหยุ่น</h3>
            <p class="text-gray-700">
              เรียนได้ทุกที่ทุกเวลาที่สะดวกสำหรับคุณ
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="bg-gradient-to-br from-[#E8F4F8] to-[#D6EAF8] rounded-lg p-8 shadow-md hover:shadow-xl transition duration-300">
            <div class="bg-gradient-to-br from-[#003B7A] via-[#4A9FDB] to-[#87CEEB] w-14 h-14 rounded-full flex items-center justify-center mb-4 shadow-lg">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">ใบรับรองออนไลน์</h3>
            <p class="text-gray-700">
              รับใบรับรองเมื่อจบคอร์สเรียนสำเร็จ
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-[#003B7A] via-[#4A9FDB] to-[#87CEEB] relative overflow-hidden">
      <!-- Decorative wave -->
      <div class="absolute inset-0 opacity-10">
        <svg class="absolute bottom-0 w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
          <path fill="white" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
      </div>
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-4xl font-bold text-white mb-6 drop-shadow-lg">
          พร้อมที่จะเริ่มต้นแล้วหรือยัง?
        </h2>
        <p class="text-xl text-white mb-8 drop-shadow">
          เข้าร่วมกับผู้เรียนหลายพันคนที่กำลังพัฒนาทักษะของตนเอง
        </p>
        <NuxtLink
          v-if="!isAuthenticated"
          to="/login"
          class="inline-block bg-white hover:bg-gray-50 text-[#003B7A] font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-xl hover:shadow-2xl hover:scale-105 transform"
        >
          เริ่มต้นเรียนฟรี
        </NuxtLink>
        <NuxtLink
          v-if="isAuthenticated"
          to="/dashboard"
          class="inline-block bg-white hover:bg-gray-50 text-[#003B7A] font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-xl hover:shadow-2xl hover:scale-105 transform"
        >
          ไปที่ Dashboard
        </NuxtLink>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-4 md:mb-0">
            <p class="text-gray-400">© 2026 E-Learning Platform. All rights reserved.</p>
          </div>
          <div class="flex space-x-6">
            <NuxtLink to="/about" class="text-gray-400 hover:text-white transition duration-150">
              เกี่ยวกับเรา
            </NuxtLink>
            <NuxtLink to="/contact" class="text-gray-400 hover:text-white transition duration-150">
              ติดต่อเรา
            </NuxtLink>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
const { isAuthenticated, logout, checkAuth } = useAuth()

// Check auth on mount
onMounted(() => {
  checkAuth()
})

// Handle logout
const handleLogout = async () => {
  await logout()
}
</script>

<style scoped>
/* Page-specific styles */
</style>
