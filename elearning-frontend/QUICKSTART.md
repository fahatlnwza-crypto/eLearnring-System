# Nuxt.js Frontend - Quick Start Guide

## Project Overview

Your Nuxt.js frontend project has been successfully created! This is a modern Single Page Application (SPA) / Server-Side Rendered (SSR) application built with:

- **Nuxt 4** - Latest Vue.js meta-framework
- **Vue 3** - Reactive component framework
- **TypeScript** - Type-safe JavaScript

## Project Files Created

### Pages (Routes)
- `app/pages/index.vue` - Home page with navigation
- `app/pages/about.vue` - About page
- `app/pages/contact.vue` - Contact page with form

### Components
- `app/components/Hero.vue` - Reusable header component

### Styling
- `app/assets/css/main.css` - Global styles with utility classes

### Configuration
- `nuxt.config.ts` - Main Nuxt configuration
- `package.json` - Dependencies and scripts
- `.env.example` - Environment variables template

## Starting the Development Server

```bash
cd front
npm run dev
```

The application will be available at: **http://localhost:3000**

## Building for Production

```bash
npm run build
npm run preview
```

## Key Features

✅ File-based routing (pages automatically become routes)
✅ Auto-imported components
✅ Hot Module Replacement (HMR) for instant updates
✅ TypeScript support
✅ Global CSS with utility classes
✅ Environment configuration support
✅ Connected to Laravel backend at http://localhost:8000

## Directory Structure

```
front/
├── app/
│   ├── pages/           # Route pages
│   ├── components/      # Reusable components
│   ├── assets/css/      # Global styles
│   └── app.vue          # Root component
├── public/              # Static assets
├── nuxt.config.ts       # Configuration
├── package.json         # Dependencies
├── tsconfig.json        # TypeScript config
└── .env.example         # Environment template
```

## Next Steps

1. **Install dependencies** (if not done):
   ```bash
   npm install
   ```

2. **Create .env.local**:
   ```bash
   cp .env.example .env.local
   ```

3. **Start the dev server**:
   ```bash
   npm run dev
   ```

4. **Create new pages**:
   Add `.vue` files to `app/pages/` - they automatically become routes!

5. **Create new components**:
   Add `.vue` files to `app/components/` - they're auto-imported!

## Connecting to the Backend

The project is configured to connect to the Laravel backend:

```javascript
// In your components/pages:
const { data } = await useFetch('/api/users', {
  baseURL: useRuntimeConfig().public.apiBaseUrl
})
```

## Useful Commands

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build
- `npm run generate` - Generate static site

## Important Notes

- The backend Laravel API is expected at `http://localhost:8000`
- Update `.env.local` if your backend is on a different URL
- All pages in `app/pages/` automatically become routes
- All components in `app/components/` are auto-imported

## Resources

- [Nuxt.js Official Docs](https://nuxt.com)
- [Vue 3 Documentation](https://vuejs.org)
- [Nuxt Guides](https://nuxt.com/docs/guide)

---

**Happy coding!** 🚀
