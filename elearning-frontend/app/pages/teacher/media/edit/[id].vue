<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Edit Form -->
      <div v-else-if="media" class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
          <h1 class="text-2xl font-bold text-gray-900">แก้ไขสื่อการเรียน</h1>
          <p class="text-gray-600 text-sm mt-1">แก้ไขข้อมูลสื่อและอัปโหลดไฟล์ใหม่ (ถ้าต้องการ)</p>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-6">
          <!-- Media Type -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              ประเภทสื่อ <span class="text-red-500">*</span>
            </label>
            <select 
              v-model="formData.media_type"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option value="video">วิดีโอ</option>
              <option value="audio">เสียง</option>
              <option value="image">รูปภาพ</option>
              <option value="document">เอกสาร</option>
              <option value="other">อื่นๆ</option>
            </select>
          </div>

          <!-- Title -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              ชื่อเรื่อง <span class="text-red-500">*</span>
            </label>
            <input
              v-model="formData.title"
              type="text"
              required
              placeholder="ระบุชื่อเรื่อง"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              คำอธิบาย
            </label>
            <textarea
              v-model="formData.description"
              rows="4"
              placeholder="ระบุคำอธิบายเกี่ยวกับสื่อนี้"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            ></textarea>
          </div>

          <!-- Category -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              หมวดหมู่
            </label>
            <input
              v-model="formData.category"
              type="text"
              placeholder="เช่น ฝึกสมาธิ, บทสวดมนต์"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
          </div>

          <!-- Current File Info -->
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm font-medium text-blue-900 mb-2">ไฟล์ปัจจุบัน:</p>
            <p class="text-sm text-blue-700">{{ media.file_name }}</p>
            <p class="text-xs text-blue-600 mt-1">{{ formatFileSize(media.file_size) }}</p>
          </div>

          <!-- File Upload (Optional) -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              เปลี่ยนไฟล์ใหม่ (ถ้าต้องการ)
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition">
              <div class="space-y-1 text-center">
                <svg
                  class="mx-auto h-12 w-12 text-gray-400"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 48 48"
                >
                  <path
                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
                <div class="flex text-sm text-gray-600">
                  <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                    <span>เลือกไฟล์</span>
                    <input
                      ref="fileInput"
                      type="file"
                      class="sr-only"
                      @change="handleFileChange"
                    />
                  </label>
                  <p class="pl-1">หรือลากไฟล์มาวาง</p>
                </div>
                <p class="text-xs text-gray-500">รองรับไฟล์ขนาดสูงสุด 512MB</p>
              </div>
            </div>

            <!-- Selected File Preview -->
            <div v-if="selectedFile" class="mt-3 flex items-center gap-3 bg-green-50 border border-green-200 rounded-lg p-3">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <div class="flex-1">
                <p class="text-sm font-medium text-green-900">{{ selectedFile.name }}</p>
                <p class="text-xs text-green-700">{{ formatFileSize(selectedFile.size) }}</p>
              </div>
              <button
                @click="removeFile"
                type="button"
                class="text-red-600 hover:text-red-800"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              สถานะ <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-4">
              <label class="flex items-center">
                <input
                  v-model="formData.status"
                  type="radio"
                  value="draft"
                  class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                />
                <span class="ml-2 text-gray-700">แบบร่าง</span>
              </label>
              <label class="flex items-center">
                <input
                  v-model="formData.status"
                  type="radio"
                  value="published"
                  class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                />
                <span class="ml-2 text-gray-700">เผยแพร่</span>
              </label>
            </div>
          </div>

          <!-- Error Message -->
          <div v-if="errorMessage" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <p class="font-medium">{{ errorMessage }}</p>
            <div v-if="validationErrors" class="mt-2 text-sm">
              <ul class="list-disc list-inside">
                <li v-for="(errors, field) in validationErrors" :key="field">
                  {{ errors[0] }}
                </li>
              </ul>
            </div>
          </div>

          <!-- Success Message -->
          <div v-if="successMessage" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <p class="font-medium">{{ successMessage }}</p>
          </div>

          <!-- Actions -->
          <div class="flex gap-3 pt-4 border-t">
            <button
              type="button"
              @click="$router.back()"
              class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition"
            >
              ยกเลิก
            </button>
            <button
              type="submit"
              :disabled="uploading"
              class="flex-1 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="uploading">กำลังบันทึก...</span>
              <span v-else>บันทึกการแก้ไข</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: 'auth'
})

const route = useRoute()
const router = useRouter()
const { getMediaById, updateMedia } = useMedia()

const mediaId = route.params.id as string

const media = ref<any>(null)
const loading = ref(true)
const uploading = ref(false)
const errorMessage = ref('')
const validationErrors = ref<any>(null)
const successMessage = ref('')

const formData = ref({
  title: '',
  description: '',
  media_type: 'video',
  category: '',
  status: 'published'
})

const selectedFile = ref<File | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)

// Fetch media details
onMounted(async () => {
  try {
    loading.value = true
    const response = await getMediaById(mediaId)
    if (response.success) {
      media.value = response.data
      // Populate form with existing data
      formData.value = {
        title: media.value.title,
        description: media.value.description || '',
        media_type: media.value.media_type,
        category: media.value.category || '',
        status: media.value.status
      }
    } else {
      errorMessage.value = response.message || 'ไม่พบข้อมูลสื่อที่ต้องการ'
    }
  } catch (err: any) {
    errorMessage.value = err.message || 'เกิดข้อผิดพลาดในการโหลดข้อมูล'
  } finally {
    loading.value = false
  }
})

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files.length > 0) {
    selectedFile.value = target.files[0]
  }
}

const removeFile = () => {
  selectedFile.value = null
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const handleSubmit = async () => {
  try {
    uploading.value = true
    errorMessage.value = ''
    validationErrors.value = null
    successMessage.value = ''

    const submitData = new FormData()
    submitData.append('title', formData.value.title)
    submitData.append('description', formData.value.description)
    submitData.append('media_type', formData.value.media_type)
    submitData.append('category', formData.value.category)
    submitData.append('status', formData.value.status)

    // Add file if selected
    if (selectedFile.value) {
      submitData.append('file', selectedFile.value)
    }

    const response = await updateMedia(mediaId, submitData)

    if (response.success) {
      successMessage.value = 'บันทึกการแก้ไขสำเร็จ'
      setTimeout(() => {
        router.push(`/teacher/media/${mediaId}`)
      }, 1500)
    } else {
      errorMessage.value = response.message || 'เกิดข้อผิดพลาดในการบันทึก'
      validationErrors.value = response.errors
    }
  } catch (error: any) {
    console.error('Update error:', error)
    errorMessage.value = error.data?.message || 'เกิดข้อผิดพลาดในการบันทึก'
    validationErrors.value = error.data?.errors
  } finally {
    uploading.value = false
  }
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}
</script>
