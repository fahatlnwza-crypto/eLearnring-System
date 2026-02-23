export default defineNuxtRouteMiddleware((to, from) => {
  // Only run on client-side
  if (process.server) return

  const { isAuthenticated, checkAuth, user } = useAuth()

  // Restore auth state from storage before checking
  checkAuth()

  // List of routes that require authentication
  const protectedRoutes = ['/dashboard', '/profile', '/account', '/edit-profile', '/teacher']
  
  // List of public routes (anyone can access)
  const publicRoutes = ['/login', '/register', '/forgot-password', '/', '/about', '/contact']

  const isProtectedRoute = protectedRoutes.some(route => to.path.startsWith(route))
  const isTeacherRoute = to.path.startsWith('/teacher')

  // If trying to access protected route without authentication
  if (isProtectedRoute && !isAuthenticated.value) {
    return navigateTo('/login')
  }

  // If trying to access teacher routes without teacher role
  if (isTeacherRoute && isAuthenticated.value) {
    if (user.value?.role !== 'teacher' && user.value?.role !== 'admin') {
      return navigateTo('/dashboard')
    }
  }

  // If authenticated and trying to access login/register, redirect to dashboard
  if ((to.path === '/login' || to.path === '/register') && isAuthenticated.value) {
    return navigateTo('/dashboard')
  }
})
