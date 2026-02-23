<template>
  <div class="media-page">
    <div class="container">
      <div class="page-header">
        <h1>สื่อการเรียน</h1>
        <p class="subtitle">เรียนรู้ผ่านสื่อการสอนที่หลากหลาย</p>
      </div>

      <!-- Filter Section -->
      <div class="filters">
        <div class="filter-group">
          <label>ประเภทสื่อ:</label>
          <select v-model="filters.type" @change="applyFilters" class="filter-select">
            <option value="">ทั้งหมด</option>
            <option value="video">วิดีโอ</option>
            <option value="audio">เสียง</option>
            <option value="image">รูปภาพ</option>
            <option value="document">เอกสาร</option>
            <option value="other">อื่นๆ</option>
          </select>
        </div>
        <div class="filter-group">
          <label>หมวดหมู่:</label>
          <select v-model="filters.category" @change="applyFilters" class="filter-select">
            <option value="">ทั้งหมด</option>
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
        </div>
        <div class="filter-group search-group">
          <label>ค้นหา:</label>
          <input 
            v-model="searchQuery" 
            @input="applyFilters"
            type="text" 
            placeholder="ค้นหาชื่อสื่อ..." 
            class="search-input"
          />
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="loading">
        <div class="spinner"></div>
        <p>กำลังโหลดสื่อการเรียน...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="errorMessage" class="error-state">
        <p>{{ errorMessage }}</p>
        <button @click="fetchMedia" class="btn-retry">ลองอีกครั้ง</button>
      </div>

      <!-- Media Grid -->
      <div v-else-if="filteredMedia.length > 0" class="media-grid">
        <div v-for="media in filteredMedia" :key="media.id" class="media-card" @click="viewMedia(media.id)">
          <div class="media-thumbnail">
            <div class="media-type-badge" :class="`badge-${media.media_type}`">
              <span v-if="media.media_type === 'video'">🎬</span>
              <span v-else-if="media.media_type === 'audio'">🎵</span>
              <span v-else-if="media.media_type === 'image'">🖼️</span>
              <span v-else-if="media.media_type === 'document'">📄</span>
              <span v-else>📦</span>
              {{ getMediaTypeLabel(media.media_type) }}
            </div>
          </div>
          
          <div class="media-content">
            <h3>{{ media.title }}</h3>
            <p class="description">{{ media.description || 'ไม่มีคำอธิบาย' }}</p>
            
            <div class="media-meta">
              <span class="category" v-if="media.category">
                🏷️ {{ media.category }}
              </span>
              <span class="teacher" v-if="media.teacher">
                👨‍🏫 {{ media.teacher.firstname }} {{ media.teacher.lastname }}
              </span>
            </div>

            <div class="media-footer">
              <span class="file-size">📁 {{ formatFileSize(media.file_size) }}</span>
              <span class="date">📅 {{ formatDate(media.created_at) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        <h3>{{ searchQuery || filters.type || filters.category ? 'ไม่พบสื่อที่ค้นหา' : 'ยังไม่มีสื่อการเรียน' }}</h3>
        <p>{{ searchQuery || filters.type || filters.category ? 'ลองเปลี่ยนเงื่อนไขการค้นหา' : 'ยังไม่มีสื่อการเรียนในระบบ' }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'

definePageMeta({
  middleware: 'auth'
})

const { getMedia } = useMedia()

const mediaList = ref<any[]>([])
const isLoading = ref(true)
const errorMessage = ref('')
const searchQuery = ref('')
const filters = ref({
  type: '',
  category: ''
})

const categories = computed(() => {
  const cats = new Set<string>()
  mediaList.value.forEach(media => {
    if (media.category) {
      cats.add(media.category)
    }
  })
  return Array.from(cats).sort()
})

const fetchMedia = async () => {
  try {
    isLoading.value = true
    errorMessage.value = ''
    const response = await getMedia()
    if (response.success) {
      // Only show published media for students
      mediaList.value = (response.data.data || []).filter((m: any) => m.status === 'published')
    }
  } catch (error: any) {
    errorMessage.value = 'เกิดข้อผิดพลาดในการโหลดข้อมูล'
  } finally {
    isLoading.value = false
  }
}

const filteredMedia = computed(() => {
  let result = mediaList.value

  // Filter by type
  if (filters.value.type) {
    result = result.filter(m => m.media_type === filters.value.type)
  }

  // Filter by category
  if (filters.value.category) {
    result = result.filter(m => m.category === filters.value.category)
  }

  // Search by title
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(m => m.title.toLowerCase().includes(query))
  }

  return result
})

const applyFilters = () => {
  // Filters are applied automatically via computed property
}

const viewMedia = (id: string) => {
  navigateTo(`/student/media/${id}`)
}

const getMediaTypeLabel = (type: string) => {
  const labels: Record<string, string> = {
    video: 'วิดีโอ',
    document: 'เอกสาร',
    image: 'รูปภาพ',
    audio: 'เสียง',
    other: 'อื่นๆ'
  }
  return labels[type] || type
}

const formatFileSize = (bytes: number) => {
  if (!bytes) return '0 B'
  const k = 1024
  const sizes = ['B', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('th-TH', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

onMounted(() => {
  fetchMedia()
})
</script>

<style scoped>
.media-page {
  min-height: 100vh;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 2rem 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.page-header {
  text-align: center;
  margin-bottom: 2.5rem;
  color: white;
}

.page-header h1 {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.subtitle {
  font-size: 1.125rem;
  opacity: 0.9;
}

.filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
  padding: 1.5rem;
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  flex: 1;
  min-width: 180px;
}

.search-group {
  flex: 2;
}

.filter-group label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #4a5568;
}

.filter-select,
.search-input {
  padding: 0.75rem;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  font-size: 0.875rem;
  transition: all 0.2s;
}

.filter-select:focus,
.search-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
  color: #c00;
  padding: 2rem;
  border-radius: 16px;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-retry {
  margin-top: 1rem;
  padding: 0.75rem 1.5rem;
  background: #667eea;
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-retry:hover {
  background: #5a67d8;
}

.media-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.media-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: all 0.3s;
  cursor: pointer;
}

.media-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.media-thumbnail {
  height: 160px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.media-type-badge {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 700;
  color: white;
  background: rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(10px);
}

.media-type-badge span {
  font-size: 1.5rem;
}

.media-content {
  padding: 1.5rem;
}

.media-content h3 {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 0.5rem;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
}

.description {
  font-size: 0.875rem;
  color: #718096;
  margin-bottom: 1rem;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  min-height: 2.5rem;
}

.media-meta {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
  margin-bottom: 1rem;
}

.category,
.teacher {
  font-size: 0.75rem;
  padding: 0.25rem 0.625rem;
  border-radius: 6px;
  font-weight: 600;
}

.category {
  background: #fef3c7;
  color: #92400e;
}

.teacher {
  background: #dbeafe;
  color: #1e40af;
}

.media-footer {
  display: flex;
  justify-content: space-between;
  padding-top: 1rem;
  border-top: 1px solid #e5e7eb;
  font-size: 0.875rem;
  color: #6b7280;
}

.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem;
  text-align: center;
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.empty-state svg {
  width: 5rem;
  height: 5rem;
  color: #cbd5e0;
  margin-bottom: 1rem;
}

.empty-state h3 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #4a5568;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #718096;
}
</style>
