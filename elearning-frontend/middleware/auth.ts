export default defineNuxtRouteMiddleware((to, from) => {
  const { isAuthenticated, checkAuth } = useAuth()

  // Check authentication status from localStorage
  checkAuth()

  // If not authenticated and trying to access protected route
  if (!isAuthenticated.value) {
    // Redirect to login page
    return navigateTo('/login')
  }
})
