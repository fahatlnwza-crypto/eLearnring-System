<template>
  <div class="w-full max-w-md mx-auto">
    <div class="bg-white shadow-2xl rounded-2xl px-8 pt-8 pb-8 mb-4 backdrop-blur-sm bg-opacity-95">
      <!-- Logo Section -->
      <div class="mb-6 text-center">
        <div class="mb-4 flex justify-center">
          <div class="w-24 h-24 bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] rounded-full flex items-center justify-center shadow-lg">
            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
          </div>
        </div>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">สมัครสมาชิก</h2>
        <p class="text-gray-600 mt-2 font-medium">สร้างบัญชีใหม่เพื่อเริ่มต้นเรียนรู้</p>
      </div>

      <!-- Error message -->
      <div v-if="errorMessage" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
        <span class="block sm:inline">{{ errorMessage }}</span>
        <ul v-if="validationErrors" class="mt-2 text-sm list-disc list-inside">
          <li v-for="(errors, field) in validationErrors" :key="field">
            {{ errors[0] }}
          </li>
        </ul>
      </div>

      <!-- Success message -->
      <div v-if="successMessage" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
        <span class="block sm:inline">{{ successMessage }}</span>
      </div>

      <form @submit.prevent="handleSubmit">
        <!-- Username field -->
        <div class="mb-5">
          <label class="block text-[#003B7A] text-sm font-bold mb-2" for="username">
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              ชื่อผู้ใช้
            </span>
          </label>
          <input
            id="username"
            v-model="formData.username"
            type="text"
            class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
            placeholder="username"
            required
            :disabled="loading"
          />
        </div>

        <!-- Firstname field -->
        <div class="mb-5">
          <label class="block text-[#003B7A] text-sm font-bold mb-2" for="firstname">
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              ชื่อจริง
            </span>
          </label>
          <input
            id="firstname"
            v-model="formData.firstname"
            type="text"
            class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
            placeholder="กรอกชื่อจริง"
            required
            :disabled="loading"
          />
        </div>

        <!-- Lastname field -->
        <div class="mb-5">
          <label class="block text-[#003B7A] text-sm font-bold mb-2" for="lastname">
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              นามสกุล
            </span>
          </label>
          <input
            id="lastname"
            v-model="formData.lastname"
            type="text"
            class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
            placeholder="กรอกนามสกุล"
            required
            :disabled="loading"
          />
        </div>

        <!-- Email field -->
        <div class="mb-5">
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
            v-model="formData.email"
            type="email"
            class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
            placeholder="your@email.com"
            required
            :disabled="loading"
          />
        </div>

        <!-- Password field -->
        <div class="mb-5">
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
            v-model="formData.password"
            type="password"
            class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
            placeholder="••••••••"
            required
            minlength="8"
            :disabled="loading"
          />
          <p class="text-xs text-gray-500 mt-1">รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร</p>
        </div>

        <!-- Password Confirmation field -->
        <div class="mb-6">
          <label class="block text-[#003B7A] text-sm font-bold mb-2" for="password_confirmation">
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              ยืนยันรหัสผ่าน
            </span>
          </label>
          <input
            id="password_confirmation"
            v-model="formData.password_confirmation"
            type="password"
            class="shadow-sm appearance-none border-2 border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#003B7A] transition duration-200"
            placeholder="••••••••"
            required
            minlength="8"
            :disabled="loading"
          />
        </div>

        <!-- Submit button -->
        <div class="flex items-center justify-between">
          <button
            type="submit"
            class="w-full bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-[#4A9FDB] focus:ring-opacity-50 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            :disabled="loading"
          >
            <span v-if="loading" class="flex items-center justify-center">
              <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              กำลังสมัครสมาชิก...
            </span>
            <span v-else class="flex items-center justify-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
              </svg>
              สมัครสมาชิก
            </span>
          </button>
        </div>
      </form>
    </div>

    <!-- Login link -->
    <div class="text-center bg-white bg-opacity-90 rounded-lg py-4 px-6 shadow-md">
      <span class="text-gray-600">มีบัญชีอยู่แล้ว? </span>
      <NuxtLink to="/login" class="text-[#003B7A] hover:text-[#4A9FDB] font-bold transition duration-200">
        เข้าสู่ระบบ
      </NuxtLink>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center text-white text-sm">
      <p class="drop-shadow-md">© 2026 E-Learning. All rights reserved.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
const { register } = useAuth()
const router = useRouter()

// Form state
const formData = reactive({
  username: '',
  firstname: '',
  lastname: '',
  email: '',
  password: '',
  password_confirmation: '',
  birthday: '',
  gender: ''
})

const loading = ref(false)
const errorMessage = ref('')
const successMessage = ref('')
const validationErrors = ref<any>(null)

// Handle form submission
const handleSubmit = async () => {
  loading.value = true
  errorMessage.value = ''
  successMessage.value = ''
  validationErrors.value = null

  // Check if passwords match
  if (formData.password !== formData.password_confirmation) {
    errorMessage.value = 'รหัสผ่านไม่ตรงกัน'
    loading.value = false
    return
  }

  try {
    const result = await register(
      formData.username,
      formData.email,
      formData.password,
      formData.password_confirmation,
      formData.firstname,
      formData.lastname,
      formData.birthday || undefined,
      formData.gender || undefined
    )

    if (result.success) {
      successMessage.value = 'สมัครสมาชิกสำเร็จ! กำลังเปลี่ยนหน้า...'
      
      // Redirect to dashboard after short delay
      setTimeout(() => {
        router.push('/dashboard')
      }, 1500)
    } else {
      errorMessage.value = result.error || 'สมัครสมาชิกไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
      validationErrors.value = result.errors
    }
  } catch (error: any) {
    console.error('Register error:', error)
    errorMessage.value = error.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
