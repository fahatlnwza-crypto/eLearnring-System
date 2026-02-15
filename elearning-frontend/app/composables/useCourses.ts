export interface Course {
  id: string
  title: string
  description: string
  category: string
  image?: string
  students: number
  duration: string
  rating: number
  progress?: number
  isPopular?: boolean
  isRecommended?: boolean
  lastAccessed?: Date
}

export const useCourses = () => {
  const config = useRuntimeConfig()
  
  // State
  const allCourses = ref<Course[]>([])
  const popularCourses = ref<Course[]>([])
  const recommendedCourses = ref<Course[]>([])
  const recentCourses = ref<Course[]>([])
  const filteredCourses = ref<Course[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  // Mock data สำหรับการพัฒนา (จะเปลี่ยนเป็น API จริงในภายหลัง)
  const mockCourses: Course[] = [
    {
      id: '1',
      title: 'การเขียนโปรแกรม JavaScript เบื้องต้น',
      description: 'เรียนรู้พื้นฐาน JavaScript ตั้งแต่เริ่มต้นจนสามารถเขียนโปรแกรมได้',
      category: 'โปรแกรมมิ่ง',
      students: 1234,
      duration: '10 ชั่วโมง',
      rating: 4.8,
      progress: 65,
      isPopular: true,
      isRecommended: true,
      lastAccessed: new Date('2026-02-15')
    },
    {
      id: '2',
      title: 'การออกแบบ UI/UX สำหรับมือใหม่',
      description: 'เรียนรู้หลักการออกแบบ User Interface และ User Experience แบบมืออาชีพ',
      category: 'ดิไซน์',
      students: 892,
      duration: '8 ชั่วโมง',
      rating: 4.6,
      progress: 30,
      isPopular: true,
      isRecommended: false,
      lastAccessed: new Date('2026-02-14')
    },
    {
      id: '3',
      title: 'Digital Marketing ยุคใหม่',
      description: 'กลยุทธ์การตลาดดิจิทัลที่ใช้ได้จริง เพิ่มยอดขายด้วย Social Media',
      category: 'การตลาด',
      students: 2156,
      duration: '12 ชั่วโมง',
      rating: 4.9,
      isPopular: true,
      isRecommended: true
    },
    {
      id: '4',
      title: 'Python สำหรับ Data Science',
      description: 'เรียนรู้การใช้ Python ในการวิเคราะห์ข้อมูลและ Machine Learning',
      category: 'โปรแกรมมิ่ง',
      students: 1567,
      duration: '15 ชั่วโมง',
      rating: 4.7,
      progress: 15,
      isPopular: false,
      isRecommended: true,
      lastAccessed: new Date('2026-02-10')
    },
    {
      id: '5',
      title: 'ภาษาอังกฤษธุรกิจ',
      description: 'เรียนรู้ภาษาอังกฤษที่ใช้ในการทำงานและการสื่อสารทางธุรกิจ',
      category: 'ภาษา',
      students: 3421,
      duration: '20 ชั่วโมง',
      rating: 4.5,
      isPopular: true,
      isRecommended: false
    },
    {
      id: '6',
      title: 'การบริหารโครงการด้วย Agile',
      description: 'เรียนรู้การบริหารโครงการแบบ Agile และ Scrum Framework',
      category: 'ธุรกิจ',
      students: 987,
      duration: '6 ชั่วโมง',
      rating: 4.4,
      progress: 80,
      isPopular: false,
      isRecommended: true,
      lastAccessed: new Date('2026-02-16')
    },
    {
      id: '7',
      title: 'การถ่ายภาพเบื้องต้น',
      description: 'เทคนิคการถ่ายภาพพื้นฐานสำหรับมือใหม่ ตั้งแต่การตั้งค่ากล้องจนถึงการจัดองค์ประกอบภาพ',
      category: 'ดิไซน์',
      students: 1765,
      duration: '9 ชั่วโมง',
      rating: 4.6,
      isPopular: false,
      isRecommended: false
    },
    {
      id: '8',
      title: 'เคมีพื้นฐาน',
      description: 'พื้นฐานเคมีสำหรับนักเรียนและผู้ที่สนใจ',
      category: 'วิทยาศาสตร์',
      students: 654,
      duration: '14 ชั่วโมง',
      rating: 4.3,
      isPopular: false,
      isRecommended: false
    }
  ]

  // Fetch all courses
  const fetchCourses = async () => {
    loading.value = true
    error.value = null

    try {
      // TODO: Replace with actual API call
      // const response = await $fetch(`${config.public.apiBaseUrl}/api/courses`)
      
      // Simulate API delay
      await new Promise(resolve => setTimeout(resolve, 500))
      
      allCourses.value = mockCourses
      updateFilteredLists()
      
      return { success: true, data: allCourses.value }
    } catch (err: any) {
      error.value = err.message || 'Failed to fetch courses'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  // Update filtered lists
  const updateFilteredLists = () => {
    // Popular courses
    popularCourses.value = allCourses.value
      .filter(course => course.isPopular)
      .slice(0, 6)

    // Recommended courses
    recommendedCourses.value = allCourses.value
      .filter(course => course.isRecommended)
      .slice(0, 6)

    // Recent courses (courses with lastAccessed date)
    recentCourses.value = allCourses.value
      .filter(course => course.lastAccessed)
      .sort((a, b) => {
        if (!a.lastAccessed || !b.lastAccessed) return 0
        return b.lastAccessed.getTime() - a.lastAccessed.getTime()
      })
      .slice(0, 6)
  }

  // Search courses
  const searchCourses = (query: string) => {
    if (!query.trim()) {
      filteredCourses.value = []
      return
    }

    const searchTerm = query.toLowerCase()
    filteredCourses.value = allCourses.value.filter(course =>
      course.title.toLowerCase().includes(searchTerm) ||
      course.description.toLowerCase().includes(searchTerm) ||
      course.category.toLowerCase().includes(searchTerm)
    )
  }

  // Filter by categories
  const filterByCategories = (categoryIds: string[]) => {
    if (categoryIds.length === 0) {
      filteredCourses.value = []
      return
    }

    // Map category IDs to Thai names
    const categoryMap: { [key: string]: string } = {
      'programming': 'โปรแกรมมิ่ง',
      'design': 'ดิไซน์',
      'business': 'ธุรกิจ',
      'marketing': 'การตลาด',
      'language': 'ภาษา',
      'science': 'วิทยาศาสตร์'
    }

    const selectedCategories = categoryIds.map(id => categoryMap[id]).filter(Boolean)
    
    filteredCourses.value = allCourses.value.filter(course =>
      selectedCategories.includes(course.category)
    )
  }

  // Get course by ID
  const getCourseById = (id: string) => {
    return allCourses.value.find(course => course.id === id)
  }

  // Start course (navigate to course page)
  const startCourse = (courseId: string) => {
    // TODO: Implement navigation to course detail page
    console.log('Starting course:', courseId)
    // navigateTo(`/courses/${courseId}`)
  }

  return {
    // State
    allCourses,
    popularCourses,
    recommendedCourses,
    recentCourses,
    filteredCourses,
    loading,
    error,

    // Methods
    fetchCourses,
    searchCourses,
    filterByCategories,
    getCourseById,
    startCourse
  }
}
