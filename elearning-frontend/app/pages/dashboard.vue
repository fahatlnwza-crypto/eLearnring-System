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
            <div class="text-[#003B7A]">
              <span class="font-semibold">สวัสดี, </span>
              <span>{{ user?.name || user?.firstname || user?.email || 'ผู้ใช้' }}</span>
            </div>
            <!-- Profile Button -->
            <NuxtLink
              to="/profile"
              class="flex items-center space-x-2 bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#00305e] hover:to-[#3c8ac4] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-200 hover:scale-105"
              title="ไปหน้าโปรไฟล์"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <span>โปรไฟล์</span>
            </NuxtLink>
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
          ยินดีต้อนรับกลับมา! <span v-if="user">{{ user.name || user.firstname || user.email || 'ผู้ใช้' }}</span>
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

// Fetch courses on mount
onMounted(async () => {
  // Ensure auth is restored from storage
  checkAuth()
  authReady.value = true
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
</style>
