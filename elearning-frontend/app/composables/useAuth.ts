export interface User {
  id?: string | number
  name?: string
  email?: string
  username?: string
  firstname?: string
  lastname?: string
}

export const useAuth = () => {
  const config = useRuntimeConfig()
  const user = useState<User | null>('auth.user', () => null)
  const token = useState<string>('auth.token', () => '')
  const isAuthenticated = computed(() => !!token.value)

  /**
   * Login a user
   */
  const login = async (email: string, password: string, rememberMe: boolean = false) => {
    try {
      const response = await $fetch(`${config.public.apiBaseUrl}/api/auth/login`, {
        method: 'POST',
        body: {
          email,
          password,
          remember: rememberMe
        }
      })

      if (response.token) {
        token.value = response.token
        user.value = response.user || { email }

        // Save token and user to localStorage (only on client-side)
        if (process.client) {
          if (rememberMe) {
            localStorage.setItem('auth_token', response.token)
            localStorage.setItem('auth_user', JSON.stringify(user.value))
          } else {
            sessionStorage.setItem('auth_token', response.token)
            sessionStorage.setItem('auth_user', JSON.stringify(user.value))
          }
        }
      }

      return response
    } catch (error) {
      throw error
    }
  }

  /**
   * Logout user
   */
  const logout = async () => {
    try {
      await $fetch(`${config.public.apiBaseUrl}/api/auth/logout`, {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      })
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      token.value = ''
      user.value = null
      
      // Clear storage only on client-side
      if (process.client) {
        localStorage.removeItem('auth_token')
        localStorage.removeItem('auth_user')
        sessionStorage.removeItem('auth_token')
        sessionStorage.removeItem('auth_user')
      }
      
      await navigateTo('/login')
    }
  }

  /**
   * Register a new user
   */
  const register = async (
    username: string,
    email: string,
    password: string,
    password_confirmation: string,
    firstname: string,
    lastname: string,
    birthday?: string,
    gender?: string
  ) => {
    try {
      const response = await $fetch(`${config.public.apiBaseUrl}/api/auth/register`, {
        method: 'POST',
        body: {
          username,
          email,
          password,
          password_confirmation,
          firstname,
          lastname,
          birthday,
          gender
        }
      })

      if (response.token) {
        token.value = response.token
        user.value = response.user || { email, username }
        
        // Save token and user only on client-side
        if (process.client) {
          localStorage.setItem('auth_token', response.token)
          localStorage.setItem('auth_user', JSON.stringify(user.value))
        }
      }

      return { success: true, ...response }
    } catch (error: any) {
      console.error('Register error:', error)
      return {
        success: false,
        error: error.data?.message || 'เกิดข้อผิดพลาดในการสมัครสมาชิก',
        errors: error.data?.errors
      }
    }
  }

  /**
   * Check if token exists and validate
   */
  const checkAuth = () => {
    // Only check storage on client-side
    if (process.client) {
      const storedToken = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token')
      const storedUser = localStorage.getItem('auth_user') || sessionStorage.getItem('auth_user')
      
      if (storedToken) {
        token.value = storedToken
        
        // Restore user data if available
        if (storedUser) {
          try {
            user.value = JSON.parse(storedUser)
          } catch (e) {
            console.error('Error parsing stored user:', e)
            user.value = null
          }
        }
      }
    }
  }

  /**
   * Get current user
   */
  const getUser = () => {
    return user.value
  }

  /**
   * Get auth token
   */
  const getToken = () => {
    return token.value
  }

  return {
    user: readonly(user),
    token: readonly(token),
    isAuthenticated,
    login,
    register,
    logout,
    checkAuth,
    getUser,
    getToken
  }
}
