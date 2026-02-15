<template>
  <div class="min-h-screen bg-gradient-to-br from-[#E8F4F8] to-[#D6EAF8]">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg border-b-4 border-[#003B7A]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">
              แดชบอร์ดผู้เรียน
            </h1>
          </div>
          <div class="flex items-center space-x-4">
            <div class="text-[#003B7A]">
              <span class="font-semibold">สวัสดี, </span>
              <span>{{ user?.name || user?.email || 'ผู้ใช้' }}</span>
            </div>
            <button
              @click="handleLogout"
              class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150"
              :disabled="loggingOut"
            >
              {{ loggingOut ? 'กำลังออกจากระบบ...' : 'ออกจากระบบ' }}
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Welcome Section -->
      <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#003B7A] mb-2">
          ยินดีต้อนรับกลับมา! {{ user?.name || 'ผู้เรียน' }}
        </h2>
        <p class="text-gray-600">ค้นพบคอร์สเรียนใหม่ๆ และเรียนต่อจากที่ค้างไว้</p>
      </div>

      <!-- Search Bar Section -->
      <div class="mb-8">
        <SearchBar
          @search="handleSearch"
          @filter-categories="handleFilterCategories"
        />
      </div>

      <!-- Search Results (if searching) -->
      <CourseSection
        v-if="showSearchResults"
        title="ผลการค้นหา"
        :subtitle="`พบ ${filteredCourses.length} คอร์ส`"
        :courses="filteredCourses"
        :loading="loading"
        :show-view-all="false"
        @course-action="handleCourseAction"
      />

      <!-- Recent Courses Section (only show when not searching) -->
      <CourseSection
        v-if="!showSearchResults && recentCourses.length > 0"
        title="เรียนต่อ"
        subtitle="คอร์สที่คุณเคยเข้าเรียน"
        :courses="recentCourses"
        :loading="loading"
        :show-view-all="true"
        @course-action="handleCourseAction"
      />

      <!-- Recommended Courses Section (only show when not searching) -->
      <CourseSection
        v-if="!showSearchResults"
        title="แนะนำสำหรับคุณ"
        subtitle="คอร์สที่เหมาะกับความสนใจของคุณ"
        :courses="recommendedCourses"
        :loading="loading"
        :show-view-all="true"
        @course-action="handleCourseAction"
      />

      <!-- Popular Courses Section (only show when not searching) -->
      <CourseSection
        v-if="!showSearchResults"
        title="ยอดนิยม"
        subtitle="คอร์สที่ได้รับความนิยมสูงสุด"
        :courses="popularCourses"
        :loading="loading"
        :show-view-all="true"
        @course-action="handleCourseAction"
      />

      <!-- Stats Overview -->
      <div v-if="!showSearchResults" class="mt-12">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent mb-6">
          สถิติการเรียน
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Enrolled Courses -->
          <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300 border-t-4 border-[#003B7A]">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm mb-1">คอร์สที่ลงทะเบียน</p>
                <p class="text-3xl font-bold text-[#003B7A]">{{ enrolledCount }}</p>
              </div>
              <div class="bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] rounded-lg p-3">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
            </div>
          </div>

          <!-- Completed Courses -->
          <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300 border-t-4 border-[#4A9FDB]">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm mb-1">คอร์สที่จบแล้ว</p>
                <p class="text-3xl font-bold text-[#4A9FDB]">{{ completedCount }}</p>
              </div>
              <div class="bg-gradient-to-br from-[#4A9FDB] to-[#87CEEB] rounded-lg p-3">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
          </div>

          <!-- Learning Hours -->
          <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300 border-t-4 border-[#87CEEB]">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm mb-1">ชั่วโมงการเรียน</p>
                <p class="text-3xl font-bold text-[#87CEEB]">{{ learningHours }}</p>
              </div>
              <div class="bg-gradient-to-br from-[#87CEEB] to-[#4A9FDB] rounded-lg p-3">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
const { user, logout } = useAuth()
const {
  popularCourses,
  recommendedCourses,
  recentCourses,
  filteredCourses,
  loading,
  fetchCourses,
  searchCourses,
  filterByCategories,
  startCourse
} = useCourses()

const loggingOut = ref(false)
const showSearchResults = ref(false)

// Stats (mock data - will be replaced with real data)
const enrolledCount = computed(() => recentCourses.value.length)
const completedCount = computed(() => {
  return recentCourses.value.filter(c => c.progress === 100).length
})
const learningHours = computed(() => {
  // Calculate based on enrolled courses
  return enrolledCount.value * 8 // Mock: 8 hours per course
})

// Define page meta with auth middleware
definePageMeta({
  middleware: 'auth'
})

// Fetch courses on mount
onMounted(async () => {
  await fetchCourses()
})

// Handle search
const handleSearch = (query: string) => {
  if (query.trim()) {
    searchCourses(query)
    showSearchResults.value = true
  } else {
    showSearchResults.value = false
  }
}

// Handle category filter
const handleFilterCategories = (categories: string[]) => {
  if (categories.length > 0) {
    filterByCategories(categories)
    showSearchResults.value = true
  } else {
    showSearchResults.value = false
  }
}

// Handle course action
const handleCourseAction = (courseId: string) => {
  startCourse(courseId)
  // Navigate to course detail page
  navigateTo(`/courses/${courseId}`)
}

// Handle logout
const handleLogout = async () => {
  loggingOut.value = true
  try {
    await logout()
  } catch (error) {
    console.error('Logout error:', error)
  } finally {
    loggingOut.value = false
  }
}
</script>

<style scoped>
/* Additional styles if needed */
</style>
