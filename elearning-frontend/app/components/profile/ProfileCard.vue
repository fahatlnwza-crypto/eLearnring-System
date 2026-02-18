<template>
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
    <!-- Cover Image with Pattern -->
    <div class="h-40 bg-gradient-to-r from-[#003B7A] via-[#4A9FDB] to-[#003B7A] relative overflow-hidden">
      <!-- Decorative Pattern -->
      <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
              <circle cx="20" cy="20" r="1" fill="white"/>
            </pattern>
          </defs>
          <rect width="100%" height="100%" fill="url(#pattern)"/>
        </svg>
      </div>
      <!-- Animated gradient overlay -->
      <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/5 to-transparent"></div>
    </div>
    
    <!-- Profile Content -->
    <div class="relative px-6 pb-6">
      <!-- Profile Image with Ring Animation -->
      <div class="relative -mt-20 mb-6 flex justify-center">
        <div class="relative group">
          <!-- Glow effect -->
          <div class="absolute inset-0 bg-gradient-to-r from-[#4A9FDB] to-[#003B7A] rounded-full blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
          
          <!-- Image -->
          <div class="relative">
            <img
              :src="profileData.avatar || '/default-avatar.svg'"
              alt="Profile"
              class="w-36 h-36 rounded-full border-4 border-white shadow-xl object-cover ring-4 ring-blue-100 group-hover:ring-blue-200 transition-all duration-300"
            />
            
            <!-- Edit Button with better positioning -->
            <button
              @click="openImageUpload"
              class="absolute bottom-1 right-1 bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] text-white p-2.5 rounded-full shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-200 opacity-0 group-hover:opacity-100"
              title="เปลี่ยนรูปโปรไฟล์"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
            </button>
          </div>
          
          <input
            ref="fileInput"
            type="file"
            accept="image/*"
            class="hidden"
            @change="handleImageUpload"
          />
        </div>
      </div>

      <!-- Name Section with Badge -->
      <div class="text-center mb-6">
        <div v-if="!isEditingName" class="flex items-center justify-center gap-2 mb-2">
          <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
            {{ profileData.firstname }} {{ profileData.lastname }}
          </h2>
          <button
            @click="startEditName"
            class="text-gray-400 hover:text-[#003B7A] transition-all duration-200 hover:scale-110"
            title="แก้ไขชื่อ"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
          </button>
        </div>
        <div v-else class="space-y-3 mb-4">
          <div class="flex gap-2">
            <input
              v-model="editForm.firstname"
              type="text"
              placeholder="ชื่อ"
              class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-transparent transition-all duration-200"
            />
            <input
              v-model="editForm.lastname"
              type="text"
              placeholder="นามสกุล"
              class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-transparent transition-all duration-200"
            />
          </div>
          <div class="flex gap-2 justify-center">
            <button
              @click="saveName"
              class="px-6 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200"
            >
              ✓ บันทึก
            </button>
            <button
              @click="cancelEditName"
              class="px-6 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 text-sm font-semibold transition-all duration-200"
            >
              ✕ ยกเลิก
            </button>
          </div>
        </div>
        
        <!-- Username Badge -->
        <div class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full border border-blue-100">
          <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span class="text-sm font-medium text-blue-700">@{{ profileData.username }}</span>
        </div>
      </div>

      <!-- Info Grid with Modern Design -->
      <div class="space-y-3 mb-6">
        <!-- Email -->
        <div class="group flex items-start gap-3 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:border-blue-200 transition-all duration-200 hover:shadow-md">
          <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center shadow-sm">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-blue-600 mb-0.5">อีเมล</p>
            <p class="text-sm font-medium text-gray-800 truncate">{{ profileData.email }}</p>
          </div>
          <div class="flex-shrink-0 w-8 h-8 bg-white rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
          </div>
        </div>

        <!-- Student ID -->
        <div class="group flex items-start gap-3 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-100 hover:border-purple-200 transition-all duration-200 hover:shadow-md">
          <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center shadow-sm">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
            </svg>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-purple-600 mb-0.5">รหัสนักศึกษา</p>
            <p class="text-sm font-medium text-gray-800">{{ profileData.studentId || 'N/A' }}</p>
          </div>
          <div class="flex-shrink-0 w-8 h-8 bg-white rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
          </div>
        </div>

        <!-- Major -->
        <div class="group flex items-start gap-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100 hover:border-green-200 transition-all duration-200 hover:shadow-md">
          <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center shadow-sm">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-green-600 mb-0.5">สาขาวิชา</p>
            <p class="text-sm font-medium text-gray-800">{{ profileData.major || 'N/A' }}</p>
          </div>
          <div class="flex-shrink-0 w-8 h-8 bg-white rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
          </div>
        </div>

        <!-- Year -->
        <div class="group flex items-start gap-3 p-4 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl border border-orange-100 hover:border-orange-200 transition-all duration-200 hover:shadow-md">
          <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg flex items-center justify-center shadow-sm">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-orange-600 mb-0.5">ชั้นปี</p>
            <p class="text-sm font-medium text-gray-800">{{ profileData.year || 'N/A' }}</p>
          </div>
          <div class="flex-shrink-0 w-8 h-8 bg-white rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
          </div>
        </div>
      </div>

      <!-- Bio Section with Modern Design -->
      <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
          <label class="text-sm font-bold text-gray-700 flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            เกี่ยวกับฉัน
          </label>
          <button
            v-if="!isEditingBio"
            @click="startEditBio"
            class="text-gray-400 hover:text-[#003B7A] transition-all duration-200 hover:scale-110"
            title="แก้ไขข้อมูล"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
          </button>
        </div>
        
        <div v-if="!isEditingBio" class="p-4 bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl border border-gray-200">
          <p class="text-sm text-gray-700 leading-relaxed">
            {{ profileData.bio || 'ยังไม่ได้เพิ่มข้อมูลเกี่ยวกับตัวเอง...' }}
          </p>
        </div>
        <div v-else class="space-y-3">
          <textarea
            v-model="editForm.bio"
            rows="4"
            placeholder="เขียนข้อมูลเกี่ยวกับตัวเอง..."
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4A9FDB] focus:border-transparent resize-none transition-all duration-200"
          ></textarea>
          <div class="flex gap-2">
            <button
              @click="saveBio"
              class="flex-1 px-4 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200"
            >
              ✓ บันทึก
            </button>
            <button
              @click="cancelEditBio"
              class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 text-sm font-semibold transition-all duration-200"
            >
              ✕ ยกเลิก
            </button>
          </div>
        </div>
      </div>

      <!-- Meta Info with Icons and Modern Style -->
      <div class="pt-6 border-t-2 border-gray-100 space-y-3">
        <div class="flex items-center gap-3 text-sm">
          <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div class="flex-1">
            <p class="text-xs text-gray-500 font-medium">สมาชิกตั้งแต่</p>
            <p class="text-sm font-semibold text-gray-700">{{ formatDate(profileData.memberSince) }}</p>
          </div>
        </div>
        <div class="flex items-center gap-3 text-sm">
          <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div class="flex-1">
            <p class="text-xs text-gray-500 font-medium">เข้าสู่ระบบล่าสุด</p>
            <p class="text-sm font-semibold text-gray-700">{{ formatDate(profileData.lastLogin) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const { user } = useAuth()

const fileInput = ref<HTMLInputElement | null>(null)
const isEditingName = ref(false)
const isEditingBio = ref(false)

const profileData = ref({
  avatar: user.value?.avatar || '',
  firstname: user.value?.firstname || 'Test',
  lastname: user.value?.lastname || 'User',
  email: user.value?.email || 'test@example.com',
  username: user.value?.username || 'testuser',
  studentId: '6501234567',
  major: 'เทคโนโลยีสารสนเทศ',
  year: 'ปี 3',
  bio: 'นักศึกษาที่มีความสนใจในการเรียนรู้เทคโนโลยีใหม่ๆ และชอบพัฒนาโปรเจกต์ที่น่าสนใจ',
  memberSince: '2024-01-15',
  lastLogin: new Date().toISOString()
})

const editForm = ref({
  firstname: profileData.value.firstname,
  lastname: profileData.value.lastname,
  bio: profileData.value.bio
})

const openImageUpload = () => {
  fileInput.value?.click()
}

const handleImageUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = (e) => {
      profileData.value.avatar = e.target?.result as string
      // TODO: Upload to server
    }
    reader.readAsDataURL(file)
  }
}

const startEditName = () => {
  editForm.value.firstname = profileData.value.firstname
  editForm.value.lastname = profileData.value.lastname
  isEditingName.value = true
}

const saveName = () => {
  profileData.value.firstname = editForm.value.firstname
  profileData.value.lastname = editForm.value.lastname
  isEditingName.value = false
  // TODO: Save to server
}

const cancelEditName = () => {
  isEditingName.value = false
}

const startEditBio = () => {
  editForm.value.bio = profileData.value.bio
  isEditingBio.value = true
}

const saveBio = () => {
  profileData.value.bio = editForm.value.bio
  isEditingBio.value = false
  // TODO: Save to server
}

const cancelEditBio = () => {
  isEditingBio.value = false
}

const formatDate = (dateString: string) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('th-TH', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>
