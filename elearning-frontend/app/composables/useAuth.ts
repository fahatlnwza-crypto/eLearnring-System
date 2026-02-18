export interface User {
  id?: string | number
  name?: string
  email?: string
  username?: string
  firstname?: string
  lastname?: string
  birthday?: string
  gender?: string
  phone?: string
  bio?: string
  avatar?: string
}

interface AuthResponse {
  token: string
  user: User
  message?: string
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
      const response = await $fetch<AuthResponse>(`${config.public.apiBaseUrl}/api/auth/login`, {
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
        if (typeof window !== 'undefined') {
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
      if (typeof window !== 'undefined') {
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
      const response = await $fetch<AuthResponse>(`${config.public.apiBaseUrl}/api/auth/register`, {
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
        if (typeof window !== 'undefined') {
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
    if (typeof window !== 'undefined') {
      const storedToken = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token')
      const storedUser = localStorage.getItem('auth_user') || sessionStorage.getItem('auth_user')
      
      if (storedToken && !token.value) {
        token.value = storedToken
        
        // Restore user data if available
        if (storedUser) {
          try {
            const parsedUser = JSON.parse(storedUser)
            user.value = parsedUser
          } catch (e) {
            console.error('Error parsing stored user:', e)
            user.value = null
          }
        }
      }
    }
    
    return {
      isAuthenticated: !!token.value,
      user: user.value
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

  /**
   * Login with social provider (Google, Facebook)
   */
  const loginWithSocial = async (provider: 'google' | 'facebook') => {
    try {
      const config = useRuntimeConfig()
      
      // Get redirect URL from backend
      const response = await $fetch<{ url: string }>(`${config.public.apiBaseUrl}/api/auth/${provider}/redirect`, {
        method: 'GET'
      })

      if (response.url) {
        // Open social provider login in popup
        const width = 500
        const height = 600
        const left = window.screen.width / 2 - width / 2
        const top = window.screen.height / 2 - height / 2
        
        const popup = window.open(
          response.url,
          `${provider}_login`,
          `width=${width},height=${height},left=${left},top=${top}`
        )

        // Listen for message from popup
        return new Promise((resolve, reject) => {
          const messageHandler = (event: MessageEvent) => {
            // Verify origin if needed
            if (event.data.type === 'social-login-success') {
              window.removeEventListener('message', messageHandler)
              
              token.value = event.data.token
              user.value = event.data.user

              // Save to storage
              if (typeof window !== 'undefined') {
                localStorage.setItem('auth_token', event.data.token)
                localStorage.setItem('auth_user', JSON.stringify(event.data.user))
              }

              popup?.close()
              resolve(event.data)
            } else if (event.data.type === 'social-login-error') {
              window.removeEventListener('message', messageHandler)
              popup?.close()
              reject(new Error(event.data.message))
            }
          }

          window.addEventListener('message', messageHandler)

          // Timeout after 5 minutes
          setTimeout(() => {
            window.removeEventListener('message', messageHandler)
            popup?.close()
            reject(new Error('Social login timeout'))
          }, 300000)
        })
      }

      throw new Error('ไม่สามารถเชื่อมต่อกับ ' + provider + ' ได้')
    } catch (error) {
      console.error('Social login error:', error)
      throw error
    }
  }

  /**
   * Handle social callback (used in callback page)
   */
  const handleSocialCallback = async (provider: 'google' | 'facebook', code: string) => {
    try {
      const config = useRuntimeConfig()
      
      const response = await $fetch<AuthResponse>(`${config.public.apiBaseUrl}/api/auth/${provider}/callback?code=${code}`, {
        method: 'GET'
      })

      return response
    } catch (error) {
      console.error('Social callback error:', error)
      throw error
    }
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
    getToken,
    loginWithSocial,
    handleSocialCallback
  }
}
