<template>
  <div class="mb-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">
          {{ title }}
        </h2>
        <p v-if="subtitle" class="text-gray-600 mt-1">{{ subtitle }}</p>
      </div>
      <NuxtLink
        v-if="showViewAll"
        to="/courses"
        class="text-[#4A9FDB] hover:text-[#003B7A] font-semibold flex items-center transition"
      >
        ดูทั้งหมด
        <svg class="h-5 w-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </NuxtLink>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="i in 3"
        :key="i"
        class="bg-white rounded-xl shadow-lg overflow-hidden animate-pulse"
      >
        <div class="h-48 bg-gray-300"></div>
        <div class="p-5 space-y-3">
          <div class="h-4 bg-gray-300 rounded w-3/4"></div>
          <div class="h-4 bg-gray-300 rounded"></div>
          <div class="h-4 bg-gray-300 rounded w-5/6"></div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-else-if="courses.length === 0"
      class="bg-white rounded-xl shadow-lg p-12 text-center border-t-4 border-gray-300"
    >
      <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <p class="text-gray-600">ไม่พบคอร์สเรียนในหมวดนี้</p>
    </div>

    <!-- Courses Grid -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <CourseCard
        v-for="course in courses"
        :key="course.id"
        :course="course"
        @action="handleCourseAction"
      />
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
  title: string
  subtitle?: string
  courses: Course[]
  loading?: boolean
  showViewAll?: boolean
}>()

const emit = defineEmits<{
  courseAction: [courseId: string]
}>()

const handleCourseAction = (courseId: string) => {
  emit('courseAction', courseId)
}
</script>
