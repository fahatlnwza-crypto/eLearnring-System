<template>
  <div class="w-full max-w-md mx-auto">
    <div class="bg-white shadow-2xl rounded-2xl px-8 pt-8 pb-8 mb-4 backdrop-blur-sm bg-opacity-95">
      <!-- Logo Section -->
      <div class="mb-5 text-center">
        <div class="mb-3 flex justify-center">
          <!-- Logo -->
          <div class="w-24 h-24">
            <img src="~/assets/css/logoudom.png" alt="Logo" class="w-full h-full object-contain drop-shadow-md" />
          </div>
        </div>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">เข้าสู่ระบบ</h2>
        <p class="text-gray-600 mt-2 font-medium">วิทยาลัยเทคโนโลยีอุดมศึกษาพณิชยการ</p>
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
              email
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
              password
            </span>
          </label>
          <div class="relative">
            <input
              id="password"
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="••••••••"
              :disabled="isLoading"
              class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 pr-12 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
              required
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              :disabled="isLoading"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-[#003B7A] focus:outline-none transition duration-200 disabled:opacity-50"
              :title="showPassword ? 'ซ่อนรหัสผ่าน' : 'แสดงรหัสผ่าน'"
            >
              <!-- Eye Icon (Show) -->
              <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
              <!-- Eye Slash Icon (Hide) -->
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
              </svg>
            </button>
          </div>
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

      <!-- Social Login Divider -->
      <div class="mt-6 mb-6">
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white text-gray-500">หรือเข้าสู่ระบบด้วย</span>
          </div>
        </div>
      </div>

      <!-- Social Login Buttons -->
      <div class="space-y-3">
        <!-- Google Login Button -->
        <button
          type="button"
          @click="handleSocialLogin('google')"
          :disabled="isLoading"
          class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          เข้าสู่ระบบด้วย Google
        </button>

        <!-- Facebook Login Button -->
        <button
          type="button"
          @click="handleSocialLogin('facebook')"
          :disabled="isLoading"
          class="w-full flex items-center justify-center gap-3 bg-[#1877F2] text-white font-semibold py-3 px-6 rounded-lg hover:bg-[#166FE5] focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
          </svg>
          เข้าสู่ระบบด้วย Facebook
        </button>
      </div>
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
const showPassword = ref(false)

const { login, loginWithSocial } = useAuth()

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

const handleSocialLogin = async (provider: 'google' | 'facebook') => {
  errors.value = {}
  isLoading.value = true

  try {
    await loginWithSocial(provider)
    await navigateTo('/dashboard')
  } catch (error: any) {
    errors.value.general = error?.message || `เกิดข้อผิดพลาดในการเข้าสู่ระบบด้วย ${provider === 'google' ? 'Google' : 'Facebook'}`
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
