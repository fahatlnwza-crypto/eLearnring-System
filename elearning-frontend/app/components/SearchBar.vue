<template>
  <div class="w-full">
    <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-[#003B7A]">
      <!-- Search Input -->
      <div class="relative mb-4">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
        <input
          v-model="searchQuery"
          type="text"
          placeholder="ค้นหาคอร์สเรียน บทเรียน หรือเนื้อหา..."
          class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4A9FDB] focus:border-transparent transition"
          @input="onSearch"
        />
      </div>

      <!-- Categories Filter -->
      <div class="flex flex-wrap gap-2">
        <button
          v-for="category in categories"
          :key="category.id"
          @click="toggleCategory(category.id)"
          :class="[
            'px-4 py-2 rounded-lg font-semibold transition duration-200',
            selectedCategories.includes(category.id)
              ? 'bg-gradient-to-r from-[#003B7A] to-[#4A9FDB] text-white shadow-md'
              : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
          ]"
        >
          {{ category.name }}
        </button>
        <button
          v-if="selectedCategories.length > 0"
          @click="clearCategories"
          class="px-4 py-2 rounded-lg font-semibold bg-red-100 text-red-600 hover:bg-red-200 transition duration-200"
        >
          ล้างตัวกรอง
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const emit = defineEmits<{
  search: [query: string]
  filterCategories: [categories: string[]]
}>()

const searchQuery = ref('')
const selectedCategories = ref<string[]>([])

const categories = [
  { id: 'programming', name: 'โปรแกรมมิ่ง' },
  { id: 'design', name: 'ดิไซน์' },
  { id: 'business', name: 'ธุรกิจ' },
  { id: 'marketing', name: 'การตลาด' },
  { id: 'language', name: 'ภาษา' },
  { id: 'science', name: 'วิทยาศาสตร์' }
]

const onSearch = () => {
  emit('search', searchQuery.value)
}

const toggleCategory = (categoryId: string) => {
  const index = selectedCategories.value.indexOf(categoryId)
  if (index > -1) {
    selectedCategories.value.splice(index, 1)
  } else {
    selectedCategories.value.push(categoryId)
  }
  emit('filterCategories', selectedCategories.value)
}

const clearCategories = () => {
  selectedCategories.value = []
  emit('filterCategories', [])
}
</script>
