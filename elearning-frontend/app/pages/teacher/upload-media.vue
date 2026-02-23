<template>
  <div class="upload-media-page">
    <div class="container">
      <div class="page-header">
        <button @click="goBack" class="back-btn">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          กลับ
        </button>
      </div>

      <MediaUploadForm />
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: 'auth'
})

const router = useRouter()
const { user } = useAuth()

// Debug: แสดงข้อมูล user
onMounted(() => {
  console.log('Current user:', user.value)
  console.log('User role:', user.value?.role)
  
  if (!user.value) {
    console.error('No user found!')
  } else if (user.value.role !== 'teacher' && user.value.role !== 'admin') {
    console.error('User is not teacher or admin:', user.value.role)
  }
})

const goBack = () => {
  router.back()
}
</script>

<style scoped>
.upload-media-page {
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
  margin-bottom: 2rem;
}

.page-header h1 {
  font-size: 2rem;
  font-weight: bold;
  color: #1a202c;
  margin-top: 1rem;
}

.back-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: white;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  color: #374151;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.back-btn:hover {
  background: #f3f4f6;
  border-color: #9ca3af;
}

.back-btn svg {
  width: 1.25rem;
  height: 1.25rem;
}
</style>
