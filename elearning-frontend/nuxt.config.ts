// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  
  // Application-wide settings
  app: {
    head: {
      title: 'Nuxt App',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        { name: 'description', content: 'A modern Nuxt.js application' }
      ]
    }
  },

  // Environment variables
  runtimeConfig: {
    public: {
      apiBaseUrl: process.env.NUXT_PUBLIC_API_BASE_URL || 'http://localhost:1880',
      appName: process.env.NUXT_PUBLIC_APP_NAME || 'E-Learning'
    }
  },

  // CSS and styling
  css: [
    '~/assets/css/main.css'
  ],

  // PostCSS configuration
  postcss: {
    plugins: {
      '@tailwindcss/postcss': {},
      autoprefixer: {},
    },
  },

  // Build configuration
  build: {
    transpile: []
  }
})
