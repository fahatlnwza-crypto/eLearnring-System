<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
      <!-- Header -->
      <div class="mb-8 flex items-center justify-between">
        <div>
          <h1 class="text-4xl font-bold text-gray-800 mb-2">แก้ไขโปรไฟล์</h1>
          <p class="text-gray-600">อัพเดทข้อมูลส่วนตัวของคุณ</p>
        </div>
        <NuxtLink
          to="/profile"
          class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200 flex items-center gap-2"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          กลับ
        </NuxtLink>
      </div>

      <!-- Edit Form Card -->
      <div class="bg-white rounded-2xl shadow-lg p-8">
        <form @submit.prevent="handleSubmit" class="space-y-6">
          <!-- Profile Image Section -->
          <div class="flex flex-col items-center mb-6">
            <div class="relative group mb-4">
              <img
                :src="formData.avatar || '/default-avatar.svg'"
                alt="Profile"
                class="w-32 h-32 rounded-full border-4 border-gray-200 shadow-lg object-cover"
              />
              <button
                type="button"
                @click="openImageUpload"
                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-full flex items-center justify-center transition-all duration-200"
              >
                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </button>
              <input
                ref="fileInput"
                type="file"
                accept="image/*"
                class="hidden"
                @change="handleImageUpload"
              />
            </div>
            <p class="text-sm text-gray-500">คลิกที่รูปเพื่อเปลี่ยน (JPG, PNG, สูงสุด 5MB)</p>
          </div>

          <!-- Personal Information -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Username -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                ชื่อผู้ใช้ *
              </label>
              <input
                v-model="formData.username"
                type="text"
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <!-- Email (Read-only) -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                อีเมล
                <span class="text-xs text-gray-500">(ไม่สามารถแก้ไขได้)</span>
              </label>
              <div class="relative">
                <input
                  v-model="formData.email"
                  type="email"
                  disabled
                  class="w-full px-4 py-3 pr-10 border-2 border-gray-200 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                />
                <svg class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
            </div>

            <!-- First Name -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                ชื่อ *
              </label>
              <input
                v-model="formData.firstname"
                type="text"
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <!-- Last Name -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                นามสกุล *
              </label>
              <input
                v-model="formData.lastname"
                type="text"
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <!-- Birthday -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                วันเกิด
              </label>
              <input
                v-model="formData.birthday"
                type="date"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <!-- Gender -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                เพศ
              </label>
              <select
                v-model="formData.gender"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="">เลือกเพศ</option>
                <option value="male">ชาย</option>
                <option value="female">หญิง</option>
                <option value="other">อื่นๆ</option>
              </select>
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                เบอร์โทรศัพท์
              </label>
              <input
                v-model="formData.phone"
                type="tel"
                placeholder="08X-XXX-XXXX"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
          </div>

          <!-- Bio -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              เกี่ยวกับฉัน
            </label>
            <textarea
              v-model="formData.bio"
              rows="4"
              placeholder="เขียนข้อมูลเกี่ยวกับตัวเอง..."
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
            ></textarea>
            <p class="text-xs text-gray-500 mt-1">{{ formData.bio?.length || 0 }}/500 ตัวอักษร</p>
          </div>

          <!-- Success/Error Message -->
          <div v-if="successMessage" class="p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
            {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
            {{ errorMessage }}
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-4 pt-4">
            <button
              type="submit"
              class="flex-1 py-3 bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
            >
              บันทึกการเปลี่ยนแปลง
            </button>
            <NuxtLink
              to="/profile"
              class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200"
            >
              ยกเลิก
            </NuxtLink>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: 'auth',
  layout: 'default'
})

useHead({
  title: 'Edit Profile - E-Learning'
})

const { user } = useAuth()
const fileInput = ref<HTMLInputElement | null>(null)
const successMessage = ref('')
const errorMessage = ref('')

const formData = ref({
  username: user.value?.username || '',
  email: user.value?.email || '',
  firstname: user.value?.firstname || '',
  lastname: user.value?.lastname || '',
  birthday: user.value?.birthday || '',
  gender: user.value?.gender || '',
  phone: user.value?.phone || '',
  bio: user.value?.bio || '',
  avatar: user.value?.avatar || ''
})

const openImageUpload = () => {
  fileInput.value?.click()
}

const handleImageUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    // Check file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
      errorMessage.value = 'ไฟล์รูปภาพต้องมีขนาดไม่เกิน 5MB'
      setTimeout(() => errorMessage.value = '', 3000)
      return
    }

    const reader = new FileReader()
    reader.onload = (e) => {
      formData.value.avatar = e.target?.result as string
    }
    reader.readAsDataURL(file)
  }
}

const handleSubmit = async () => {
  try {
    errorMessage.value = ''
    successMessage.value = ''

    // Validate bio length
    if (formData.value.bio && formData.value.bio.length > 500) {
      errorMessage.value = 'ข้อมูลเกี่ยวกับตัวเองต้องไม่เกิน 500 ตัวอักษร'
      return
    }

    // TODO: Call API to update profile
    // const response = await updateProfile(formData.value)

    successMessage.value = 'บันทึกข้อมูลสำเร็จ!'
    
    // Redirect after 2 seconds
    setTimeout(() => {
      navigateTo('/profile')
    }, 2000)

  } catch (error: any) {
    errorMessage.value = error?.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
  }
}
</script>
