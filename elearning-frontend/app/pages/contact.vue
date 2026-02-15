<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="max-w-4xl mx-auto px-4 py-12">
      <h1 class="text-5xl font-bold text-primary mb-8">Contact Us</h1>
      
      <form @submit.prevent="handleSubmit" class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="mb-6">
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Name:
          </label>
          <input 
            v-model="form.name" 
            type="text" 
            id="name" 
            required
            class="input-base w-full"
            placeholder="Your name"
          />
        </div>

        <div class="mb-6">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email:
          </label>
          <input 
            v-model="form.email" 
            type="email" 
            id="email" 
            required
            class="input-base w-full"
            placeholder="your@email.com"
          />
        </div>

        <div class="mb-8">
          <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
            Message:
          </label>
          <textarea 
            v-model="form.message" 
            id="message" 
            rows="5" 
            required
            class="input-base w-full resize-none"
            placeholder="Your message here..."
          ></textarea>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">
          Send Message
        </button>
      </form>

      <NuxtLink to="/" class="btn-primary inline-block">
        ← Back to Home
      </NuxtLink>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  title: 'Contact'
})

const form = reactive({
  name: '',
  email: '',
  message: ''
})

const handleSubmit = () => {
  alert(`Thank you, ${form.name}! Your message has been received.`)
  form.name = ''
  form.email = ''
  form.message = ''
}
</script>
