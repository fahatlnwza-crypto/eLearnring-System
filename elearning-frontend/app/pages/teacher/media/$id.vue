<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4">
      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
        <p class="font-medium">เกิดข้อผิดพลาด</p>
        <p class="text-sm">{{ error }}</p>
        <button @click="$router.back()" class="mt-2 text-sm underline">
          กลับไปหน้าก่อนหน้า
        </button>
      </div>

      <!-- Media Details -->
      <div v-else-if="media" class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-6 text-white">
          <div class="flex justify-between items-start">
            <div>
              <h1 class="text-3xl font-bold mb-2">{{ media.title }}</h1>
              <div class="flex gap-4 text-sm">
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                  </svg>
                  {{ getMediaTypeLabel(media.media_type) }}
                </span>
                <span v-if="media.category" class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                  </svg>
                  {{ media.category }}
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                  </svg>
                  {{ formatFileSize(media.file_size) }}
                </span>
              </div>
            </div>
            <span
              :class="[
                'px-3 py-1 rounded-full text-xs font-medium',
                media.status === 'published' ? 'bg-green-500' : 'bg-yellow-500'
              ]"
            >
              {{ media.status === 'published' ? 'เผยแพร่แล้ว' : 'แบบร่าง' }}
            </span>
          </div>
        </div>

        <!-- Content -->
        <div class="p-6">
          <!-- Description -->
          <div v-if="media.description" class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">คำอธิบาย</h2>
            <p class="text-gray-700 whitespace-pre-wrap">{{ media.description }}</p>
          </div>

          <!-- Media Preview -->
          <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">ไฟล์สื่อ</h2>
            
            <!-- Video -->
            <div v-if="media.media_type === 'video'" class="aspect-video bg-black rounded-lg overflow-hidden">
              <OptimizedVideoPlayer
                :file-url="media.file_url"
                :qualities="media.qualities || []"
              />
            </div>

            <!-- Audio -->
            <div v-else-if="media.media_type === 'audio'" class="bg-gray-100 rounded-lg p-6">
              <audio
                :src="media.file_url"
                controls
                class="w-full"
                controlsList="nodownload"
                crossorigin="anonymous"
              >
                เบราว์เซอร์ของคุณไม่รองรับการเล่นเสียง
              </audio>
            </div>

            <!-- Image -->
            <div v-else-if="media.media_type === 'image'" class="rounded-lg overflow-hidden">
              <img
                :src="media.file_url"
                :alt="media.title"
                class="w-full h-auto"
                crossorigin="anonymous"
              />
            </div>

            <!-- Document/Other -->
            <div v-else class="bg-gray-50 rounded-lg p-8 text-center">
              <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
              </svg>
              <p class="text-gray-600 mb-2">{{ media.file_name }}</p>
              <a
                :href="media.file_url"
                target="_blank"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                ดาวน์โหลดไฟล์
              </a>
            </div>
          </div>

          <!-- Metadata -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6 border-t">
            <div>
              <p class="text-sm text-gray-500">ชื่อไฟล์ต้นฉบับ</p>
              <p class="font-medium text-gray-900">{{ media.file_name }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">ประเภทไฟล์</p>
              <p class="font-medium text-gray-900">{{ media.file_type }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">วันที่อัปโหลด</p>
              <p class="font-medium text-gray-900">{{ formatDate(media.created_at) }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">อัปเดตล่าสุด</p>
              <p class="font-medium text-gray-900">{{ formatDate(media.updated_at) }}</p>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex gap-3 mt-6 pt-6 border-t">
            <button
              @click="$router.back()"
              class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition"
            >
              กลับ
            </button>
            <NuxtLink
              :to="`/teacher/media/edit/${media.id}`"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition"
            >
              แก้ไข
            </NuxtLink>
            <button
              @click="confirmDelete"
              class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition ml-auto"
            >
              ลบสื่อ
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

definePageMeta({
  middleware: 'auth'
})

const route = useRoute()
const router = useRouter()
const { getMediaById, deleteMedia } = useMedia()

const media = ref(null)
const loading = ref(true)
const error = ref('')

const mediaId = route.params.id as string

// Fetch media details
onMounted(async () => {
  try {
    loading.value = true
    console.log('🔍 [Teacher] Fetching media:', mediaId)
    const response = await getMediaById(mediaId)
    console.log('📦 [Teacher] API Response:', response)
    if (response.success) {
      media.value = response.data
      console.log('✅ [Teacher] Media loaded:', media.value)
      console.log('🎬 [Teacher] File URL:', response.data.file_url)
    } else {
      error.value = response.message || 'ไม่พบข้อมูลสื่อที่ต้องการ'
      console.error('❌ [Teacher] API Error:', error.value)
    }
  } catch (err: any) {
    error.value = err.message || 'เกิดข้อผิดพลาดในการโหลดข้อมูล'
    console.error('💥 [Teacher] Exception:', err)
  } finally {
    loading.value = false
  }
})

const getMediaTypeLabel = (type: string) => {
  const labels: Record<string, string> = {
    video: 'วิดีโอ',
    audio: 'เสียง',
    image: 'รูปภาพ',
    document: 'เอกสาร',
    other: 'อื่นๆ'
  }
  return labels[type] || type
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('th-TH', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const confirmDelete = async () => {
  if (!confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสื่อนี้? การกระทำนี้ไม่สามารถย้อนกลับได้')) {
    return
  }

  try {
    const response = await deleteMedia(mediaId)
    if (response.success) {
      alert('ลบสื่อสำเร็จแล้ว')
      router.push('/teacher/media')
    } else {
      alert('เกิดข้อผิดพลาด: ' + response.message)
    }
  } catch (err: any) {
    alert('เกิดข้อผิดพลาด: ' + err.message)
  }
}
</script>
