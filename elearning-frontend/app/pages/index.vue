<template>
  <div class="min-h-screen bg-gradient-to-br from-[#E8F4F8] via-white to-[#D6EAF8]">
    <!-- Navigation -->
    <nav class="bg-white shadow-md border-b-4 border-[#003B7A]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">
              USP E-Learning
            </h1>
          </div>
          <div class="flex items-center space-x-4">
            <NuxtLink
              v-if="!isAuthenticated"
              to="/login"
              class="text-[#003B7A] hover:text-[#4A9FDB] px-3 py-2 rounded-md text-sm font-medium transition duration-200"
            >
              เข้าสู่ระบบ
            </NuxtLink>
            <NuxtLink
              v-if="isAuthenticated"
              to="/dashboard"
              class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 shadow-md"
            >
              Dashboard
            </NuxtLink>
            <button
              v-if="isAuthenticated"
              @click="handleLogout"
              class="text-[#003B7A] hover:text-[#4A9FDB] px-3 py-2 rounded-md text-sm font-medium transition duration-200"
            >
              ออกจากระบบ
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <div class="flex justify-center mb-6">
            <img src="/assets/css/logoudom.png" alt="USP Logo" class="h-48 w-auto">
          </div>
          <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
            <span class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] bg-clip-text text-transparent">
              วิทยาลัยเทคโนโลยีอุดมศึกษาพณิชยการ
            </span>
          </h1>
          <p class="text-2xl font-bold text-[#003B7A] mb-4">
            Udomsueksaphanitchayakan Technological College
          </p>
          <p class="text-xl text-gray-600 mb-4 max-w-3xl mx-auto">
            ปลูกฝังจริยธรรม เลิศล้ำวิชาการ ชำนาญทักษะ
          </p>
          <p class="text-lg text-gray-700 mb-8 max-w-4xl mx-auto">
            สร้างบรรยากาศแห่งการเรียนรู้ที่ผสมผสานทั้งความรู้ ทักษะ และประสบการณ์ชีวิต โดยมุ่งเน้นให้นักศึกษาได้รับการพัฒนาทั้งด้านวิชาการ ด้านวิชาชีพ และด้านคุณธรรมจริยธรรม
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <NuxtLink
              v-if="!isAuthenticated"
              to="/login"
              class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-lg hover:shadow-xl"
            >
              เริ่มต้นใช้งาน
            </NuxtLink>
            <NuxtLink
              v-if="isAuthenticated"
              to="/dashboard"
              class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] hover:from-[#002855] hover:to-[#3A8FCB] text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-lg hover:shadow-xl"
            >
              ไปที่ Dashboard
            </NuxtLink>
            <a
              href="https://www.usp.ac.th/"
              target="_blank"
              rel="noopener noreferrer"
              class="bg-white hover:bg-gray-50 text-gray-900 font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-lg hover:shadow-xl border-2 border-gray-200"
            >
              เรียนรู้เพิ่มเติม
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Achievements Section -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">
          รางวัลและความสำเร็จ
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 shadow-lg hover:shadow-2xl transition duration-300 border-2 border-yellow-200">
            <div class="text-5xl mb-3 text-center">👑</div>
            <h3 class="text-lg font-bold text-[#003B7A] mb-2 text-center">พระราชทานความเป็นเลิศ</h3>
            <p class="text-gray-700 text-center text-sm">ด้านอาชีวศึกษา ครั้งที่ 7</p>
          </div>
          
          <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 shadow-lg hover:shadow-2xl transition duration-300 border-2 border-purple-200">
            <div class="text-5xl mb-3 text-center">⭐</div>
            <h3 class="text-lg font-bold text-[#003B7A] mb-2 text-center">ศูนย์บ่มเพาะผู้ประกอบการ</h3>
            <p class="text-gray-700 text-center text-sm">อาชีวศึกษา ระดับ 5 ดาว</p>
          </div>
          
          <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 shadow-lg hover:shadow-2xl transition duration-300 border-2 border-blue-200">
            <div class="text-5xl mb-3 text-center">📊</div>
            <h3 class="text-lg font-bold text-[#003B7A] mb-2 text-center">Top 5 ของประเทศ</h3>
            <p class="text-gray-700 text-center text-sm">นักศึกษาเข้าศึกษาต่อสูงสุด</p>
          </div>
          
          <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-xl p-6 shadow-lg hover:shadow-2xl transition duration-300 border-2 border-green-200">
            <div class="text-5xl mb-3 text-center">🎓</div>
            <h3 class="text-lg font-bold text-[#003B7A] mb-2 text-center">45+ ปี</h3>
            <p class="text-gray-700 text-center text-sm">แห่งความเป็นเลิศทางการศึกษา</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gradient-to-br from-[#E8F4F8] via-white to-[#D6EAF8]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-4">
          ทำไมต้องเลือก USP?
        </h2>
        <p class="text-center text-gray-600 mb-12 max-w-3xl mx-auto">
          วิทยาลัยที่มุ่งเน้นการพัฒนานักศึกษาอย่างครบวงจร
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition duration-300">
            <div class="bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] w-16 h-16 rounded-full flex items-center justify-center mb-4 shadow-lg mx-auto">
              <span class="text-3xl">📚</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">การพัฒนาด้านวิชาการ</h3>
            <p class="text-gray-700 text-center">
              หลักสูตรที่ทันสมัยและตรงกับความต้องการของตลาดแรงงาน พร้อมอาจารย์ผู้เชี่ยวชาญ
            </p>
          </div>

          <!-- Feature 2 -->
          <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition duration-300">
            <div class="bg-gradient-to-r from-[#4A9FDB] to-[#003B7A] w-16 h-16 rounded-full flex items-center justify-center mb-4 shadow-lg mx-auto">
              <span class="text-3xl">💼</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">การพัฒนาด้านวิชาชีพ</h3>
            <p class="text-gray-700 text-center">
              ฝึกปฏิบัติจริง พัฒนาทักษะอาชีพที่จำเป็น พร้อมสู่โลกการทำงาน
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition duration-300">
            <div class="bg-gradient-to-br from-[#003B7A] via-[#4A9FDB] to-[#87CEEB] w-16 h-16 rounded-full flex items-center justify-center mb-4 shadow-lg mx-auto">
              <span class="text-3xl">🌟</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">การพัฒนาคุณธรรมจริยธรรม</h3>
            <p class="text-gray-700 text-center">
              ปลูกฝังคุณธรรม จริยธรรม และความรับผิดชอบต่อสังคม
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Info Section -->
    <section class="py-16 bg-white">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">
          ติดต่อเรา
        </h2>
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 shadow-xl">
          <div class="grid md:grid-cols-2 gap-8">
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <span class="text-2xl">📍</span>
                <div>
                  <h3 class="font-bold text-[#003B7A] mb-1">ที่อยู่</h3>
                  <p class="text-gray-700">406 ถนนธรรมนูญวิถี ตำบลหาดใหญ่<br>อำเภอหาดใหญ่ จังหวัดสงขลา 90110</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <span class="text-2xl">📞</span>
                <div>
                  <h3 class="font-bold text-[#003B7A] mb-1">โทรศัพท์</h3>
                  <a href="tel:074357547" class="text-gray-700 hover:text-[#003B7A] transition-colors">074-357547</a>
                </div>
              </div>
            </div>
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <span class="text-2xl">✉️</span>
                <div>
                  <h3 class="font-bold text-[#003B7A] mb-1">อีเมล</h3>
                  <a href="mailto:uspschool@hotmail.com" class="text-gray-700 hover:text-[#003B7A] transition-colors">uspschool@hotmail.com</a>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <span class="text-2xl">🌐</span>
                <div>
                  <h3 class="font-bold text-[#003B7A] mb-1">เว็บไซต์</h3>
                  <a href="https://www.usp.ac.th" target="_blank" class="text-gray-700 hover:text-[#003B7A] transition-colors">www.usp.ac.th</a>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Social Media -->
          <div class="mt-8 pt-8 border-t border-blue-200">
            <h3 class="font-bold text-[#003B7A] mb-4 text-center">ติดตามเราได้ที่</h3>
            <div class="flex justify-center gap-4">
              <a href="https://www.facebook.com/uspcollege" target="_blank" 
                 class="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all duration-200 hover:scale-110 shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
              </a>
              <a href="https://www.instagram.com/udom_uspcollege/" target="_blank"
                 class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full hover:from-purple-700 hover:to-pink-700 transition-all duration-200 hover:scale-110 shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                  <path d="M12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
              </a>
              <a href="https://www.youtube.com/@uspcollege" target="_blank"
                 class="flex items-center justify-center w-12 h-12 bg-red-600 text-white rounded-full hover:bg-red-700 transition-all duration-200 hover:scale-110 shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
              </a>
              <a href="https://www.tiktok.com/@udom_uspcollege" target="_blank"
                 class="flex items-center justify-center w-12 h-12 bg-black text-white rounded-full hover:bg-gray-800 transition-all duration-200 hover:scale-110 shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-[#003B7A] via-[#4A9FDB] to-[#87CEEB] relative overflow-hidden">
      <!-- Decorative wave -->
      <div class="absolute inset-0 opacity-10">
        <svg class="absolute bottom-0 w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
          <path fill="white" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
      </div>
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-4xl font-bold text-white mb-6 drop-shadow-lg">
          มาเป็นส่วนหนึ่งของ USP
        </h2>
        <p class="text-xl text-white mb-4 drop-shadow">
          สถาบันการศึกษาที่มุ่งมั่นพัฒนาศักยภาพนักศึกษาสู่ความเป็นเลิศ
        </p>
        <p class="text-lg text-white mb-8 drop-shadow">
          พร้อมบรรยากาศการเรียนรู้ที่อบอุ่น ปลอดภัย และสร้างสรรค์
        </p>
        <NuxtLink
          v-if="!isAuthenticated"
          to="/login"
          class="inline-block bg-white hover:bg-gray-50 text-[#003B7A] font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-xl hover:shadow-2xl hover:scale-105 transform"
        >
          เริ่มต้นเรียนฟรี
        </NuxtLink>
        <NuxtLink
          v-if="isAuthenticated"
          to="/dashboard"
          class="inline-block bg-white hover:bg-gray-50 text-[#003B7A] font-bold py-3 px-8 rounded-lg text-lg transition duration-150 shadow-xl hover:shadow-2xl hover:scale-105 transform"
        >
          ไปที่ Dashboard
        </NuxtLink>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
          <div>
            <h3 class="text-xl font-bold mb-4 text-[#4A9FDB]">วิทยาลัยเทคโนโลยีอุดมศึกษาพณิชยการ</h3>
            <p class="text-gray-400 text-sm mb-2">ปลูกฝังจริยธรรม เลิศล้ำวิชาการ ชำนาญทักษะ</p>
            <p class="text-gray-400 text-sm">Udomsueksaphanitchayakan Technological College</p>
          </div>
          <div>
            <h4 class="text-lg font-bold mb-4 text-[#4A9FDB]">ติดต่อเรา</h4>
            <p class="text-gray-400 text-sm mb-2">📍 406 ถ.ธรรมนูญวิถี ต.หาดใหญ่<br>&nbsp;&nbsp;&nbsp;&nbsp;อ.หาดใหญ่ จ.สงขลา 90110</p>
            <p class="text-gray-400 text-sm mb-2">📞 074-357547</p>
            <p class="text-gray-400 text-sm">✉️ uspschool@hotmail.com</p>
          </div>
          <div>
            <h4 class="text-lg font-bold mb-4 text-[#4A9FDB]">เมนู</h4>
            <div class="flex flex-col space-y-2">
              <NuxtLink to="/about" class="text-gray-400 hover:text-white transition duration-150 text-sm">
                เกี่ยวกับเรา
              </NuxtLink>
              <NuxtLink to="/contact" class="text-gray-400 hover:text-white transition duration-150 text-sm">
                ติดต่อเรา
              </NuxtLink>
              <a href="https://www.usp.ac.th" target="_blank" class="text-gray-400 hover:text-white transition duration-150 text-sm">
                เว็บไซต์หลัก
              </a>
            </div>
          </div>
        </div>
        <div class="border-t border-gray-800 pt-8">
          <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
              <p class="text-gray-400 text-sm">© 2026 Udomsueksaphanitchayakan Technological College. All rights reserved.</p>
            </div>
            <div class="flex space-x-4">
              <a href="https://www.facebook.com/uspcollege" target="_blank" class="text-gray-400 hover:text-white transition duration-150">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
              <a href="https://www.instagram.com/udom_uspcollege/" target="_blank" class="text-gray-400 hover:text-white transition duration-150">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/><path d="M12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              </a>
              <a href="https://www.youtube.com/@uspcollege" target="_blank" class="text-gray-400 hover:text-white transition duration-150">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
              </a>
              <a href="https://www.tiktok.com/@udom_uspcollege" target="_blank" class="text-gray-400 hover:text-white transition duration-150">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
const { isAuthenticated, logout, checkAuth } = useAuth()

// Check auth on mount
onMounted(() => {
  checkAuth()
})

// Handle logout
const handleLogout = async () => {
  await logout()
}
</script>

<style scoped>
/* Page-specific styles */
</style>
