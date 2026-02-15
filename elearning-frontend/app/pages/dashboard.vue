<template>
  <div class="min-h-screen bg-gradient-to-br from-[#E8F4F8] to-[#D6EAF8]">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg border-b-4 border-[#003B7A]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">Dashboard</h1>
          </div>
          <div class="flex items-center space-x-4">
            <div class="text-[#003B7A]">
              <span class="font-semibold">สวัสดี, </span>
              <span>{{ user?.name || user?.email || 'ผู้ใช้' }}</span>
            </div>
            <button
              @click="handleLogout"
              class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150"
              :disabled="loggingOut"
            >
              {{ loggingOut ? 'กำลังออกจากระบบ...' : 'ออกจากระบบ' }}
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Welcome Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300 border-t-4 border-[#003B7A]">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] rounded-lg p-3 shadow-md">
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold text-gray-800">ข้อมูลผู้ใช้</h2>
              <p class="text-gray-600">{{ user?.email }}</p>
            </div>
          </div>
        </div>

        <!-- Stats Card 1 -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300 border-t-4 border-[#4A9FDB]">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-gradient-to-br from-[#4A9FDB] to-[#87CEEB] rounded-lg p-3 shadow-md">
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold text-gray-800">สถานะ</h2>
              <p class="text-gray-600">ใช้งานปกติ</p>
            </div>
          </div>
        </div>

        <!-- Stats Card 2 -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300 border-t-4 border-[#87CEEB]">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-gradient-to-br from-[#87CEEB] to-[#4A9FDB] rounded-lg p-3 shadow-md">
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h2 class="text-lg font-semibold text-gray-800">เข้าสู่ระบบล่าสุด</h2>
              <p class="text-gray-600">{{ formatDate(new Date()) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- User Details Card -->
      <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border-t-4 border-[#003B7A]">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent mb-4">ข้อมูลผู้ใช้ทั้งหมด</h2>
        <div class="space-y-3">
          <div class="flex border-b border-[#D6EAF8] pb-2">
            <span class="font-semibold text-[#003B7A] w-32">ชื่อ:</span>
            <span class="text-gray-600">{{ user?.name || '-' }}</span>
          </div>
          <div class="flex border-b border-[#D6EAF8] pb-2">
            <span class="font-semibold text-[#003B7A] w-32">อีเมล:</span>
            <span class="text-gray-600">{{ user?.email || '-' }}</span>
          </div>
          <div class="flex border-b border-[#D6EAF8] pb-2">
            <span class="font-semibold text-[#003B7A] w-32">สถานะบัญชี:</span>
            <span class="text-green-600 font-semibold">ใช้งานได้</span>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="mt-8">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent mb-4">เมนูด่วน</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <NuxtLink
            to="/"
            class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white font-semibold py-4 px-6 rounded-lg text-center transition duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
          >
            หน้าแรก
          </NuxtLink>
          <NuxtLink
            to="/about"
            class="bg-gradient-to-r from-[#4A9FDB] to-[#87CEEB] hover:from-[#3A8FCB] hover:to-[#77BEDA] text-white font-semibold py-4 px-6 rounded-lg text-center transition duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
          >
            เกี่ยวกับเรา
          </NuxtLink>
          <NuxtLink
            to="/contact"
            class="bg-gradient-to-r from-[#87CEEB] to-[#4A9FDB] hover:from-[#77BEDA] hover:to-[#3A8FCB] text-white font-semibold py-4 px-6 rounded-lg text-center transition duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
          >
            ติดต่อเรา
          </NuxtLink>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
const { user, logout } = useAuth()
const loggingOut = ref(false)

// Define page meta with auth middleware
definePageMeta({
  middleware: 'auth'
})

// Handle logout
const handleLogout = async () => {
  loggingOut.value = true
  try {
    await logout()
  } catch (error) {
    console.error('Logout error:', error)
  } finally {
    loggingOut.value = false
  }
}

// Format date helper
const formatDate = (date: Date) => {
  return new Intl.DateTimeFormat('th-TH', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  }).format(date)
}
</script>

<style scoped>
/* Additional styles if needed */
</style>
