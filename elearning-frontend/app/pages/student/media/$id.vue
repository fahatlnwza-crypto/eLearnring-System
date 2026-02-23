<template>
  <div class="media-detail-page">
    <div class="container">
      <!-- Loading State -->
      <div v-if="loading" class="loading">
        <div class="spinner"></div>
        <p>กำลังโหลด...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="error-state">
        <p class="font-medium">เกิดข้อผิดพลาด</p>
        <p class="text-sm">{{ error }}</p>
        <button @click="$router.back()" class="mt-4 btn-back">
          กลับไปหน้าก่อนหน้า
        </button>
      </div>

      <!-- Media Details -->
      <div v-else-if="media" class="">
        

        <!-- Media Player Section -->
        <div class="player-section">
          <button @click="$router.back()" class="btn-back-top">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          กลับ
        </button>
          <!-- Video -->
          <div v-if="media.media_type === 'video'" class="video-player">
            <OptimizedVideoPlayer
              :file-url="media.file_url"
              :qualities="media.qualities || []"
            />
          </div>

          <!-- Audio -->
          <div v-else-if="media.media_type === 'audio'" class="audio-player">
            <div class="audio-icon">🎵</div>
            <audio
              :src="media.file_url"
              controls
              controlsList="nodownload"
              class="w-full"
              crossorigin="anonymous"
            >
              เบราว์เซอร์ของคุณไม่รองรับการเล่นเสียง
            </audio>
          </div>

          <!-- Image -->
          <div v-else-if="media.media_type === 'image'" class="image-viewer">
            <img
              :src="media.file_url"
              :alt="media.title"
              class="rounded-2xl shadow-2xl"
              crossorigin="anonymous"
            />
          </div>

          <!-- Document/Other -->
          <div v-else class="document-viewer">
            <svg class="document-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <p class="document-name">{{ media.file_name }}</p>
            <a
              :href="media.file_url"
              target="_blank"
              class="btn-download"
            >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
              ดาวน์โหลดไฟล์
            </a>
          </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
          <div class="content-header">
            <div class="badges">
              <span class="badge badge-type" :class="`badge-${media.media_type}`">
                {{ getMediaTypeLabel(media.media_type) }}
              </span>
              <span v-if="media.category" class="badge badge-category">
                {{ media.category }}
              </span>
            </div>
            <h1 class="title">{{ media.title }}</h1>
            <div class="teacher-info" v-if="media.teacher">
              <div class="teacher-avatar">
                👨‍🏫
              </div>
              <div>
                <p class="teacher-label">ผู้สอน</p>
                <p class="teacher-name">{{ media.teacher.firstname }} {{ media.teacher.lastname }}</p>
              </div>
            </div>
          </div>

          <div class="content-body">
            <div v-if="media.description" class="description-section">
              <h2 class="section-title">คำอธิบาย</h2>
              <p class="description">{{ media.description }}</p>
            </div>

            <div class="info-grid">
              <div class="info-item">
                <div class="info-icon">📁</div>
                <div>
                  <p class="info-label">ขนาดไฟล์</p>
                  <p class="info-value">{{ formatFileSize(media.file_size) }}</p>
                </div>
              </div>
              <div class="info-item">
                <div class="info-icon">📄</div>
                <div>
                  <p class="info-label">ประเภทไฟล์</p>
                  <p class="info-value">{{ media.file_type }}</p>
                </div>
              </div>
              <div class="info-item">
                <div class="info-icon">📅</div>
                <div>
                  <p class="info-label">วันที่อัปโหลด</p>
                  <p class="info-value">{{ formatDate(media.created_at) }}</p>
                </div>
              </div>
              <div class="info-item">
                <div class="info-icon">🔄</div>
                <div>
                  <p class="info-label">อัปเดตล่าสุด</p>
                  <p class="info-value">{{ formatDate(media.updated_at) }}</p>
                </div>
              </div>
            </div>
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
const { getMediaById } = useMedia()

const media = ref(null)
const loading = ref(true)
const error = ref('')

const mediaId = route.params.id as string

