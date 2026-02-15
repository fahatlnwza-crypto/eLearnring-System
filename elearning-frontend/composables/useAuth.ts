export const useAuth = () => {
  const config = useRuntimeConfig()
  const router = useRouter()
  
  // State
  const user = useState<any>('user', () => null)
  const token = useState<string | null>('token', () => null)
  const isAuthenticated = computed(() => !!user.value)

  // Login function
  const login = async (email: string, password: string) => {
    try {
      const response = await $fetch(`${config.public.apiBaseUrl}/api/auth/login`, {
        method: 'POST',
        body: {
          email,
          password
        }
      })

      if (response && response.token) {
        token.value = response.token
        user.value = response.user
        
        // Store token in localStorage
        if (process.client) {
          localStorage.setItem('auth_token', response.token)
          localStorage.setItem('user', JSON.stringify(response.user))
        }

        return { success: true, data: response }
      }

      return { success: false, error: 'Invalid response from server' }
    } catch (error: any) {
      console.error('Login error:', error)
      return { 
        success: false, 
        error: error.data?.message || error.message || 'Login failed. Please try again.' 
      }
    }
  }

  // Logout function
  const logout = async () => {
    try {
      // Call logout API if needed
      if (token.value) {
        await $fetch(`${config.public.apiBaseUrl}/api/auth/logout`, {
          method: 'POST',
          headers: {
            Authorization: `Bearer ${token.value}`
          }
        }).catch(() => {
          // Ignore logout API errors
        })
      }
    } finally {
      // Clear state
      user.value = null
      token.value = null
      
      // Clear localStorage
      if (process.client) {
        localStorage.removeItem('auth_token')
        localStorage.removeItem('user')
      }

      // Redirect to login
      await router.push('/login')
    }
  }

  // Check auth status from localStorage
  const checkAuth = () => {
    if (process.client) {
      const storedToken = localStorage.getItem('auth_token')
      const storedUser = localStorage.getItem('user')

      if (storedToken && storedUser) {
        token.value = storedToken
        try {
          user.value = JSON.parse(storedUser)
        } catch (e) {
          console.error('Error parsing user data:', e)
          logout()
        }
      }
    }
  }

  // Register function
  const register = async (username: string, email: string, password: string, password_confirmation: string, firstname: string, lastname: string, birthday?: string, gender?: string) => {
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

      if (response && response.token) {
        token.value = response.token
        user.value = response.user
        
        // Store token in localStorage
        if (process.client) {
          localStorage.setItem('auth_token', response.token)
          localStorage.setItem('user', JSON.stringify(response.user))
        }

        return { success: true, data: response }
      }

      return { success: false, error: 'Invalid response from server' }
    } catch (error: any) {
      console.error('Register error:', error)
      return { 
        success: false, 
        error: error.data?.message || error.message || 'Registration failed. Please try again.',
        errors: error.data?.errors || null
      }
    }
  }

  // Get user profile
  const fetchUser = async () => {
    if (!token.value) return

    try {
      const response = await $fetch(`${config.public.apiBaseUrl}/api/auth/me`, {
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      })

      if (response && response.user) {
        user.value = response.user
        if (process.client) {
          localStorage.setItem('user', JSON.stringify(response.user))
        }
      }
    } catch (error) {
      console.error('Error fetching user:', error)
      // If unauthorized, logout
      if (error.statusCode === 401) {
        await logout()
      }
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    login,
    register,
    logout,
    checkAuth,
    fetchUser
  }
}
