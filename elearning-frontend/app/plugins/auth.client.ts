export default defineNuxtPlugin(() => {
  const { checkAuth } = useAuth()
  
  // Restore auth state from localStorage/sessionStorage on app initialization
  // This runs only on client-side (plugin file is .client.ts)
  if (typeof window !== 'undefined') {
    const result = checkAuth()
    console.log('Auth plugin - Auth state restored:', result)
  }
})
