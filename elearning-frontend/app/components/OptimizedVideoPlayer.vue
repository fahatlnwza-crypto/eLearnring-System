<template>
  <div class="optimized-video-player">
    <!-- Loading Overlay -->
    <div v-if="isBuffering" class="video-loading-overlay">
      <div class="loading-spinner"></div>
      <p class="loading-text">กำลังโหลด{{ loadingProgress > 0 ? ` ${loadingProgress}%` : '...' }}</p>
    </div>

    <!-- Video Player -->
    <video
      ref="videoPlayer"
      :src="currentVideoUrl"
      @loadstart="onLoadStart"
      @loadedmetadata="onLoadedMetadata"
      @progress="onProgress"
      @canplay="onCanPlay"
      @waiting="onWaiting"
      @playing="onPlaying"
      @error="onError"
      controls
      controlsList="nodownload"
      preload="metadata"
      playsinline
      crossorigin="anonymous"
      class="w-full rounded-2xl shadow-2xl"
      :class="{ 'video-loading': isBuffering }"
    >
      เบราว์เซอร์ของคุณไม่รองรับการเล่นวิดีโอ
    </video>

    <!-- Quality Selector -->
    <div v-if="availableQualities.length > 1" class="quality-selector">
      <button
        v-for="quality in availableQualities"
        :key="quality.label"
        @click="changeQuality(quality)"
        :class="{ active: currentQuality === quality.label }"
        class="quality-btn"
      >
        {{ quality.label }}
      </button>
    </div>

    <!-- Error Message -->
    <div v-if="error" class="video-error">
      <p class="text-red-600 font-medium">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  fileUrl: {
    type: String,
    required: true
  },
  qualities: {
    type: Array,
    default: () => []
  }
})

const videoPlayer = ref(null)
const isBuffering = ref(true)
const loadingProgress = ref(0)
const currentQuality = ref('Auto')
const error = ref(null)
const currentTime = ref(0)
const isPlaying = ref(false)

// Available qualities (default to original if no qualities provided)
const availableQualities = computed(() => {
  if (props.qualities && props.qualities.length > 0) {
    return [
      { label: 'Auto', url: props.fileUrl },
      ...props.qualities
    ]
  }
  return [
    { label: 'Original', url: props.fileUrl }
  ]
})

// Current video URL based on selected quality
const currentVideoUrl = computed(() => {
  const selected = availableQualities.value.find(q => q.label === currentQuality.value)
  return selected ? selected.url : props.fileUrl
})

// Event handlers
const onLoadStart = () => {
  console.log('🎬 Video load started')
  isBuffering.value = true
  error.value = null
}

const onLoadedMetadata = () => {
  console.log('📊 Video metadata loaded')
  loadingProgress.value = 10
}

const onProgress = (event) => {
  if (videoPlayer.value && videoPlayer.value.duration) {
    const buffered = videoPlayer.value.buffered
    if (buffered.length > 0) {
      const bufferedEnd = buffered.end(buffered.length - 1)
      const duration = videoPlayer.value.duration
      loadingProgress.value = Math.round((bufferedEnd / duration) * 100)
      console.log(`📦 Buffer progress: ${loadingProgress.value}%`)
    }
  }
}

const onCanPlay = () => {
  console.log('✅ Video can play')
  isBuffering.value = false
  
  // Resume playback if it was playing before quality change
  if (isPlaying.value && currentTime.value > 0) {
    videoPlayer.value.currentTime = currentTime.value
    videoPlayer.value.play()
  }
}

const onWaiting = () => {
  console.log('⏳ Video waiting (buffering)')
  isBuffering.value = true
}

const onPlaying = () => {
  console.log('▶️ Video playing')
  isBuffering.value = false
  isPlaying.value = true
}

const onError = (event) => {
  console.error('❌ Video error:', event)
  error.value = 'ไม่สามารถโหลดวิดีโอได้ กรุณาลองใหม่อีกครั้ง'
  isBuffering.value = false
}

// Change video quality
const changeQuality = (quality) => {
  if (quality.label === currentQuality.value) return
  
  console.log(`🎯 Changing quality to: ${quality.label}`)
  
  // Save current playback state
  if (videoPlayer.value) {
    currentTime.value = videoPlayer.value.currentTime
    isPlaying.value = !videoPlayer.value.paused
  }
  
  // Change quality
  currentQuality.value = quality.label
  isBuffering.value = true
}

// Watch for quality changes
watch(currentVideoUrl, (newUrl) => {
  console.log('🔄 Video URL changed:', newUrl)
  if (videoPlayer.value && currentTime.value > 0) {
    // Video element will reload with new URL
    videoPlayer.value.load()
  }
})

onMounted(() => {
  console.log('🎥 Video player mounted')
})

onUnmounted(() => {
  console.log('👋 Video player unmounted')
})
</script>

<style scoped>
.optimized-video-player {
  position: relative;
  width: 100%;
}

.video-loading {
  opacity: 0.6;
  pointer-events: none;
}

.video-loading-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
  text-align: center;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 10px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.loading-text {
  color: white;
  font-weight: 600;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
  font-size: 0.9rem;
}

.quality-selector {
  display: flex;
  gap: 8px;
  margin-top: 12px;
  flex-wrap: wrap;
}

.quality-btn {
  padding: 8px 16px;
  background: rgba(255, 255, 255, 0.1);
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 8px;
  color: white;
  font-weight: 600;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
}

.quality-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  border-color: rgba(255, 255, 255, 0.5);
  transform: translateY(-2px);
}

.quality-btn.active {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-color: #667eea;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.video-error {
  margin-top: 12px;
  padding: 12px;
  background: rgba(239, 68, 68, 0.1);
  border: 2px solid rgba(239, 68, 68, 0.3);
  border-radius: 8px;
}

video {
  background: #000;
}
</style>
