<template>
  <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 border-t-4 border-[#4A9FDB]">
    <!-- Course Image -->
    <div class="h-48 bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] relative">
      <img
        v-if="course.image"
        :src="course.image"
        :alt="course.title"
        class="w-full h-full object-cover"
      />
      <div v-else class="flex items-center justify-center h-full">
        <svg class="h-20 w-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
      </div>
      <!-- Category Badge -->
      <div class="absolute top-3 right-3">
        <span class="bg-white text-[#003B7A] px-3 py-1 rounded-full text-xs font-semibold shadow-md">
          {{ course.category }}
        </span>
      </div>
    </div>

    <!-- Course Info -->
    <div class="p-5">
      <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ course.title }}</h3>
      <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ course.description }}</p>

      <!-- Course Meta -->
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center text-sm text-gray-500">
          <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          <span>{{ course.students }} คน</span>
        </div>
        <div class="flex items-center text-sm text-gray-500">
          <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span>{{ course.duration }}</span>
        </div>
      </div>

      <!-- Rating -->
      <div class="flex items-center mb-4">
        <div class="flex text-yellow-400">
          <svg
            v-for="star in 5"
            :key="star"
            :class="star <= course.rating ? 'text-yellow-400' : 'text-gray-300'"
            class="h-5 w-5"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
          </svg>
        </div>
        <span class="ml-2 text-sm text-gray-600">({{ course.rating }})</span>
      </div>

      <!-- Progress Bar (if enrolled) -->
      <div v-if="course.progress !== undefined" class="mb-4">
        <div class="flex justify-between text-xs text-gray-600 mb-1">
          <span>ความคืบหน้า</span>
          <span>{{ course.progress }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
          <div
            class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] h-2 rounded-full transition-all duration-300"
            :style="{ width: `${course.progress}%` }"
          ></div>
        </div>
      </div>

      <!-- Action Button -->
      <button
        @click="onAction"
        class="w-full bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#00305e] hover:to-[#3c8ac4] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200"
      >
        {{ course.progress !== undefined ? 'เรียนต่อ' : 'เริ่มเรียน' }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Course {
  id: string
  title: string
  description: string
  category: string
  image?: string
  students: number
  duration: string
  rating: number
  progress?: number
}

const props = defineProps<{
  course: Course
}>()

const emit = defineEmits<{
  action: [courseId: string]
}>()

const onAction = () => {
  emit('action', props.course.id)
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
