<template>
  <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
    <!-- Header with gradient accent -->
    <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-gradient-to-r from-[#003B7A] to-[#4A9FDB]">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] rounded-xl flex items-center justify-center shadow-md">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">
          ความคืบหน้าการเรียน
        </h2>
      </div>
      <span class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-shadow duration-200">
        {{ completedCourses }}/{{ totalCourses }} คอร์ส
      </span>
    </div>

    <!-- Overall Progress -->
    <div class="mb-6">
      <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-700">ความคืบหน้าโดยรวม</span>
        <span class="text-sm font-bold text-[#003B7A]">{{ overallProgress }}%</span>
      </div>
      <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
        <div
          class="h-full bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] transition-all duration-500 rounded-full flex items-center justify-end pr-2"
          :style="{ width: `${overallProgress}%` }"
        >
          <span v-if="overallProgress > 15" class="text-xs text-white font-bold">{{ overallProgress }}%</span>
        </div>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
      <!-- Enrolled Courses -->
      <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
        <div class="flex flex-col items-center text-center">
          <div class="bg-blue-500 text-white rounded-full p-3 mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          <p class="text-2xl font-bold text-blue-700">{{ enrolledCourses }}</p>
          <p class="text-xs text-gray-600">คอร์สที่ลงทะเบียน</p>
        </div>
      </div>

      <!-- Completed Courses -->
      <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
        <div class="flex flex-col items-center text-center">
          <div class="bg-green-500 text-white rounded-full p-3 mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <p class="text-2xl font-bold text-green-700">{{ completedCourses }}</p>
          <p class="text-xs text-gray-600">คอร์สที่เสร็จสิ้น</p>
        </div>
      </div>

      <!-- Learning Hours -->
      <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
        <div class="flex flex-col items-center text-center">
          <div class="bg-purple-500 text-white rounded-full p-3 mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <p class="text-2xl font-bold text-purple-700">{{ learningHours }}</p>
          <p class="text-xs text-gray-600">ชั่วโมงเรียน</p>
        </div>
      </div>

      <!-- GPA -->
      <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200">
        <div class="flex flex-col items-center text-center">
          <div class="bg-orange-500 text-white rounded-full p-3 mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
            </svg>
          </div>
          <p class="text-2xl font-bold text-orange-700">{{ gpa }}</p>
          <p class="text-xs text-gray-600">เกรดเฉลี่ย</p>
        </div>
      </div>
    </div>

    <!-- Course List -->
    <div>
      <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <div class="w-1 h-6 bg-gradient-to-b from-[#003B7A] to-[#4A9FDB] rounded-full"></div>
        คอร์สของฉัน
      </h3>
      <div class="space-y-3">
        <div
          v-for="course in courses"
          :key="course.id"
          class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 hover:shadow-lg hover:scale-[1.01] transition-all duration-200 border border-gray-200 hover:border-[#4A9FDB] group"
        >
          <div class="flex items-start justify-between mb-3">
            <div class="flex-1">
              <h4 class="font-bold text-gray-800 mb-1 group-hover:text-[#003B7A] transition-colors">
                {{ course.name }}
              </h4>
              <p class="text-xs text-gray-500 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                {{ course.instructor }}
              </p>
            </div>
            <span
              :class="[
                'px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm',
                course.status === 'completed'
                  ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white'
                  : course.status === 'in-progress'
                  ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white'
                  : 'bg-gray-200 text-gray-700'
              ]"
            >
              {{ getStatusText(course.status) }}
            </span>
          </div>
          
          <div class="flex items-center gap-2 mb-3">
            <div class="flex-1 bg-gray-200 rounded-full h-2.5 overflow-hidden shadow-inner">
              <div
                class="h-full bg-gradient-to-r from-[#003B7A] via-[#4A9FDB] to-[#003B7A] transition-all duration-500 shadow-sm"
                :style="{ width: `${course.progress}%` }"
              ></div>
            </div>
            <span class="text-xs font-bold text-[#003B7A] min-w-[45px] text-right">
              {{ course.progress }}%
            </span>
          </div>

          <div class="flex items-center gap-4 text-xs text-gray-500">
            <div class="flex items-center gap-1.5 bg-blue-50 px-2 py-1 rounded-lg">
              <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
              <span class="font-semibold text-gray-700">{{ course.lessons }} บทเรียน</span>
            </div>
            <div class="flex items-center gap-1.5 bg-purple-50 px-2 py-1 rounded-lg">
              <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="font-semibold text-gray-700">{{ course.duration }} ชม.</span>
            </div>
          </div>
        </div>
      </div>

      <!-- View All Button -->
      <button
        class="w-full mt-4 py-3.5 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-[#003B7A] hover:to-[#4A9FDB] text-gray-700 hover:text-white font-bold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl flex items-center justify-center gap-2 group"
      >
        <span>ดูคอร์สทั้งหมด</span>
        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Course {
  id: number
  name: string
  instructor: string
  progress: number
  status: 'not-started' | 'in-progress' | 'completed'
  lessons: number
  duration: number
}

const enrolledCourses = ref(8)
const completedCourses = ref(5)
const totalCourses = ref(8)
const learningHours = ref(156)
const gpa = ref(3.75)

const overallProgress = computed(() => {
  return Math.round((completedCourses.value / totalCourses.value) * 100)
})

const courses = ref<Course[]>([
  {
    id: 1,
    name: 'Web Development with Vue.js',
    instructor: 'อ. สมชาย ใจดี',
    progress: 100,
    status: 'completed',
    lessons: 24,
    duration: 18
  },
  {
    id: 2,
    name: 'Database Design and SQL',
    instructor: 'อ. สมหญิง รักเรียน',
    progress: 75,
    status: 'in-progress',
    lessons: 20,
    duration: 15
  },
  {
    id: 3,
    name: 'Modern JavaScript ES6+',
    instructor: 'อ. วิชัย เก่งโค้ด',
    progress: 100,
    status: 'completed',
    lessons: 30,
    duration: 22
  },
  {
    id: 4,
    name: 'UI/UX Design Fundamentals',
    instructor: 'อ. สุดา สวยงาม',
    progress: 45,
    status: 'in-progress',
    lessons: 18,
    duration: 12
  },
  {
    id: 5,
    name: 'Python for Data Science',
    instructor: 'อ. ประยุทธ์ วิเคราะห์',
    progress: 0,
    status: 'not-started',
    lessons: 25,
    duration: 20
  }
])

const getStatusText = (status: string) => {
  const statusMap: Record<string, string> = {
    'completed': 'เสร็จสิ้น',
    'in-progress': 'กำลังเรียน',
    'not-started': 'ยังไม่เริ่ม'
  }
  return statusMap[status] || status
}
</script>
