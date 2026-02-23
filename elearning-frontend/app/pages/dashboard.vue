<template>
  <div v-if="authReady" class="min-h-screen bg-gradient-to-br from-[#E8F4F8] to-[#D6EAF8]">
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
            <!-- Upload Media Button (Teacher & Admin only) -->
            <NuxtLink
              v-if="user?.role === 'teacher' || user?.role === 'admin'"
              to="/teacher/upload-media"
              class="flex items-center space-x-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-200 hover:scale-105"
              title="อัปโหลดสื่อการเรียน"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
              </svg>
              <span>อัปโหลดสื่อ</span>
            </NuxtLink>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Welcome Section -->
      <div class="mb-8">
        <div>
          <h2 class="text-3xl font-bold text-[#003B7A] mb-2">
            ยินดีต้อนรับ <span v-if="user">{{ user.name || user.firstname || user.email || 'ผู้ใช้' }}</span>
          </h2>
        </div>
      </div>

      <!-- Quick Actions Section - Large Cards -->
      <div class="mb-8">
        <h3 class="text-xl font-bold text-[#003B7A] mb-4">เมนูด่วน</h3>
        
        <!-- Admin Quick Actions -->
        <div v-if="user?.role === 'admin'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <NuxtLink
            to="/admin/media"
            class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-purple-50 rounded-xl shadow-lg p-6 border-2 border-transparent hover:border-[#003B7A] transition-all duration-300 hover:scale-105"
          >
            <div class="flex items-start gap-4">
              <div class="bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] rounded-lg p-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-lg text-[#003B7A] mb-1 group-hover:text-blue-700">จัดการสื่อ (Admin)</h4>
                <p class="text-sm text-gray-600">ดูและจัดการสื่อการเรียนทั้งหมด</p>
              </div>
            </div>
          </NuxtLink>

          <NuxtLink
            to="/teacher/upload-media"
            class="group bg-white hover:bg-gradient-to-br hover:from-green-50 hover:to-emerald-50 rounded-xl shadow-lg p-6 border-2 border-transparent hover:border-green-500 transition-all duration-300 hover:scale-105"
          >
            <div class="flex items-start gap-4">
              <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-lg text-green-700 mb-1 group-hover:text-green-800">อัปโหลดสื่อใหม่</h4>
                <p class="text-sm text-gray-600">เพิ่มสื่อการเรียนใหม่เข้าระบบ</p>
              </div>
            </div>
          </NuxtLink>

          <NuxtLink
            to="/teacher/media"
            class="group bg-white hover:bg-gradient-to-br hover:from-amber-50 hover:to-orange-50 rounded-xl shadow-lg p-6 border-2 border-transparent hover:border-amber-500 transition-all duration-300 hover:scale-105"
          >
            <div class="flex items-start gap-4">
              <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg p-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-lg text-amber-700 mb-1 group-hover:text-amber-800">สื่อของฉัน</h4>
                <p class="text-sm text-gray-600">ดูสื่อการเรียนที่คุณอัปโหลด</p>
              </div>
            </div>
          </NuxtLink>
        </div>

        <!-- Teacher Quick Actions -->
        <div v-else-if="user?.role === 'teacher'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <NuxtLink
            to="/teacher/media"
            class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-purple-50 rounded-xl shadow-lg p-6 border-2 border-transparent hover:border-[#003B7A] transition-all duration-300 hover:scale-105"
          >
            <div class="flex items-start gap-4">
              <div class="bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] rounded-lg p-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-lg text-[#003B7A] mb-1 group-hover:text-blue-700">จัดการสื่อของฉัน</h4>
                <p class="text-sm text-gray-600">ดูและจัดการสื่อการเรียนที่คุณอัปโหลด</p>
              </div>
            </div>
          </NuxtLink>

          <NuxtLink
            to="/teacher/upload-media"
            class="group bg-white hover:bg-gradient-to-br hover:from-green-50 hover:to-emerald-50 rounded-xl shadow-lg p-6 border-2 border-transparent hover:border-green-500 transition-all duration-300 hover:scale-105"
          >
            <div class="flex items-start gap-4">
              <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-lg text-green-700 mb-1 group-hover:text-green-800">อัปโหลดสื่อใหม่</h4>
                <p class="text-sm text-gray-600">เพิ่มสื่อการเรียนใหม่เข้าระบบ</p>
              </div>
            </div>
          </NuxtLink>
        </div>

        <!-- Student Quick Actions -->
        <div v-else-if="user?.role === 'student'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <NuxtLink
            to="/student/media"
            class="group bg-white hover:bg-gradient-to-br hover:from-purple-50 hover:to-pink-50 rounded-xl shadow-lg p-6 border-2 border-transparent hover:border-purple-500 transition-all duration-300 hover:scale-105"
          >
            <div class="flex items-start gap-4">
              <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-lg text-purple-700 mb-1 group-hover:text-purple-800">สื่อการเรียน</h4>
                <p class="text-sm text-gray-600">ดูและเรียนรู้จากสื่อการเรียนทั้งหมด</p>
              </div>
            </div>
          </NuxtLink>

          <NuxtLink
            to="/profile"
            class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-cyan-50 rounded-xl shadow-lg p-6 border-2 border-transparent hover:border-blue-500 transition-all duration-300 hover:scale-105"
          >
            <div class="flex items-start gap-4">
              <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg p-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-lg text-blue-700 mb-1 group-hover:text-blue-800">โปรไฟล์ของฉัน</h4>
                <p class="text-sm text-gray-600">ดูและแก้ไขข้อมูลส่วนตัว</p>
              </div>
            </div>
          </NuxtLink>
        </div>
      </div>

      <!-- Search Bar Section -->
      <div class="mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input 
              v-model="searchQuery" 
              type="text" 
              placeholder="ค้นหาสื่อการเรียน บทเรียน หรือเนื้อหา..." 
              class="w-full pl-14 pr-12 py-4 text-lg border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#003B7A] transition-colors"
              @input="handleSearchInput"
            />
            <button 
              v-if="searchQuery" 
              @click="clearSearch" 
              class="absolute right-4 top-1/2 transform -translate-y-1/2 p-2 hover:bg-gray-100 rounded-lg transition-colors"
            >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Search Results for Media (if searching) -->
      <div v-if="showSearchResults && searchQuery" class="mb-8">
        <div class="mb-4">
          <h3 class="text-2xl font-bold text-[#003B7A]">ผลการค้นหาสื่อ</h3>
          <p class="text-gray-600">พบ {{ filteredMedia.length }} รายการ</p>
        </div>
        
        <!-- Loading State -->
        <div v-if="mediaLoading" class="flex justify-center py-12">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-[#003B7A] border-t-transparent"></div>
        </div>

        <!-- Media Grid -->
        <div v-else-if="filteredMedia.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div 
            v-for="media in filteredMedia" 
            :key="media.id" 
            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105"
          >
            <div class="relative cursor-pointer" @click="viewMedia(media.id)">
              <div class="h-48 bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] flex items-center justify-center">
                <svg v-if="media.media_type === 'video'" class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <svg v-else-if="media.media_type === 'document'" class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <svg v-else class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur rounded-full text-xs font-semibold" :class="getMediaTypeColor(media.media_type)">
                {{ getMediaTypeLabel(media.media_type) }}
              </div>
              <div v-if="media.status === 'published'" class="absolute top-3 left-3 px-3 py-1 bg-green-500 text-white rounded-full text-xs font-semibold">
                เผยแพร่แล้ว
              </div>
            </div>
            
            <div class="p-5">
              <div class="cursor-pointer" @click="viewMedia(media.id)">
                <h4 class="text-lg font-bold text-[#003B7A] mb-2 line-clamp-2">{{ media.title }}</h4>
                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ media.description || 'ไม่มีคำอธิบาย' }}</p>
                
                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                  <span v-if="media.category" class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ media.category }}
                  </span>
                  <span>{{ formatFileSize(media.file_size) }}</span>
                </div>
              </div>
              
              <!-- Download Button -->
              <button 
                @click.stop="handleDownload(media.id, media.title)"
                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                ดาวน์โหลด
              </button>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12 bg-white rounded-xl shadow-lg">
          <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="text-xl font-bold text-gray-700 mb-2">ไม่พบสื่อที่ค้นหา</h3>
          <p class="text-gray-500">ลองค้นหาด้วยคำอื่น</p>
        </div>
      </div>

      <!-- Search Results for Courses (if searching) -->
      <!-- ซ่อน Course Section ออก เพื่อแสดงเฉพาะวิดีโอ
      <CourseSection
        v-if="showSearchResults && searchQuery"
        title="ผลการค้นหาคอร์ส"
        :subtitle="`พบ ${filteredCourses.length} คอร์ส`"
        :courses="filteredCourses"
        :loading="loading"
        :show-view-all="false"
        @course-action="handleCourseAction"
      />
      -->

      <!-- Recent Courses Section (only show when not searching) -->
      <!-- ซ่อน Course Section ออก เพื่อแสดงเฉพาะวิดีโอ
      <CourseSection
        v-if="!showSearchResults && recentCourses.length > 0"
        title="เรียนต่อ"
        subtitle="คอร์สที่คุณเคยเข้าเรียน"
        :courses="recentCourses"
        :loading="loading"
        :show-view-all="true"
        @course-action="handleCourseAction"
      />
      -->

      <!-- Recent Media Section (only show when not searching) -->
      <div v-if="!showSearchResults && allMedia.length > 0" class="mb-8">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h3 class="text-2xl font-bold text-[#003B7A]">สื่อการเรียนล่าสุด</h3>
            <p class="text-gray-600">สื่อที่อัปโหลดล่าสุดในระบบ</p>
          </div>
          <NuxtLink 
            to="/teacher/media" 
            class="flex items-center gap-2 text-[#003B7A] hover:text-[#4A9FDB] font-semibold transition-colors"
          >
            ดูทั้งหมด
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </NuxtLink>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div 
            v-for="media in allMedia.slice(0, 6)" 
            :key="media.id" 
            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105"
          >
            <div class="relative cursor-pointer" @click="viewMedia(media.id)">
              <div class="h-48 bg-gradient-to-br from-[#003B7A] to-[#4A9FDB] flex items-center justify-center">
                <svg v-if="media.media_type === 'video'" class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <svg v-else-if="media.media_type === 'document'" class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <svg v-else class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur rounded-full text-xs font-semibold" :class="getMediaTypeColor(media.media_type)">
                {{ getMediaTypeLabel(media.media_type) }}
              </div>
              <div v-if="media.status === 'published'" class="absolute top-3 left-3 px-3 py-1 bg-green-500 text-white rounded-full text-xs font-semibold">
                เผยแพร่แล้ว
              </div>
            </div>
            
            <div class="p-5">
              <div class="cursor-pointer" @click="viewMedia(media.id)">
                <h4 class="text-lg font-bold text-[#003B7A] mb-2 line-clamp-2">{{ media.title }}</h4>
                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ media.description || 'ไม่มีคำอธิบาย' }}</p>
                
                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                  <span v-if="media.category" class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ media.category }}
                  </span>
                  <span>{{ formatFileSize(media.file_size) }}</span>
                </div>
              </div>
              
              <!-- Download Button -->
              <button 
                @click.stop="handleDownload(media.id, media.title)"
                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                ดาวน์โหลด
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Recommended Courses Section (only show when not searching) -->
      <!-- ซ่อน Course Section ออก เพื่อแสดงเฉพาะวิดีโอ
      <CourseSection
        v-if="!showSearchResults"
        title="แนะนำสำหรับคุณ"
        subtitle="คอร์สที่เหมาะกับความสนใจของคุณ"
        :courses="recommendedCourses"
        :loading="loading"
        :show-view-all="true"
        @course-action="handleCourseAction"
      />
      -->

      <!-- Popular Courses Section (only show when not searching) -->
      <!-- ซ่อน Course Section ออก เพื่อแสดงเฉพาะวิดีโอ
      <CourseSection
        v-if="!showSearchResults"
        title="ยอดนิยม"
        subtitle="คอร์สที่ได้รับความนิยมสูงสุด"
        :courses="popularCourses"
        :loading="loading"
        :show-view-all="true"
        @course-action="handleCourseAction"
      />
      -->
    </main>

    <!-- Profile Edit Modal -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="showProfileModal"
          class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
          @click.self="closeProfileModal"
        >
          <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 scale-95 translate-y-4"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 translate-y-4"
          >
            <div v-if="showProfileModal" class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
              <!-- Modal Header -->
              <div class="flex items-stretch bg-gradient-to-r from-[#003B7A] to-[#4A9FDB]">
                <!-- Left: Title -->
                <div class="flex-1 px-8 py-6 flex items-center">
                  <h2 class="text-2xl font-bold text-white">แก้ไขโปรไฟล์</h2>
                </div>
                <!-- Right: Close Button -->
                <div class="px-6 py-6 flex items-center justify-center">
                  <button
                    @click="closeProfileModal"
                    class="bg-red-500 hover:bg-red-600 rounded-lg p-2 transition-all duration-200 hover:scale-110 shadow-lg"
                    title="ปิด"
                  >
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Modal Body -->
              <div class="overflow-y-auto max-h-[calc(90vh-120px)] smooth-scroll bg-gradient-to-br from-[#003B7A] via-[#2563a8] to-[#4A9FDB]">
                <form @submit.prevent="handleUpdateProfile" class="p-8 space-y-6">
                  <!-- Avatar Section -->
                  <div class="flex flex-col items-center space-y-4 pb-6 border-b-2 border-white/20">
                    <div class="relative group">
                      <div class="absolute -inset-2 bg-gradient-to-r from-[#87CEEB] via-white to-[#87CEEB] rounded-full opacity-60 blur-md group-hover:opacity-90 transition duration-300"></div>
                      <div class="relative w-28 h-28 bg-white rounded-full flex items-center justify-center shadow-xl ring-4 ring-white/30">
                        <span class="text-[#003B7A] text-4xl font-bold drop-shadow-lg">
                          {{ getInitials(profileForm.firstname || profileForm.name || profileForm.email) }}
                        </span>
                      </div>
                      <button
                        type="button"
                        class="absolute bottom-0 right-0 bg-white border-4 border-[#4A9FDB] rounded-full p-2.5 hover:scale-110 transition-all duration-200 shadow-lg"
                        title="เปลี่ยนรูปโปรไฟล์"
                      >
                        <svg class="h-5 w-5 text-[#003B7A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="text-center">
                      <p class="text-white text-sm font-semibold">คลิกที่กล้องเพื่อเปลี่ยนรูปโปรไฟล์</p>
                      <p class="text-white/80 text-xs mt-1">รองรับไฟล์ JPG, PNG (สูงสุด 5MB)</p>
                    </div>
                  </div>

                  <!-- Form Fields -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Username -->
                    <div class="group">
                      <label class="block text-sm font-bold text-white mb-2">
                        ชื่อผู้ใช้ <span class="text-yellow-300">*</span>
                      </label>
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#4A9FDB] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                          </svg>
                        </div>
                        <input
                          v-model="profileForm.username"
                          type="text"
                          class="w-full pl-10 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#4A9FDB] transition-all hover:border-gray-300"
                          placeholder="ชื่อผู้ใช้"
                        />
                      </div>
                    </div>

                    <!-- Email -->
                    <div class="group">
                      <label class="block text-sm font-bold text-white mb-2">
                        อีเมล <span class="text-yellow-300">*</span>
                      </label>
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#4A9FDB] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                          </svg>
                        </div>
                        <input
                          v-model="profileForm.email"
                          type="email"
                          class="w-full pl-10 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#4A9FDB] transition-all hover:border-gray-300"
                          placeholder="อีเมล"
                        />
                      </div>
                    </div>

                    <!-- First Name -->
                    <div>
                      <label class="block text-sm font-bold text-white mb-2">
                        ชื่อจริง <span class="text-yellow-300">*</span>
                      </label>
                      <input
                        v-model="profileForm.firstname"
                        type="text"
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#4A9FDB] transition-all hover:border-gray-300"
                        placeholder="ชื่อจริง"
                      />
                    </div>

                    <!-- Last Name -->
                    <div>
                      <label class="block text-sm font-bold text-white mb-2">
                        นามสกุล <span class="text-yellow-300">*</span>
                      </label>
                      <input
                        v-model="profileForm.lastname"
                        type="text"
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#4A9FDB] transition-all hover:border-gray-300"
                        placeholder="นามสกุล"
                      />
                    </div>

                    <!-- Birthday -->
                    <div class="group">
                      <label class="block text-sm font-bold text-white mb-2">
                        วันเกิด
                      </label>
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#4A9FDB] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                          </svg>
                        </div>
                        <input
                          v-model="profileForm.birthday"
                          type="date"
                          class="w-full pl-10 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#4A9FDB] transition-all hover:border-gray-300"
                        />
                      </div>
                    </div>

                    <!-- Gender -->
                    <div>
                      <label class="block text-sm font-bold text-white mb-2">
                        เพศ
                      </label>
                      <select
                        v-model="profileForm.gender"
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#4A9FDB] transition-all hover:border-gray-300"
                      >
                        <option value="">เลือกเพศ</option>
                        <option value="male">ชาย</option>
                        <option value="female">หญิง</option>
                        <option value="other">อื่นๆ</option>
                      </select>
                    </div>

                    <!-- Phone -->
                    <div class="group md:col-span-2">
                      <label class="block text-sm font-bold text-white mb-2">
                        เบอร์โทรศัพท์
                      </label>
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#4A9FDB] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                          </svg>
                        </div>
                        <input
                          v-model="profileForm.phone"
                          type="tel"
                          class="w-full pl-10 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#4A9FDB] transition-all hover:border-gray-300"
                          placeholder="เบอร์โทรศัพท์"
                        />
                      </div>
                    </div>

                    <!-- Bio -->
                    <div class="md:col-span-2">
                      <label class="block text-sm font-bold text-white mb-2">
                        เกี่ยวกับตัวคุณ
                      </label>
                      <textarea
                        v-model="profileForm.bio"
                        rows="4"
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#4A9FDB] focus:border-[#4A9FDB] transition-all hover:border-gray-300 resize-none"
                        placeholder="เขียนอะไรเกี่ยวกับตัวคุณสักหน่อย..."
                      ></textarea>
                    </div>
                  </div>

                  <!-- Error Message -->
                  <Transition
                    enter-active-class="transition-all duration-200"
                    enter-from-class="opacity-0 -translate-y-2"
                    leave-active-class="transition-all duration-150"
                    leave-to-class="opacity-0 -translate-y-2"
                  >
                    <div v-if="profileError" class="bg-white border-l-4 border-red-500 rounded-xl p-4 shadow-lg">
                      <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-700 text-sm font-semibold">{{ profileError }}</p>
                      </div>
                    </div>
                  </Transition>

                  <!-- Success Message -->
                  <Transition
                    enter-active-class="transition-all duration-200"
                    enter-from-class="opacity-0 -translate-y-2"
                    leave-active-class="transition-all duration-150"
                    leave-to-class="opacity-0 -translate-y-2"
                  >
                    <div v-if="profileSuccess" class="bg-white border-l-4 border-green-500 rounded-xl p-4 shadow-lg">
                      <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-700 text-sm font-semibold">อัปเดตโปรไฟล์สำเร็จ!</p>
                      </div>
                    </div>
                  </Transition>

                  <!-- Actions -->
                  <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4 border-t-2 border-white/20">
                    <button
                      type="button"
                      @click="closeProfileModal"
                      class="px-6 py-3 bg-white border-2 border-white text-[#003B7A] font-bold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-lg"
                      :disabled="profileSaving"
                    >
                      ยกเลิก
                    </button>
                    <button
                      type="submit"
                      class="px-6 py-3 bg-white hover:bg-gray-50 text-[#003B7A] font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 disabled:opacity-50 flex items-center justify-center space-x-2"
                      :disabled="profileSaving"
                    >
                      <svg v-if="profileSaving" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      <span>{{ profileSaving ? 'กำลังบันทึก...' : 'บันทึกการเปลี่ยนแปลง' }}</span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </Transition>
        </div>
      </Transition>
    </Teleport>
  </div>
  
  <!-- Loading state while auth is being restored -->
  <div v-else class="min-h-screen bg-gradient-to-br from-[#E8F4F8] to-[#D6EAF8] flex items-center justify-center">
    <div class="text-center">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-[#003B7A] border-t-transparent"></div>
      <p class="mt-4 text-[#003B7A] font-semibold">กำลังโหลด...</p>
    </div>
  </div>
</template>

<script setup lang="ts">
const { user, logout, checkAuth } = useAuth()
const { getMedia } = useMedia()
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
const authReady = ref(false)
const searchQuery = ref('')
const searchTimeout = ref<number | null>(null)

// Media state
const allMedia = ref<any[]>([])
const filteredMedia = ref<any[]>([])
const mediaLoading = ref(false)

// Profile Modal State
const showProfileModal = ref(false)
const profileSaving = ref(false)
const profileError = ref('')
const profileSuccess = ref(false)

// Profile Form
const profileForm = ref({
  username: '',
  email: '',
  firstname: '',
  lastname: '',
  name: '',
  birthday: '',
  gender: '',
  phone: '',
  bio: ''
})

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

// Fetch media
const fetchMedia = async () => {
  try {
    mediaLoading.value = true
    const response: any = await getMedia(1, '')
    if (response.success) {
      // แสดงสื่อทุกประเภท
      allMedia.value = response.data.data || []
      filteredMedia.value = allMedia.value
    }
  } catch (error) {
    console.error('Error fetching media:', error)
  } finally {
    mediaLoading.value = false
  }
}

// Search media
const searchMedia = async (query: string) => {
  try {
    mediaLoading.value = true
    const response: any = await getMedia(1, query)
    if (response.success) {
      // แสดงผลค้นหาทุกประเภทสื่อ
      filteredMedia.value = response.data.data || []
    }
  } catch (error) {
    console.error('Error searching media:', error)
    filteredMedia.value = []
  } finally {
    mediaLoading.value = false
  }
}

// Fetch courses on mount
onMounted(async () => {
  // Ensure auth is restored from storage
  checkAuth()
  authReady.value = true
  await Promise.all([
    fetchCourses(),
    fetchMedia()
  ])
})

// Handle search input with debounce
const handleSearchInput = () => {
  if (searchTimeout.value) {
    clearTimeout(searchTimeout.value)
  }
  
  searchTimeout.value = setTimeout(() => {
    if (searchQuery.value.trim()) {
      searchCourses(searchQuery.value)
      searchMedia(searchQuery.value)
      showSearchResults.value = true
    } else {
      showSearchResults.value = false
      filteredMedia.value = allMedia.value
    }
  }, 500)
}

// Clear search
const clearSearch = () => {
  searchQuery.value = ''
  showSearchResults.value = false
  filteredMedia.value = allMedia.value
}

// Handle search (legacy - kept for compatibility)
const handleSearch = (query: string) => {
  searchQuery.value = query
  if (query.trim()) {
    searchCourses(query)
    searchMedia(query)
    showSearchResults.value = true
  } else {
    showSearchResults.value = false
    filteredMedia.value = allMedia.value
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

// View media
const viewMedia = (id: string) => {
  navigateTo(`/teacher/media/${id}`)
}

// Get media type label
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

// Get media type color
const getMediaTypeColor = (type: string) => {
  const colors: Record<string, string> = {
    video: 'text-purple-700',
    document: 'text-blue-700',
    image: 'text-green-700',
    audio: 'text-orange-700',
    other: 'text-gray-700'
  }
  return colors[type] || 'text-gray-700'
}

// Format file size
const formatFileSize = (bytes: number) => {
  if (!bytes) return '0 B'
  const k = 1024
  const sizes = ['B', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

// Handle download
const handleDownload = async (mediaId: string, title: string) => {
  try {
    const { downloadMedia } = useMedia()
    await downloadMedia(mediaId)
  } catch (error: any) {
    console.error('Download error:', error)
    alert(error.message || 'ไม่สามารถดาวน์โหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง')
  }
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

// Profile Functions
const getInitials = (name: string = '') => {
  if (!name) return '?'
  const parts = name.split(' ').filter(p => p.length > 0)
  if (parts.length >= 2) {
    const first = parts[0]?.[0] || ''
    const second = parts[1]?.[0] || ''
    return (first + second).toUpperCase()
  }
  return name.substring(0, 2).toUpperCase()
}

const initializeProfileForm = () => {
  if (user.value) {
    profileForm.value = {
      username: user.value.username || '',
      email: user.value.email || '',
      firstname: user.value.firstname || '',
      lastname: user.value.lastname || '',
      name: user.value.name || '',
      birthday: user.value.birthday || '',
      gender: user.value.gender || '',
      phone: user.value.phone || '',
      bio: user.value.bio || ''
    }
  }
}

const closeProfileModal = () => {
  showProfileModal.value = false
  profileError.value = ''
  profileSuccess.value = false
}

const handleUpdateProfile = async () => {
  profileSaving.value = true
  profileError.value = ''
  profileSuccess.value = false

  try {
    // Validate required fields
    if (!profileForm.value.email || !profileForm.value.firstname || !profileForm.value.lastname) {
      profileError.value = 'กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน'
      profileSaving.value = false
      return
    }

    // Simulate API call (replace with actual API later)
    await new Promise(resolve => setTimeout(resolve, 1000))

    // Update local user state
    if (typeof window !== 'undefined') {
      const updatedUser = {
        ...user.value,
        ...profileForm.value
      }
      
      // Update localStorage/sessionStorage
      if (localStorage.getItem('auth_token')) {
        localStorage.setItem('auth_user', JSON.stringify(updatedUser))
      } else if (sessionStorage.getItem('auth_token')) {
        sessionStorage.setItem('auth_user', JSON.stringify(updatedUser))
      }
      
      // Refresh auth state
      checkAuth()
    }

    profileSuccess.value = true
    
    // Close modal after 2 seconds
    setTimeout(() => {
      closeProfileModal()
    }, 2000)

  } catch (error: any) {
    console.error('Profile update error:', error)
    profileError.value = error.message || 'เกิดข้อผิดพลาดในการอัปเดตโปรไฟล์'
  } finally {
    profileSaving.value = false
  }
}

// Initialize profile form when modal opens
watch(showProfileModal, (newValue) => {
  if (newValue) {
    initializeProfileForm()
  }
})
</script>

<style scoped>
/* Smooth Scrollbar */
.smooth-scroll {
  scroll-behavior: smooth;
  scrollbar-width: thin;
  scrollbar-color: rgba(255, 255, 255, 0.5) rgba(255, 255, 255, 0.1);
}

.smooth-scroll::-webkit-scrollbar {
  width: 10px;
}

.smooth-scroll::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

.smooth-scroll::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.5);
  border-radius: 10px;
  border: 2px solid rgba(0, 59, 122, 0.3);
}

.smooth-scroll::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.7);
}

/* Input Focus Effects */
input:focus,
textarea:focus,
select:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
}

/* Backdrop Blur */
@supports ((-webkit-backdrop-filter: blur(10px)) or (backdrop-filter: blur(10px))) {
  .backdrop-blur-sm {
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
  }
}

/* Line Clamp */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  line-clamp: 2;
}
</style>
