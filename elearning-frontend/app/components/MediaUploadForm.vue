<template>
  <div class="media-upload-form">
    <div class="form-container">
      <h2 class="form-title">อัปโหลดสื่อการเรียน</h2>
      
      <form @submit.prevent="handleSubmit">
        <!-- Media Type Selection -->
        <div class="form-group">
          <label for="media_type" class="form-label">ประเภทสื่อ *</label>
          <select 
            id="media_type" 
            v-model="formData.media_type" 
            required 
            class="form-select"
          >
            <option value="">-- เลือกประเภทสื่อ --</option>
            <option value="video">วิดีโอ</option>
            <option value="document">เอกสาร</option>
            <option value="image">รูปภาพ</option>
            <option value="audio">เสียง</option>
            <option value="other">อื่นๆ</option>
          </select>
        </div>

        <!-- Title -->
        <div class="form-group">
          <label for="title" class="form-label">ชื่อเรื่อง *</label>
          <input 
            id="title"
            v-model="formData.title" 
            type="text" 
            required 
            placeholder="กรอกชื่อเรื่อง"
            class="form-input"
          />
        </div>

        <!-- Description -->
        <div class="form-group">
          <label for="description" class="form-label">คำอธิบาย</label>
          <textarea 
            id="description"
            v-model="formData.description" 
            rows="4" 
            placeholder="กรอกคำอธิบายเกี่ยวกับสื่อนี้"
            class="form-textarea"
          ></textarea>
        </div>

        <!-- Category -->
        <div class="form-group">
          <label for="category" class="form-label">หมวดหมู่</label>
          <select 
            id="category"
            v-model="formData.category" 
            class="form-select"
          >
            <option value="">-- เลือกวิชา --</option>
            <option value="ภาษาไทย">ภาษาไทย</option>
            <option value="คณิตศาสตร์">คณิตศาสตร์</option>
            <option value="ภาษาอังกฤษ">ภาษาอังกฤษ</option>
            <option value="วิทยาศาสตร์">วิทยาศาสตร์</option>
            <option value="สังคมศึกษา">สังคมศึกษา</option>
          </select>
        </div>

        <!-- File Upload -->
        <div class="form-group">
          <label for="file" class="form-label">ไฟล์สื่อ *</label>
          <div class="file-upload-container">
            <input 
              id="file"
              type="file" 
              @change="handleFileChange" 
              required 
              class="file-input"
              ref="fileInput"
            />
            <div v-if="selectedFileName" class="selected-file">
              <svg class="file-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <span>{{ selectedFileName }}</span>
              <button type="button" @click="clearFile" class="clear-file-btn">
                ✕
              </button>
            </div>
          </div>
        </div>

        <!-- Upload Progress -->
        <div v-if="isUploading" class="upload-progress">
          <div class="progress-header">
            <span class="progress-text">กำลังอัปโหลด...</span>
            <span class="progress-percentage">{{ uploadProgress }}%</span>
          </div>
          <div class="progress-bar-container">
            <div class="progress-bar" :style="{ width: uploadProgress + '%' }"></div>
          </div>
          <div class="progress-info">
            อัปโหลดแล้ว {{ formatFileSize(uploadedBytes) }} / {{ formatFileSize(totalBytes) }}
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="error-message">
          <div class="error-title">❌ เกิดข้อผิดพลาด</div>
          <div class="error-text">{{ errorMessage }}</div>
          <div v-if="errorDetails" class="error-details">
            <details>
              <summary>ข้อมูลเพิ่มเติม</summary>
              <pre>{{ errorDetails }}</pre>
            </details>
          </div>
        </div>

        <!-- Success Message -->
        <div v-if="successMessage" class="success-message">
          {{ successMessage }}
        </div>

        <!-- Action Buttons -->
        <div class="form-actions">
          <button 
            type="button" 
            @click="handleSubmit('draft')" 
            :disabled="isLoading"
            class="btn btn-secondary"
          >
            <span v-if="isLoading && draftMode">กำลังบันทึก...</span>
            <span v-else>บันทึกแบบร่าง</span>
          </button>
          
          <button 
            type="submit" 
            @click="handleSubmit('published')"
            :disabled="isLoading"
            class="btn btn-primary"
          >
            <span v-if="isLoading && !draftMode">กำลังเผยแพร่...</span>
            <span v-else>เผยแพร่</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const { uploadMediaWithProgress } = useMedia()

const formData = ref({
  title: '',
  description: '',
  media_type: '',
  category: '',
  status: 'draft'
})

const selectedFile = ref<File | null>(null)
const selectedFileName = ref('')
const fileInput = ref<HTMLInputElement | null>(null)
const isLoading = ref(false)
const isUploading = ref(false)
const uploadProgress = ref(0)
const uploadedBytes = ref(0)
const totalBytes = ref(0)
const errorMessage = ref('')
const errorDetails = ref('')
const successMessage = ref('')
const draftMode = ref(false)

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    selectedFile.value = target.files[0]
    selectedFileName.value = target.files[0].name
    totalBytes.value = target.files[0].size
  }
}

