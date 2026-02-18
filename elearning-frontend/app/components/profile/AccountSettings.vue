<template>
  <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
    <!-- Header with gradient accent -->
    <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-gradient-to-r from-gray-600 to-gray-800">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-gray-800 rounded-xl flex items-center justify-center shadow-md">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
        </div>
        <div>
          <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent">
            การตั้งค่าบัญชี
          </h2>
          <p class="text-xs text-gray-500 mt-0.5">จัดการข้อมูลและความปลอดภัย</p>
        </div>
      </div>
    </div>

    <!-- Settings Options -->
    <div class="space-y-4">
      <!-- Change Password -->
      <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 hover:border-blue-400 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-start justify-between">
          <div class="flex items-start gap-3 flex-1">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-xl p-3 shadow-md group-hover:scale-110 transition-transform duration-200">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-gray-800 mb-1 group-hover:text-blue-700 transition-colors">เปลี่ยนรหัสผ่าน</h3>
              <p class="text-sm text-gray-600">อัพเดทรหัสผ่านของคุณเพื่อความปลอดภัย</p>
            </div>
          </div>
          <button
            @click="openChangePassword"
            class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105"
          >
            เปลี่ยน
          </button>
        </div>
      </div>

      <!-- Update Profile Info -->
      <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-4 hover:border-green-400 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-start justify-between">
          <div class="flex items-start gap-3 flex-1">
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-xl p-3 shadow-md group-hover:scale-110 transition-transform duration-200">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-gray-800 mb-1 group-hover:text-green-700 transition-colors">แก้ไขข้อมูลโปรไฟล์</h3>
              <p class="text-sm text-gray-600">อัพเดทข้อมูลส่วนตัวและประวัติ</p>
            </div>
          </div>
          <button
            @click="navigateTo('/edit-profile')"
            class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105"
          >
            แก้ไข
          </button>
        </div>
      </div>

      <!-- Upload Profile Image -->
      <div class="bg-gradient-to-br from-purple-50 to-pink-50 border-2 border-purple-200 rounded-xl p-4 hover:border-purple-400 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-start justify-between">
          <div class="flex items-start gap-3 flex-1">
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-xl p-3 shadow-md group-hover:scale-110 transition-transform duration-200">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-gray-800 mb-1 group-hover:text-purple-700 transition-colors">อัพโหลดรูปโปรไฟล์</h3>
              <p class="text-sm text-gray-600">เปลี่ยนรูปภาพโปรไฟล์ของคุณ</p>
            </div>
          </div>
          <button
            @click="openImageUpload"
            class="px-5 py-2.5 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105"
          >
            อัพโหลด
          </button>
          <input
            ref="fileInput"
            type="file"
            accept="image/*"
            class="hidden"
            @change="handleImageUpload"
          />
        </div>
      </div>

      <!-- Email Notifications -->
      <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-xl p-4 hover:border-yellow-400 hover:shadow-lg transition-all duration-300">
        <div class="flex items-start justify-between">
          <div class="flex items-start gap-3 flex-1">
            <div class="bg-gradient-to-br from-yellow-500 to-orange-600 text-white rounded-xl p-3 shadow-md">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-gray-800 mb-1">การแจ้งเตือนทางอีเมล</h3>
              <p class="text-sm text-gray-600">จัดการการแจ้งเตือนและข่าวสาร</p>
            </div>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input v-model="emailNotifications" type="checkbox" class="sr-only peer" />
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
          </label>
        </div>
      </div>

      <!-- Delete Account -->
      <div class="bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-300 rounded-xl p-4 hover:border-red-400 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-start justify-between">
          <div class="flex items-start gap-3 flex-1">
            <div class="bg-gradient-to-br from-red-500 to-rose-600 text-white rounded-xl p-3 shadow-md group-hover:scale-110 transition-transform duration-200">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-red-700 mb-1 group-hover:text-red-800 transition-colors">ลบบัญชี</h3>
              <p class="text-sm text-red-600">ลบบัญชีและข้อมูลทั้งหมดของคุณอย่างถาวร</p>
            </div>
          </div>
          <button
            @click="openDeleteConfirmation"
            class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105"
          >
            ลบบัญชี
          </button>
        </div>
      </div>
    </div>

    <!-- Change Password Modal -->
    <Teleport to="body">
      <div
        v-if="showPasswordModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click.self="closePasswordModal"
      >
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">เปลี่ยนรหัสผ่าน</h3>
            <button
              @click="closePasswordModal"
              class="text-gray-400 hover:text-gray-600 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <form @submit.prevent="handleChangePassword" class="space-y-4">
            <!-- Current Password -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">รหัสผ่านปัจจุบัน</label>
              <div class="relative">
                <input
                  v-model="passwordForm.currentPassword"
                  :type="showCurrentPassword ? 'text' : 'password'"
                  class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                />
                <button
                  type="button"
                  @click="showCurrentPassword = !showCurrentPassword"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                >
                  <svg v-if="!showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                  </svg>
                </button>
              </div>
            </div>

            <!-- New Password -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">รหัสผ่านใหม่</label>
              <div class="relative">
                <input
                  v-model="passwordForm.newPassword"
                  :type="showNewPassword ? 'text' : 'password'"
                  class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                />
                <button
                  type="button"
                  @click="showNewPassword = !showNewPassword"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                >
                  <svg v-if="!showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                  </svg>
                </button>
              </div>
            </div>

            <!-- Confirm Password -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">ยืนยันรหัสผ่านใหม่</label>
              <input
                v-model="passwordForm.confirmPassword"
                type="password"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>

            <!-- Error Message -->
            <div v-if="passwordError" class="p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg text-sm">
              {{ passwordError }}
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2">
              <button
                type="submit"
                class="flex-1 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors duration-200"
              >
                เปลี่ยนรหัสผ่าน
              </button>
              <button
                type="button"
                @click="closePasswordModal"
                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200"
              >
                ยกเลิก
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!-- Delete Account Confirmation Modal -->
    <Teleport to="body">
      <div
        v-if="showDeleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click.self="closeDeleteModal"
      >
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
          <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
              <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">ยืนยันการลบบัญชี</h3>
            <p class="text-gray-600 mb-4">การดำเนินการนี้ไม่สามารถย้อนกลับได้</p>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-left">
              <p class="text-sm text-red-700 mb-2 font-semibold">ข้อมูลต่อไปนี้จะถูกลบอย่างถาวร:</p>
              <ul class="text-sm text-red-600 space-y-1">
                <li>• ข้อมูลส่วนตัวทั้งหมด</li>
                <li>• ความคืบหน้าในการเรียน</li>
                <li>• ใบรับรองและเหรียญรางวัล</li>
                <li>• ประวัติการเรียนทั้งหมด</li>
              </ul>
            </div>
          </div>

          <form @submit.prevent="handleDeleteAccount" class="space-y-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                พิมพ์ "DELETE" เพื่อยืนยัน
              </label>
              <input
                v-model="deleteConfirmText"
                type="text"
                placeholder="DELETE"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                required
              />
            </div>

            <div class="flex gap-3">
              <button
                type="button"
                @click="closeDeleteModal"
                class="flex-1 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200"
              >
                ยกเลิก
              </button>
              <button
                type="submit"
                :disabled="deleteConfirmText !== 'DELETE'"
                class="flex-1 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                ลบบัญชี
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
const fileInput = ref<HTMLInputElement | null>(null)
const emailNotifications = ref(true)

