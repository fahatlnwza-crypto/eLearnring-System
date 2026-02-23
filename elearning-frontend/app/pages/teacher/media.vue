<template>
  <div class="media-page">
    <div class="container">
      <div class="page-header">
        <h1>จัดการสื่อการเรียน</h1>
        <NuxtLink to="/teacher/upload-media" class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          อัปโหลดสื่อใหม่
        </NuxtLink>
      </div>

      <!-- Search Bar -->
      <div class="search-section">
        <div class="search-bar">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="search-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input 
            v-model="searchQuery" 
            type="text" 
            placeholder="ค้นหาสื่อการเรียน บทเรียน หรือเนื้อหา..." 
            class="search-input"
            @input="handleSearch"
          />
          <button v-if="searchQuery" @click="clearSearch" class="clear-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="filter-tabs">
          <button 
            v-for="tab in filterTabs" 
            :key="tab.value" 
            @click="selectedFilter = tab.value; fetchMedia()"
            :class="['filter-tab', { active: selectedFilter === tab.value }]"
          >
            {{ tab.label }}
          </button>
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
      <div v-else-if="mediaList.length > 0" class="media-grid">
        <div v-for="media in mediaList" :key="media.id" class="media-card">
          <div class="media-type-badge" :class="`badge-${media.media_type}`">
            {{ getMediaTypeLabel(media.media_type) }}
          </div>
          
          <div class="media-content">
            <h3>{{ media.title }}</h3>
            <p class="description">{{ media.description || 'ไม่มีคำอธิบาย' }}</p>
            
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
        <h3>ยังไม่มีสื่อการเรียน</h3>
        <p>เริ่มต้นอัปโหลดสื่อการเรียนของคุณได้เลย</p>
        <NuxtLink to="/teacher/upload-media" class="btn btn-primary">
          อัปโหลดสื่อแรก
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

definePageMeta({
  middleware: 'auth'
})

const { getMedia, deleteMedia } = useMedia()

const mediaList = ref<any[]>([])
const isLoading = ref(true)
const errorMessage = ref('')
const searchQuery = ref('')
const selectedFilter = ref('โปรแกรมทั้ง')
const searchTimeout = ref<number | null>(null)

const filterTabs = [
  { label: 'โปรแกรมทั้ง', value: 'โปรแกรมทั้ง' },
  { label: 'คำขวม', value: 'คำขวม' },
  { label: 'ธุรกิจ', value: 'ธุรกิจ' },
  { label: 'การตลาด', value: 'การตลาด' },
  { label: 'ภาษา', value: 'ภาษา' },
  { label: 'วิทยาศาสตร์', value: 'วิทยาศาสตร์' }
]

const fetchMedia = async () => {
  try {
    isLoading.value = true
    errorMessage.value = ''
    const response: any = await getMedia(1, searchQuery.value)
    if (response.success) {
      let data = response.data.data || []
      // Filter by category if not "โปรแกรมทั้ง"
      if (selectedFilter.value !== 'โปรแกรมทั้ง') {
        data = data.filter((item: any) => item.category === selectedFilter.value)
      }
      mediaList.value = data
    }
  } catch (error: any) {
    errorMessage.value = 'เกิดข้อผิดพลาดในการโหลดข้อมูล'
  } finally {
    isLoading.value = false
  }
}

const handleSearch = () => {
  // Debounce search
  if (searchTimeout.value) {
    clearTimeout(searchTimeout.value)
  }
  searchTimeout.value = setTimeout(() => {
    fetchMedia()
  }, 500)
}

const clearSearch = () => {
  searchQuery.value = ''
  fetchMedia()
}

const viewMedia = (id: string) => {
  navigateTo(`/teacher/media/${id}`)
}

const deleteMediaItem = async (id: string) => {
  if (!confirm('คุณต้องการลบสื่อนี้ใช่หรือไม่?')) return

  try {
    const response: any = await deleteMedia(id)
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

.search-section {
  margin-bottom: 2rem;
}

.search-bar {
  position: relative;
  max-width: 600px;
  margin-bottom: 1.5rem;
}

.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 1.25rem;
  height: 1.25rem;
  color: #9ca3af;
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 0.875rem 3rem 0.875rem 3rem;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.2s;
  background: white;
}

.search-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.clear-btn {
  position: absolute;
  right: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  padding: 0.5rem;
  background: #f3f4f6;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.clear-btn:hover {
  background: #e5e7eb;
}

.clear-btn svg {
  width: 1rem;
  height: 1rem;
  color: #6b7280;
}

.filter-tabs {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.filter-tab {
  padding: 0.5rem 1rem;
  border: 2px solid #e5e7eb;
  border-radius: 999px;
  background: white;
  color: #6b7280;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.filter-tab:hover {
  border-color: #3b82f6;
  color: #3b82f6;
}

.filter-tab.active {
  background: #3b82f6;
  border-color: #3b82f6;
  color: white;
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
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn svg {
  width: 1.25rem;
  height: 1.25rem;
}

.loading {
  text-align: center;
  padding: 4rem 0;
}

.spinner {
  width: 3rem;
  height: 3rem;
  border: 4px solid #e5e7eb;
  border-top-color: #3b82f6;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 1rem;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-state {
  text-align: center;
  padding: 4rem 0;
  color: #dc2626;
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
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: all 0.2s;
  position: relative;
}

.media-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.media-type-badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  padding: 0.25rem 0.75rem;
  border-radius: 999px;
  font-size: 0.75rem;
  font-weight: 600;
  color: white;
}

.badge-video { background: #8b5cf6; }
.badge-document { background: #3b82f6; }
.badge-image { background: #10b981; }
.badge-audio { background: #f59e0b; }
.badge-other { background: #6b7280; }

.media-content h3 {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  color: #1a202c;
  padding-right: 4rem;
}

.description {
  color: #6b7280;
  margin-bottom: 1rem;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.media-meta {
  display: flex;
  gap: 0.5rem;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 1rem;
}

.category {
  padding: 0.25rem 0.75rem;
  background: #f3f4f6;
  border-radius: 999px;
  font-size: 0.875rem;
  color: #374151;
}

.status {
  padding: 0.25rem 0.75rem;
  border-radius: 999px;
  font-size: 0.875rem;
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
  margin-bottom: 1rem;
}

.media-actions {
  display: flex;
  gap: 0.5rem;
  justify-content: flex-end;
}

.btn-icon {
  padding: 0.5rem;
  background: #f3f4f6;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-icon:hover {
  background: #e5e7eb;
}

.btn-icon svg {
  width: 1.25rem;
  height: 1.25rem;
  color: #374151;
}

.btn-delete:hover {
  background: #fee2e2;
}

.btn-delete:hover svg {
  color: #dc2626;
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
}

.empty-state svg {
  width: 5rem;
  height: 5rem;
  color: #d1d5db;
  margin: 0 auto 1rem;
}

.empty-state h3 {
  font-size: 1.5rem;
  font-weight: bold;
  color: #1a202c;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #6b7280;
  margin-bottom: 2rem;
}
</style>