const clearFile = () => {
  selectedFile.value = null
  selectedFileName.value = ''
  uploadProgress.value = 0
  uploadedBytes.value = 0
  totalBytes.value = 0
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const handleSubmit = async (status: string = 'published') => {
  errorMessage.value = ''
  errorDetails.value = ''
  successMessage.value = ''
  draftMode.value = status === 'draft'

  if (!selectedFile.value) {
    errorMessage.value = 'กรุณาเลือกไฟล์'
    return
  }

  if (!formData.value.title || !formData.value.media_type) {
    errorMessage.value = 'กรุณากรอกข้อมูลที่จำเป็น'
    return
  }

  try {
    isLoading.value = true
    isUploading.value = true
    uploadProgress.value = 0
    uploadedBytes.value = 0

    const data = new FormData()
    data.append('title', formData.value.title)
    data.append('description', formData.value.description)
    data.append('media_type', formData.value.media_type)
    data.append('category', formData.value.category)
    data.append('status', status)
    data.append('file', selectedFile.value)

    const response = await uploadMediaWithProgress(data, (progress, loaded, total) => {
      uploadProgress.value = progress
      uploadedBytes.value = loaded
      totalBytes.value = total
    })

    if (response.success) {
      successMessage.value = status === 'draft' 
        ? 'บันทึกแบบร่างสำเร็จ!' 
        : 'เผยแพร่สำเร็จ! ' + (formData.value.media_type === 'video' ? '(ระบบกำลังประมวลผลวิดีโอในเบื้องหลัง)' : '')
      
      // Reset form
      formData.value = {
        title: '',
        description: '',
        media_type: '',
        category: '',
        status: 'draft'
      }
      clearFile()

      // Redirect immediately without waiting for transcoding
      setTimeout(() => {
        navigateTo('/teacher/media')
      }, 1500)
    }
  } catch (error: any) {
    console.error('Upload error:', error)
    
    let errorMsg = 'เกิดข้อผิดพลาดในการอัปโหลด'
    let details = ''
    
    if (error.data) {
      errorMsg = error.data.message || errorMsg
      
      if (error.data.errors) {
        const errors = Object.values(error.data.errors).flat()
        errorMsg += '\n\nรายละเอียด:\n' + errors.join('\n')
      }
      
      if (error.data.debug || error.data.error_type) {
        details = JSON.stringify({
          error_type: error.data.error_type,
          debug: error.data.debug
        }, null, 2)
      }
    } else if (error.message) {
      errorMsg = error.message
    }
    
    errorMessage.value = errorMsg
    errorDetails.value = details
  } finally {
    isLoading.value = false
    isUploading.value = false
  }
}
</script>

<style scoped>
.media-upload-form {
  max-width: 800px;
  margin: 2rem auto;
  padding: 0 1rem;
}

.form-container {
  background: white;
  border-radius: 12px;
  padding: 2rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.form-title {
  font-size: 1.75rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  color: #1a202c;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #374151;
}

.form-input,
.form-select,
.form-textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.2s;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.file-upload-container {
  position: relative;
}

.file-input {
  width: 100%;
  padding: 0.75rem;
  border: 2px dashed #d1d5db;
  border-radius: 8px;
  cursor: pointer;
  transition: border-color 0.2s;
}

.file-input:hover {
  border-color: #3b82f6;
}

.selected-file {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-top: 0.5rem;
  padding: 0.75rem;
  background: #f3f4f6;
  border-radius: 8px;
}

.file-icon {
  width: 1.5rem;
  height: 1.5rem;
  color: #3b82f6;
}

.clear-file-btn {
  margin-left: auto;
  padding: 0.25rem 0.5rem;
  background: #ef4444;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.2s;
}

.clear-file-btn:hover {
  background: #dc2626;
}

.upload-progress {
  padding: 1.5rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 12px;
  margin-bottom: 1.5rem;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.progress-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.75rem;
  color: white;
}

.progress-text {
  font-weight: 600;
  font-size: 1.1rem;
}

.progress-percentage {
  font-weight: 700;
  font-size: 1.5rem;
}

.progress-bar-container {
  width: 100%;
  height: 8px;
  background: rgba(255, 255, 255, 0.3);
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-bar {
  height: 100%;
  background: linear-gradient(90deg, #ffffff, #f0f0f0);
  border-radius: 10px;
  transition: width 0.3s ease;
  box-shadow: 0 2px 8px rgba(255, 255, 255, 0.5);
}

.progress-info {
  color: rgba(255, 255, 255, 0.9);
  font-size: 0.875rem;
  text-align: center;
  font-weight: 500;
}

.error-message {
  padding: 1rem;
  background: #fef2f2;
  border: 2px solid #fecaca;
  border-radius: 8px;
  margin-bottom: 1rem;
}

.error-title {
  font-weight: 700;
  font-size: 1.1rem;
  color: #dc2626;
  margin-bottom: 0.5rem;
}

.error-text {
  color: #991b1b;
  white-space: pre-wrap;
  line-height: 1.6;
}

.error-details {
  margin-top: 0.75rem;
  padding-top: 0.75rem;
  border-top: 1px solid #fecaca;
}

.error-details details {
  cursor: pointer;
}

.error-details summary {
  color: #dc2626;
  font-weight: 600;
  font-size: 0.875rem;
  padding: 0.5rem;
  background: #fee2e2;
  border-radius: 4px;
  user-select: none;
}

.error-details summary:hover {
  background: #fecaca;
}

.error-details pre {
  margin-top: 0.5rem;
  padding: 0.75rem;
  background: #fff;
  border: 1px solid #fecaca;
  border-radius: 4px;
  font-size: 0.75rem;
  color: #991b1b;
  overflow-x: auto;
  max-height: 200px;
  overflow-y: auto;
}

.success-message {
  padding: 0.75rem;
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
  border-radius: 8px;
  color: #16a34a;
  margin-bottom: 1rem;
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
  margin-top: 2rem;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.2s;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #2563eb;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
  background: #6b7280;
  color: white;
}

.btn-secondary:hover:not(:disabled) {
  background: #4b5563;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}
</style>
