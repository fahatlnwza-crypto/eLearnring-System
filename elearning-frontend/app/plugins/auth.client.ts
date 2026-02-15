export default defineNuxtPlugin(async () => {
  const { checkAuth } = useAuth()
  
  // Restore auth state from localStorage on app initialization
  // This runs only on client-side
  if (process.client) {
    checkAuth()
  }
})
