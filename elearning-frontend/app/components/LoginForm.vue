<template>
  <div class="w-full max-w-md mx-auto">
    <div class="bg-white shadow-2xl rounded-2xl px-8 pt-8 pb-8 mb-4 backdrop-blur-sm bg-opacity-95">
      <!-- Logo Section -->
      <div class="mb-6 text-center">
        <div class="mb-4 flex justify-center">
          <div class="w-24 h-24 bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] rounded-full flex items-center justify-center shadow-lg">
            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
          </div>
        </div>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">เข้าสู่ระบบ</h2>
        <p class="text-gray-600 mt-2 font-medium">ยินดีต้อนรับกลับมา</p>
      </div>

      <!-- Error Message -->
      <div v-if="errors.general" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
        <span class="block sm:inline">{{ errors.general }}</span>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-5">
        <!-- Email Field -->
        <div>
          <label class="block text-[#003B7A] text-sm font-bold mb-2" for="email">
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
              </svg>
              อีเมล
            </span>
          </label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            placeholder="your@email.com"
            :disabled="isLoading"
            class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
            required
          />
          <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
        </div>

        <!-- Password Field -->
        <div>
          <label class="block text-[#003B7A] text-sm font-bold mb-2" for="password">
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
              </svg>
              รหัสผ่าน
            </span>
          </label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            placeholder="••••••••"
            :disabled="isLoading"
            class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
            required
          />
          <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
          <label class="flex items-center">
            <input
              v-model="form.rememberMe"
              type="checkbox"
              :disabled="isLoading"
              class="w-4 h-4 text-[#003B7A] border-gray-300 rounded focus:ring-[#4A9FDB] disabled:opacity-50"
            />
            <span class="ml-2 text-sm text-gray-600">จำไว้ในคอมพิวเตอร์นี้</span>
          </label>
          <NuxtLink to="/forgot-password" class="text-sm text-[#003B7A] hover:text-[#4A9FDB] font-medium transition duration-200">
            ลืมรหัสผ่าน?
          </NuxtLink>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between">
          <button
            type="submit"
            class="w-full bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-[#4A9FDB] focus:ring-opacity-50 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            :disabled="isLoading"
          >
            <span v-if="isLoading" class="flex items-center justify-center">
              <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              กำลังเข้าสู่ระบบ...
            </span>
            <span v-else class="flex items-center justify-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
              </svg>
              เข้าสู่ระบบ
            </span>
          </button>
        </div>
      </form>
    </div>

    <!-- Register link -->
    <div class="text-center bg-white bg-opacity-90 rounded-lg py-4 px-6 shadow-md">
      <span class="text-gray-600">ยังไม่มีบัญชี? </span>
      <NuxtLink to="/register" class="text-[#003B7A] hover:text-[#4A9FDB] font-bold transition duration-200">
        สมัครสมาชิก
      </NuxtLink>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center text-white text-sm">
      <p class="drop-shadow-md">© 2026 E-Learning. All rights reserved.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
interface LoginForm {
  email: string
  password: string
  rememberMe: boolean
}

interface Errors {
  email?: string
  password?: string
  general?: string
}

const form = ref<LoginForm>({
  email: '',
  password: '',
  rememberMe: false
})

const errors = ref<Errors>({})
const isLoading = ref(false)

const { login } = useAuth()

const handleLogin = async () => {
  // Reset errors
  errors.value = {}

  // Validation
  if (!form.value.email) {
    errors.value.email = 'อีเมลจำเป็นต้องระบุ'
  }
  if (!form.value.password) {
    errors.value.password = 'รหัสผ่านจำเป็นต้องระบุ'
  }

  if (Object.keys(errors.value).length > 0) {
    return
  }

  isLoading.value = true

  try {
    // Call login from useAuth composable
    const response = await login(form.value.email, form.value.password, form.value.rememberMe)
    
    if (response?.token) {
      await navigateTo('/dashboard')
    } else {
      errors.value.general = response?.message || 'เกิดข้อผิดพลาดในการเข้าสู่ระบบ'
    }
  } catch (error: any) {
    errors.value.general = error?.data?.message || error?.message || 'เกิดข้อผิดพลาดในการเข้าสู่ระบบ'
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
