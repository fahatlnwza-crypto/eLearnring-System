<template>
  <div class="min-h-screen bg-gradient-to-br from-[#87CEEB] via-[#4A9FDB] to-[#003B7A] flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full text-center">
      <div v-if="loading">
        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-[#003B7A] mx-auto mb-4"></div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">กำลังเข้าสู่ระบบ...</h2>
        <p class="text-gray-600">โปรดรอสักครู่</p>
      </div>

      <div v-else-if="error">
        <div class="text-red-500 mb-4">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">เกิดข้อผิดพลาด</h2>
        <p class="text-gray-600 mb-4">{{ error }}</p>
        <button
          @click="redirectToLogin"
          class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] text-white font-bold py-2 px-6 rounded-lg hover:from-[#002855] hover:to-[#3A8FCB] transition-all duration-200"
        >
          กลับไปหน้าเข้าสู่ระบบ
        </button>
      </div>

      <div v-else>
        <div class="text-green-500 mb-4">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">เข้าสู่ระบบสำเร็จ!</h2>
        <p class="text-gray-600">กำลังเปลี่ยนหน้า...</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface SocialAuthResponse {
  token: string
  user: {
    id: string | number
    username: string
    email: string
    firstname: string
    lastname: string
    name: string
    avatar?: string
  }
  message?: string
}

definePageMeta({
  layout: false,
})

const route = useRoute()
const loading = ref(true)
const error = ref('')

const redirectToLogin = () => {
  window.close()
  if (!window.closed) {
    navigateTo('/login')
  }
}

onMounted(async () => {
  try {
    const provider = route.params.provider as string
    
    if (!provider || !['google', 'facebook'].includes(provider)) {
      error.value = 'Provider ไม่ถูกต้อง'
      loading.value = false
      return
    }

    // Parse the full URL including query parameters
    const fullUrl = window.location.href
    const urlParams = new URLSearchParams(window.location.search)
    
    // Get authorization code or error
    const code = urlParams.get('code')
    const authError = urlParams.get('error')

    if (authError) {
      error.value = 'การเข้าสู่ระบบถูกยกเลิก'
      loading.value = false
      
      // Send error to parent window
      if (window.opener) {
        window.opener.postMessage({
          type: 'social-login-error',
          message: error.value
        }, '*')
      }
      return
    }

    if (!code) {
      error.value = 'ไม่พบรหัสการยืนยัน'
      loading.value = false
      return
    }

    // Call backend callback endpoint
    const config = useRuntimeConfig()
    const response = await $fetch<SocialAuthResponse>(`${config.public.apiBaseUrl}/api/auth/${provider}/callback${window.location.search}`, {
      method: 'GET'
    })

    if (response.token && response.user) {
      // Send success message to parent window
      if (window.opener) {
        window.opener.postMessage({
          type: 'social-login-success',
          token: response.token,
          user: response.user
        }, '*')
        
        // Close popup after short delay
        setTimeout(() => {
          window.close()
        }, 1000)
      } else {
        // If not in popup, redirect to dashboard
        const { user, token } = response
        const auth = useAuth()
        
        // Manually set auth state
        if (typeof window !== 'undefined') {
          localStorage.setItem('auth_token', token)
          localStorage.setItem('auth_user', JSON.stringify(user))
        }
        
        await navigateTo('/dashboard')
      }
    } else {
      error.value = 'ไม่สามารถเข้าสู่ระบบได้'
    }

    loading.value = false
  } catch (err: any) {
    error.value = err?.data?.message || err?.message || 'เกิดข้อผิดพลาดในการเข้าสู่ระบบ'
    loading.value = false
    
    // Send error to parent window
    if (window.opener) {
      window.opener.postMessage({
        type: 'social-login-error',
        message: error.value
      }, '*')
    }
  }
})
</script>
