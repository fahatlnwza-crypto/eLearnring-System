export default defineNuxtRouteMiddleware((to, from) => {
  const { isAuthenticated, checkAuth } = useAuth()

  // Check if token exists in storage
  checkAuth()

  // List of routes that require authentication
  const protectedRoutes = ['/dashboard', '/profile', '/account']
  
  // List of public routes (anyone can access)
  const publicRoutes = ['/login', '/register', '/forgot-password', '/']

  const isProtectedRoute = protectedRoutes.some(route => to.path.startsWith(route))
  const isPublicRoute = publicRoutes.includes(to.path)

  // If trying to access protected route without authentication
  if (isProtectedRoute && !isAuthenticated.value) {
    return navigateTo('/login')
  }

  // If authenticated and trying to access login/register, redirect to dashboard
  if ((to.path === '/login' || to.path === '/register') && isAuthenticated.value) {
    return navigateTo('/dashboard')
  }
})
