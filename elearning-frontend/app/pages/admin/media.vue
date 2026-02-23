<template>
  <div class="media-page">
    <div class="container">
      <div class="page-header">
        <h1>จัดการสื่อการเรียน (Admin)</h1>
        <NuxtLink to="/teacher/upload-media" class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          อัปโหลดสื่อใหม่
        </NuxtLink>
      </div>

      <!-- Filter Section -->
      <div class="filters">
        <div class="filter-group">
          <label>สถานะ:</label>
          <select v-model="filters.status" @change="applyFilters" class="filter-select">
            <option value="">ทั้งหมด</option>
            <option value="published">เผยแพร่แล้ว</option>
            <option value="draft">แบบร่าง</option>
          </select>
        </div>
        <div class="filter-group">
          <label>ประเภท:</label>
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
        <p>กำลังโหลด...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="errorMessage" class="error-state">
        <p>{{ errorMessage }}</p>
      </div>

      <!-- Media List -->
      <div v-else-if="filteredMedia.length > 0" class="media-grid">
        <div v-for="media in filteredMedia" :key="media.id" class="media-card">
          <div class="media-type-badge" :class="`badge-${media.media_type}`">
            {{ getMediaTypeLabel(media.media_type) }}
          </div>
          
          <div class="media-content">
            <h3>{{ media.title }}</h3>
            <p class="description">{{ media.description || 'ไม่มีคำอธิบาย' }}</p>
            
            <!-- Teacher Info -->
            <div class="teacher-info" v-if="media.teacher">
              <span class="teacher-badge">
                👨‍🏫 {{ media.teacher.firstname }} {{ media.teacher.lastname }}
              </span>
            </div>
            
            <div class="media-meta">
              <span class="category" v-if="media.category">
                🏷️ {{ media.category }}
              </span>
              <span class="status" :class="media.status">
                {{ media.status === 'published' ? 'เผยแพร่แล้ว' : 'แบบร่าง' }}
              </span>
            </div>

            <div class="media-info">
              <span>📁 {{ formatFileSize(media.file_size) }}</span>
              <span>📅 {{ formatDate(media.created_at) }}</span>
            </div>
          </div>

          <div class="media-actions">
            <button @click="viewMedia(media.id)" class="btn-icon" title="ดู">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
            <button @click="editMedia(media.id)" class="btn-icon" title="แก้ไข">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </button>
            <button @click="deleteMediaItem(media.id)" class="btn-icon btn-delete" title="ลบ">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        <h3>{{ searchQuery || filters.status || filters.type ? 'ไม่พบสื่อที่ค้นหา' : 'ยังไม่มีสื่อการเรียน' }}</h3>
        <p>{{ searchQuery || filters.status || filters.type ? 'ลองเปลี่ยนเงื่อนไขการค้นหา' : 'ยังไม่มีสื่อการเรียนในระบบ' }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'

definePageMeta({
  middleware: 'auth'
})

const { getMedia, deleteMedia } = useMedia()

const mediaList = ref<any[]>([])
const isLoading = ref(true)
const errorMessage = ref('')
const searchQuery = ref('')
const filters = ref({
  status: '',
  type: ''
})

const fetchMedia = async () => {
  try {
    isLoading.value = true
    const response = await getMedia()
    if (response.success) {
      mediaList.value = response.data.data || []
    }
  } catch (error: any) {
    errorMessage.value = 'เกิดข้อผิดพลาดในการโหลดข้อมูล'
  } finally {
    isLoading.value = false
  }
}

const filteredMedia = computed(() => {
  let result = mediaList.value

  // Filter by status
  if (filters.value.status) {
    result = result.filter(m => m.status === filters.value.status)
  }

  // Filter by type
  if (filters.value.type) {
    result = result.filter(m => m.media_type === filters.value.type)
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
  navigateTo(`/admin/media/${id}`)
}

const editMedia = (id: string) => {
  navigateTo(`/teacher/media/edit/${id}`)
}

const deleteMediaItem = async (id: string) => {
  if (!confirm('คุณต้องการลบสื่อนี้ใช่หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้')) return

  try {
    const response = await deleteMedia(id)
    if (response.success) {
      alert('ลบสื่อสำเร็จ')
      fetchMedia()
    }
  } catch (error: any) {
    alert('เกิดข้อผิดพลาดในการลบสื่อ')
  }
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
  background: #f9fafb;
  padding: 2rem 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.page-header h1 {
  font-size: 2rem;
  font-weight: bold;
  color: #1a202c;
}

.filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
  padding: 1.5rem;
  background: white;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  flex: 1;
  min-width: 200px;
}

.filter-group label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #4a5568;
}

.filter-select,
.search-input {
  padding: 0.625rem;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.875rem;
  transition: all 0.2s;
}

.filter-select:focus,
.search-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background: #2563eb;
}

.btn svg {
  width: 1.25rem;
  height: 1.25rem;
}

.loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem;
}

.spinner {
  width: 3rem;
  height: 3rem;
  border: 4px solid #e2e8f0;
  border-top-color: #3b82f6;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-state {
  background: #fee;
  color: #c00;
  padding: 2rem;
  border-radius: 8px;
  text-align: center;
}

.media-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 1.5rem;
}

.media-card {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: all 0.2s;
  position: relative;
}

.media-card:hover {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.media-type-badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
  color: white;
}

.badge-video { background: #8b5cf6; }
.badge-audio { background: #ec4899; }
.badge-image { background: #10b981; }
.badge-document { background: #f59e0b; }
.badge-other { background: #6b7280; }

.media-content {
  margin-top: 1rem;
}

.media-content h3 {
  font-size: 1.125rem;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 0.5rem;
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
}

.teacher-info {
  margin-bottom: 0.75rem;
}

.teacher-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.25rem 0.75rem;
  background: #dbeafe;
  color: #1e40af;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
}

.media-meta {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
  margin-bottom: 0.75rem;
}

.category {
  font-size: 0.75rem;
  padding: 0.25rem 0.5rem;
  background: #f3f4f6;
  border-radius: 4px;
  color: #374151;
}

.status {
  font-size: 0.75rem;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-weight: 600;
}

.status.published {
  background: #d1fae5;
  color: #065f46;
}

.status.draft {
  background: #fef3c7;
  color: #92400e;
}

.media-info {
  display: flex;
  gap: 1rem;
  font-size: 0.875rem;
  color: #6b7280;
}

.media-actions {
  display: flex;
  gap: 0.5rem;
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid #e5e7eb;
}

.btn-icon {
  padding: 0.5rem;
  background: #f3f4f6;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-icon:hover {
  background: #e5e7eb;
}

.btn-icon.btn-delete:hover {
  background: #fee;
  color: #c00;
}

.btn-icon svg {
  width: 1.25rem;
  height: 1.25rem;
}

.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem;
  text-align: center;
}

.empty-state svg {
  width: 4rem;
  height: 4rem;
  color: #cbd5e0;
  margin-bottom: 1rem;
}

.empty-state h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #4a5568;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #718096;
  margin-bottom: 1.5rem;
}
</style>
