# Nuxt 4 Frontend Application

A modern, fast, and scalable frontend application built with [Nuxt 4](https://nuxt.com) and Vue 3.

## 🚀 Features

- **Nuxt 4** - Latest version with SSR support
- **Vue 3** - Modern reactive framework
- **File-based routing** - Automatic route generation from pages directory
- **Auto-import components** - Components are automatically imported
- **TypeScript ready** - Full TypeScript support
- **Hot Module Replacement** - Fast development experience
- **SEO optimized** - Built-in head management

## 📋 Prerequisites

- Node.js 18+ 
- npm, pnpm, yarn, or bun

## 🛠️ Installation

```bash
# Install dependencies
npm install

# Or using other package managers
pnpm install
yarn install
bun install
```

## 📝 Environment Setup

Create a `.env.local` file based on `.env.example`:

```bash
cp .env.example .env.local
```

Configure your environment variables:
```
NUXT_PUBLIC_API_BASE_URL=http://localhost:8000
NUXT_PUBLIC_APP_NAME=Nuxt App
```

## 🏃 Running the Application

### Development Server

```bash
npm run dev
```

The application will be available at `http://localhost:3000`

### Build for Production

```bash
npm run build
npm run preview
```

### Generate Static Site

```bash
npm run generate
```

## 📁 Project Structure

```
front/
├── app/
│   ├── pages/          # Routes (index.vue = home)
│   ├── components/     # Reusable Vue components
│   ├── assets/         # Static assets (CSS, images)
│   │   └── css/        # Global stylesheets
│   └── app.vue         # Root component
├── public/             # Static files served directly
├── nuxt.config.ts      # Nuxt configuration
├── tsconfig.json       # TypeScript configuration
├── package.json        # Dependencies
└── .env.example        # Environment variables template
```

## 🎨 Available Pages

- `/` - Home page with navigation
- `/about` - About page
- `/contact` - Contact form page

## 🧩 Creating New Pages

Create a new file in `app/pages/`:

```vue
<!-- app/pages/my-page.vue -->
<template>
  <div>
    <h1>My Page</h1>
    <p>Page content here</p>
  </div>
</template>

<script setup>
definePageMeta({
  title: 'My Page'
})
</script>
```

## 🎯 Creating New Components

Create a new file in `app/components/`:

```vue
<!-- app/components/MyComponent.vue -->
<template>
  <div>
    <h2>{{ title }}</h2>
    <slot />
  </div>
</template>

<script setup>
defineProps({
  title: String
})
</script>
```

## 🔗 API Integration

The application is configured to connect to the Laravel backend at `http://localhost:8000`.

To use fetch in components:

```javascript
const { data } = await useFetch('/api/endpoint', {
  baseURL: useRuntimeConfig().public.apiBaseUrl
})
```

## 🎓 Useful Links

- [Nuxt Documentation](https://nuxt.com/docs)
- [Vue 3 Documentation](https://vuejs.org)
- [Nuxt UI Components](https://ui.nuxt.com)

## 📦 Dependencies

- `nuxt` - Framework
- `vue` - Core library
- `vue-router` - Routing

## 🤝 Contributing

Feel free to submit issues and enhancement requests!

## 📄 License

This project is open source.


