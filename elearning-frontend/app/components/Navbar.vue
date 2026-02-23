<template>
  <nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo and Brand -->
        <div class="flex items-center">
          <NuxtLink to="/" class="flex items-center space-x-3 hover:opacity-80 transition">
            <img src="~/assets/css/logoudom.png" alt="Logo" class="h-10 w-10 object-contain" />
            <span class="text-xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">
              วิทยาลัยเทคโนโลยีอุดมศึกษาพณิชยการ
            </span>
          </NuxtLink>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-4">
          <NuxtLink
            to="/"
            class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100 transition"
            activeClass="text-[#003B7A] bg-gray-100"
          >
            หน้าแรก
          </NuxtLink>
          
          <NuxtLink
            v-if="isAuthenticated"
            to="/dashboard"
            class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100 transition"
            activeClass="text-[#003B7A] bg-gray-100"
          >
            แดชบอร์ด
          </NuxtLink>

          <!-- User Menu -->
          <div v-if="isAuthenticated" class="relative">
            <button
              @click="toggleUserMenu"
              class="flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100 transition"
            >
              <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] flex items-center justify-center text-white">
                {{ user?.name?.charAt(0).toUpperCase() || user?.email?.charAt(0).toUpperCase() || 'U' }}
              </div>
              <span>{{ user?.name || user?.email }}</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div
              v-if="showUserMenu"
              class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5"
              @click="showUserMenu = false"
            >
              <NuxtLink
                to="/profile"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
              >
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  โปรไฟล์
                </div>
              </NuxtLink>
              <NuxtLink
                to="/edit-profile"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
              >
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                  แก้ไขโปรไฟล์
                </div>
              </NuxtLink>
              <button
                @click="handleLogout"
                class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
              >
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  ออกจากระบบ
                </div>
              </button>
            </div>
          </div>

          <!-- Login/Register Buttons -->
          <div v-else class="flex items-center space-x-2">
            <NuxtLink
              to="/login"
              class="px-4 py-2 rounded-md text-sm font-medium text-[#003B7A] hover:bg-gray-100 transition"
            >
              เข้าสู่ระบบ
            </NuxtLink>
            <NuxtLink
              to="/register"
              class="px-4 py-2 rounded-md text-sm font-medium text-white bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:opacity-90 transition"
            >
              สมัครสมาชิก
            </NuxtLink>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
          <button
            @click="toggleMobileMenu"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-[#003B7A] hover:bg-gray-100 transition"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                v-if="!showMobileMenu"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              ></path>
              <path
                v-else
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div v-if="showMobileMenu" class="md:hidden border-t border-gray-200">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <NuxtLink
          to="/"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100"
          @click="showMobileMenu = false"
        >
          หน้าแรก
        </NuxtLink>
        <NuxtLink
          to="/about"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100"
          @click="showMobileMenu = false"
        >
          เกี่ยวกับเรา
        </NuxtLink>
        <NuxtLink
          to="/contact"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100"
          @click="showMobileMenu = false"
        >
          ติดต่อเรา
        </NuxtLink>
        <NuxtLink
          v-if="isAuthenticated"
          to="/dashboard"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100"
          @click="showMobileMenu = false"
        >
          แดชบอร์ด
        </NuxtLink>

        <!-- Mobile User Menu -->
        <div v-if="isAuthenticated" class="border-t border-gray-200 pt-4 pb-3">
          <div class="flex items-center px-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] flex items-center justify-center text-white text-lg">
              {{ user?.name?.charAt(0).toUpperCase() || user?.email?.charAt(0).toUpperCase() || 'U' }}
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800">{{ user?.name || user?.email }}</div>
            </div>
          </div>
          <NuxtLink
            to="/profile"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100"
            @click="showMobileMenu = false"
          >
            โปรไฟล์
          </NuxtLink>
          <NuxtLink
            to="/edit-profile"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[#003B7A] hover:bg-gray-100"
            @click="showMobileMenu = false"
          >
            แก้ไขโปรไฟล์
          </NuxtLink>
          <button
            @click="handleLogout"
            class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-gray-100"
          >
            ออกจากระบบ
          </button>
        </div>

        <!-- Mobile Login/Register -->
        <div v-else class="border-t border-gray-200 pt-4 pb-3 space-y-2">
          <NuxtLink
            to="/login"
            class="block px-3 py-2 rounded-md text-base font-medium text-[#003B7A] hover:bg-gray-100 text-center"
            @click="showMobileMenu = false"
          >
            เข้าสู่ระบบ
          </NuxtLink>
          <NuxtLink
            to="/register"
            class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:opacity-90 text-center"
            @click="showMobileMenu = false"
          >
            สมัครสมาชิก
          </NuxtLink>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
const { isAuthenticated, user, logout } = useAuth()
const showMobileMenu = ref(false)
const showUserMenu = ref(false)

const toggleMobileMenu = () => {
  showMobileMenu.value = !showMobileMenu.value
  showUserMenu.value = false
}

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value
}

const handleLogout = async () => {
  showUserMenu.value = false
  showMobileMenu.value = false
  await logout()
}

// Close menus when clicking outside
onMounted(() => {
  if (typeof window !== 'undefined') {
    document.addEventListener('click', (e) => {
      const target = e.target as HTMLElement
      if (!target.closest('.relative') && !target.closest('button')) {
        showUserMenu.value = false
      }
    })
  }
})
</script>