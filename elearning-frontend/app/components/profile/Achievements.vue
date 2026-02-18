<template>
  <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
    <!-- Header with gradient accent -->
    <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-gradient-to-r from-yellow-500 to-orange-500">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-md">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
          ความสำเร็จ
        </h2>
      </div>
      <span class="px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-shadow duration-200">
        {{ totalPoints }} คะแนน
      </span>
    </div>

    <!-- Points Summary -->
    <div class="grid grid-cols-3 gap-4 mb-6">
      <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 text-center border border-yellow-200">
        <div class="text-3xl mb-1">🏆</div>
        <p class="text-2xl font-bold text-yellow-700">{{ badges }}</p>
        <p class="text-xs text-gray-600">เหรียญรางวัล</p>
      </div>
      <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center border border-blue-200">
        <div class="text-3xl mb-1">📜</div>
        <p class="text-2xl font-bold text-blue-700">{{ certificates }}</p>
        <p class="text-xs text-gray-600">ใบรับรอง</p>
      </div>
      <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center border border-purple-200">
        <div class="text-3xl mb-1">⭐</div>
        <p class="text-2xl font-bold text-purple-700">{{ totalPoints }}</p>
        <p class="text-xs text-gray-600">คะแนนสะสม</p>
      </div>
    </div>

    <!-- Badges Section -->
    <div class="mb-6">
      <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <div class="w-1 h-6 bg-gradient-to-b from-yellow-500 to-orange-500 rounded-full"></div>
        เหรียญรางวัล
      </h3>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        <div
          v-for="badge in badgesList"
          :key="badge.id"
          :class="[
            'relative bg-gradient-to-br rounded-xl p-4 text-center cursor-pointer transition-all duration-300 border-2',
            badge.earned
              ? 'from-yellow-50 via-orange-50 to-yellow-50 border-yellow-400 hover:scale-110 hover:shadow-xl hover:border-orange-400 shadow-md'
              : 'from-gray-50 to-gray-100 border-gray-200 opacity-60 hover:opacity-70'
          ]"
          :title="badge.description"
        >
          <!-- Glow effect for earned badges -->
          <div v-if="badge.earned" class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 to-orange-400/20 rounded-xl blur-sm"></div>
          
          <div class="relative">
            <div class="text-4xl mb-2 transform transition-transform duration-200 hover:scale-110">{{ badge.icon }}</div>
            <p class="text-sm font-bold text-gray-800">{{ badge.name }}</p>
            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ badge.description }}</p>
          </div>
          
          <!-- Earned Badge -->
          <div v-if="badge.earned" class="absolute -top-2 -right-2 bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-full p-1.5 shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          
          <!-- Locked Badge -->
          <div v-else class="absolute -top-2 -right-2 bg-gray-400 text-white rounded-full p-1.5 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Certificates Section -->
    <div>
      <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
        ใบรับรอง
      </h3>
      <div class="space-y-3">
        <div
          v-for="cert in certificatesList"
          :key="cert.id"
          class="bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 rounded-xl p-4 border-2 border-blue-200 hover:border-indigo-300 hover:shadow-xl transition-all duration-300 group"
        >
          <div class="flex items-start justify-between">
            <div class="flex items-start gap-3 flex-1">
              <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-xl p-3 shadow-md group-hover:scale-110 transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-gray-800 mb-1 group-hover:text-[#003B7A] transition-colors">
                  {{ cert.courseName }}
                </h4>
                <p class="text-xs text-gray-600 mb-2 flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                  {{ cert.issuer }}
                </p>
                <div class="flex items-center gap-3 text-xs">
                  <div class="flex items-center gap-1 bg-white px-2 py-1 rounded-lg shadow-sm">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-semibold text-gray-700">{{ formatDate(cert.issuedDate) }}</span>
                  </div>
                  <div class="flex items-center gap-1 bg-white px-2 py-1 rounded-lg shadow-sm">
                    <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                    <span class="font-mono text-xs font-semibold text-gray-700">{{ cert.certificateId }}</span>
                  </div>
                </div>
              </div>
            </div>
            <button
              class="px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-bold rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg hover:scale-105"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
              </svg>
              ดาวน์โหลด
            </button>
          </div>
        </div>
      </div>

      <!-- No Certificates Message -->
      <div v-if="certificatesList.length === 0" class="text-center py-8 text-gray-500">
        <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-sm">ยังไม่มีใบรับรอง</p>
        <p class="text-xs mt-1">เรียนจบคอร์สเพื่อรับใบรับรอง</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Badge {
  id: number
  name: string
  description: string
  icon: string
  earned: boolean
}

interface Certificate {
  id: number
  courseName: string
  issuer: string
  issuedDate: string
  certificateId: string
}

const badges = ref(6)
const certificates = ref(3)
const totalPoints = ref(2450)

const badgesList = ref<Badge[]>([
  {
    id: 1,
    name: 'เริ่มต้น',
    description: 'ลงทะเบียนคอร์สแรก',
    icon: '🎯',
    earned: true
  },
  {
    id: 2,
    name: 'นักเรียนขยัน',
    description: 'เรียนติดต่อกัน 7 วัน',
    icon: '🔥',
    earned: true
  },
  {
    id: 3,
    name: 'ผู้สำเร็จการศึกษา',
    description: 'จบคอร์สแรก',
    icon: '🎓',
    earned: true
  },
  {
    id: 4,
    name: 'ผู้เชี่ยวชาญ',
    description: 'จบ 5 คอร์ส',
    icon: '⭐',
    earned: true
  },
  {
    id: 5,
    name: 'ผู้ทุ่มเท',
    description: 'เรียน 100 ชั่วโมง',
    icon: '💪',
    earned: true
  },
  {
    id: 6,
    name: 'คะแนนสูง',
    description: 'ได้คะแนน 90% ขึ้นไป',
    icon: '🌟',
    earned: true
  },
  {
    id: 7,
    name: 'ปรมาจารย์',
    description: 'จบ 10 คอร์ส',
    icon: '👑',
    earned: false
  },
  {
    id: 8,
    name: 'ผู้ช่วยเหลือ',
    description: 'ตอบคำถามใน Forum 50 ครั้ง',
    icon: '🤝',
    earned: false
  }
])

const certificatesList = ref<Certificate[]>([
  {
    id: 1,
    courseName: 'Web Development with Vue.js',
    issuer: 'Udom Institute of Technology',
    issuedDate: '2026-01-15',
    certificateId: 'CERT-2026-001'
  },
  {
    id: 2,
    courseName: 'Modern JavaScript ES6+',
    issuer: 'Udom Institute of Technology',
    issuedDate: '2026-02-01',
    certificateId: 'CERT-2026-002'
  },
  {
    id: 3,
    courseName: 'Database Design and SQL',
    issuer: 'Udom Institute of Technology',
    issuedDate: '2026-02-10',
    certificateId: 'CERT-2026-003'
  }
])

const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('th-TH', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>
