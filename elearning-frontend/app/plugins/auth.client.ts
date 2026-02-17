export default defineNuxtPlugin(() => {
  const { checkAuth } = useAuth()
  
  // Restore auth state from localStorage on app initialization
  // This runs only on client-side (plugin file is .client.ts)
  const result = checkAuth()
  console.log('Auth restored:', result)
})
