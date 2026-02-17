export default defineNuxtRouteMiddleware((to, from) => {
  const { isAuthenticated, checkAuth } = useAuth()

  // Ensure auth state is restored (plugin should have done this, but double-check)
  if (typeof window !== 'undefined' && !isAuthenticated.value) {
    const result = checkAuth()
    // Give a moment for state to update
    if (!result.isAuthenticated && (to.path === '/dashboard' || to.path.startsWith('/dashboard'))) {
      return navigateTo('/login')
    }
  }

  // List of routes that require authentication
  const protectedRoutes = ['/dashboard', '/profile', '/account']
  
  // List of public routes (anyone can access)
  const publicRoutes = ['/login', '/register', '/forgot-password', '/']

  const isProtectedRoute = protectedRoutes.some(route => to.path.startsWith(route))

  // If trying to access protected route without authentication
  if (isProtectedRoute && !isAuthenticated.value) {
    return navigateTo('/login')
  }

  // If authenticated and trying to access login/register, redirect to dashboard
  if ((to.path === '/login' || to.path === '/register') && isAuthenticated.value) {
    return navigateTo('/dashboard')
  }
})