// Password Modal
const showPasswordModal = ref(false)
const showCurrentPassword = ref(false)
const showNewPassword = ref(false)
const passwordError = ref('')
const passwordForm = ref({
  currentPassword: '',
  newPassword: '',
  confirmPassword: ''
})

// Delete Modal
const showDeleteModal = ref(false)
const deleteConfirmText = ref('')

const openChangePassword = () => {
  showPasswordModal.value = true
  passwordError.value = ''
  passwordForm.value = {
    currentPassword: '',
    newPassword: '',
    confirmPassword: ''
  }
}

const closePasswordModal = () => {
  showPasswordModal.value = false
}

const handleChangePassword = () => {
  passwordError.value = ''

  if (passwordForm.value.newPassword.length < 8) {
    passwordError.value = 'รหัสผ่านใหม่ต้องมีอย่างน้อย 8 ตัวอักษร'
    return
  }

  if (passwordForm.value.newPassword !== passwordForm.value.confirmPassword) {
    passwordError.value = 'รหัสผ่านใหม่ไม่ตรงกัน'
    return
  }

  // TODO: Call API to change password
  alert('เปลี่ยนรหัสผ่านสำเร็จ!')
  closePasswordModal()
}

const openImageUpload = () => {
  fileInput.value?.click()
}

const handleImageUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    // TODO: Upload image to server
    alert('อัพโหลดรูปภาพสำเร็จ!')
  }
}

const openDeleteConfirmation = () => {
  showDeleteModal.value = true
  deleteConfirmText.value = ''
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
}

const handleDeleteAccount = () => {
  if (deleteConfirmText.value === 'DELETE') {
    // TODO: Call API to delete account
    alert('บัญชีถูกลบแล้ว')
    closeDeleteModal()
    // Redirect to home or login page
    navigateTo('/')
  }
}
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.animate-fade-in {
  animation: fadeIn 0.2s ease-out;
}
</style>