// Fetch media details
onMounted(async () => {
  try {
    loading.value = true
    console.log('🔍 Fetching media:', mediaId)
    const response = await getMediaById(mediaId)
    console.log('📦 API Response:', response)
    if (response.success) {
      console.log('✅ Media data:', response.data)
      console.log('🎬 File URL:', response.data.file_url)
      // Check if media is published
      if (response.data.status !== 'published') {
        error.value = 'สื่อนี้ยังไม่ได้เผยแพร่'
      } else {
        media.value = response.data
        console.log('✨ Media set to:', media.value)
      }
    } else {
      error.value = response.message || 'ไม่พบข้อมูลสื่อที่ต้องการ'
      console.error('❌ API Error:', error.value)
    }
  } catch (err: any) {
    error.value = err.message || 'เกิดข้อผิดพลาดในการโหลดข้อมูล'
    console.error('💥 Exception:', err)
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
</script>

<style scoped>
.media-detail-page {
  min-height: 100vh;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 2rem 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem;
  color: white;
}

.spinner {
  width: 3rem;
  height: 3rem;
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-state {
  background: white;
  padding: 3rem;
  border-radius: 16px;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  color: #c00;
}

.btn-back-top {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  background: white;
  color: #667eea;
  border: none;
  border-radius: 12px;
  font-weight: 600;
  cursor: pointer;
  margin-bottom: 1.5rem;
  transition: all 0.2s;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-back-top:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.btn-back-top svg {
  width: 1.25rem;
  height: 1.25rem;
}

.btn-back {
  padding: 0.75rem 1.5rem;
  background: #667eea;
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-back:hover {
  background: #5a67d8;
}

/* .media-detail {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
} */

@media (min-width: 1024px) {
  .media-detail {
    grid-template-columns: 2fr 1fr;
  }
}

.player-section {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  margin-bottom: 1rem;
}

.video-player video,
.image-viewer img {
  width: 100%;
  height: auto;
  display: block;
}

.audio-player {
  text-align: center;
  padding: 3rem 1rem;
}

.audio-icon {
  font-size: 5rem;
  margin-bottom: 2rem;
}

.document-viewer {
  text-align: center;
  padding: 3rem 1rem;
}

.document-icon {
  width: 5rem;
  height: 5rem;
  color: #cbd5e0;
  margin: 0 auto 1.5rem;
}

.document-name {
  font-size: 1rem;
  color: #4a5568;
  margin-bottom: 1.5rem;
  word-break: break-word;
}

.btn-download {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  background: #667eea;
  color: white;
  border-radius: 10px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s;
}

.btn-download:hover {
  background: #5a67d8;
  transform: translateY(-2px);
}

.btn-download svg {
  width: 1.25rem;
  height: 1.25rem;
}

.content-section {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.content-header {
  margin-bottom: 2rem;
  padding-bottom: 2rem;
  border-bottom: 2px solid #e5e7eb;
}

.badges {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
  margin-bottom: 1rem;
}

.badge {
  padding: 0.375rem 0.875rem;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 600;
}

.badge-type {
  color: white;
}

.badge-video { background: #8b5cf6; }
.badge-audio { background: #ec4899; }
.badge-image { background: #10b981; }
.badge-document { background: #f59e0b; }
.badge-other { background: #6b7280; }

.badge-category {
  background: #fef3c7;
  color: #92400e;
}

.title {
  font-size: 2rem;
  font-weight: bold;
  color: #1a202c;
  margin-bottom: 1.5rem;
  line-height: 1.3;
}

.teacher-info {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.teacher-avatar {
  width: 3rem;
  height: 3rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}

.teacher-label {
  font-size: 0.75rem;
  color: #718096;
  margin-bottom: 0.25rem;
}

.teacher-name {
  font-size: 1rem;
  font-weight: 600;
  color: #4a5568;
}

.content-body {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.section-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 0.75rem;
}

.description {
  font-size: 1rem;
  color: #4a5568;
  line-height: 1.7;
  white-space: pre-wrap;
}

.info-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

@media (min-width: 640px) {
  .info-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.info-item {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  background: #f9fafb;
  border-radius: 12px;
}

.info-icon {
  width: 2.5rem;
  height: 2.5rem;
  background: white;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  flex-shrink: 0;
}

.info-label {
  font-size: 0.75rem;
  color: #718096;
  margin-bottom: 0.25rem;
}

.info-value {
  font-size: 0.875rem;
  font-weight: 600;
  color: #4a5568;
  word-break: break-word;
}
</style>
