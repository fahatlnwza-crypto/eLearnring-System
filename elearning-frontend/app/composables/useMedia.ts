export const useMedia = () => {
  const config = useRuntimeConfig()
  const { getToken } = useAuth()

  // Get all media
  const getMedia = async (page = 1, search = '') => {
    try {
      const token = getToken()
      let url = `${config.public.apiBaseUrl}/api/media?page=${page}`
      if (search) {
        url += `&search=${encodeURIComponent(search)}`
      }
      const response = await $fetch(url, {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
        },
      })
      return response
    } catch (error) {
      console.error('Error fetching media:', error)
      throw error
    }
  }

  // Get media by ID
  const getMediaById = async (id: string) => {
    try {
      const token = getToken()
      const response = await $fetch(`${config.public.apiBaseUrl}/api/media/${id}`, {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
        },
      })
      return response
    } catch (error) {
      console.error('Error fetching media by ID:', error)
      throw error
    }
  }

  // Upload media
  const uploadMedia = async (formData: FormData) => {
    try {
      const token = getToken()
      console.log('Token:', token ? 'exists' : 'missing')
      console.log('API URL:', `${config.public.apiBaseUrl}/api/media`)
      
      const response = await $fetch(`${config.public.apiBaseUrl}/api/media`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
        },
        body: formData,
      })
      return response
    } catch (error) {
      console.error('Error uploading media:', error)
      throw error
    }
  }

  // Upload media with progress tracking
  const uploadMediaWithProgress = async (
    formData: FormData, 
    onProgress?: (progress: number, loaded: number, total: number) => void
  ) => {
    return new Promise((resolve, reject) => {
      const token = getToken()
      const xhr = new XMLHttpRequest()

      // Track upload progress
      xhr.upload.addEventListener('progress', (e) => {
        if (e.lengthComputable && onProgress) {
          const percentComplete = Math.round((e.loaded / e.total) * 100)
          onProgress(percentComplete, e.loaded, e.total)
        }
      })

      // Handle completion
      xhr.addEventListener('load', () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          try {
            const response = JSON.parse(xhr.responseText)
            resolve(response)
          } catch (e) {
            reject(new Error('Invalid JSON response'))
          }
        } else {
          try {
            const errorData = JSON.parse(xhr.responseText)
            reject({ data: errorData, status: xhr.status })
          } catch (e) {
            reject(new Error(`Upload failed with status ${xhr.status}`))
          }
        }
      })

      // Handle errors
      xhr.addEventListener('error', () => {
        reject(new Error('การอัปโหลดล้มเหลว กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต'))
      })

      xhr.addEventListener('abort', () => {
        reject(new Error('การอัปโหลดถูกยกเลิก'))
      })

      // Open and send request
      xhr.open('POST', `${config.public.apiBaseUrl}/api/media`)
      xhr.setRequestHeader('Authorization', `Bearer ${token}`)
      xhr.send(formData)
    })
  }

  // Update media
  const updateMedia = async (id: string, formData: FormData) => {
    try {
      const token = getToken()
      // Use POST with _method=PUT for file uploads
      formData.append('_method', 'PUT')
      const response = await $fetch(`${config.public.apiBaseUrl}/api/media/${id}`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
        },
        body: formData,
      })
      return response
    } catch (error) {
      console.error('Error updating media:', error)
      throw error
    }
  }

  // Delete media
  const deleteMedia = async (id: string) => {
    try {
      const token = getToken()
      const response = await $fetch(`${config.public.apiBaseUrl}/api/media/${id}`, {
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
        },
      })
      return response
    } catch (error) {
      console.error('Error deleting media:', error)
      throw error
    }
  }

  // Get media by category
  const getMediaByCategory = async (category: string) => {
    try {
      const token = getToken()
      const response = await $fetch(`${config.public.apiBaseUrl}/api/media/category/${category}`, {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
        },
      })
      return response
    } catch (error) {
      console.error('Error fetching media by category:', error)
      throw error
    }
  }

  // Get media by type
  const getMediaByType = async (type: string) => {
    try {
      const token = getToken()
      const response = await $fetch(`${config.public.apiBaseUrl}/api/media/type/${type}`, {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
        },
      })
      return response
    } catch (error) {
      console.error('Error fetching media by type:', error)
      throw error
    }
  }

  // Download media
  const downloadMedia = async (id: string) => {
    try {
      const token = getToken()
      const config = useRuntimeConfig()
      
      // Create a temporary link and trigger download
      const url = `${config.public.apiBaseUrl}/api/media/${id}/download`
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', '')
      
      // Set authorization header by using fetch
      const response = await fetch(url, {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`,
        },
      })
      
      if (!response.ok) {
        throw new Error('Download failed')
      }
      
      // Get filename from Content-Disposition header if available
      const contentDisposition = response.headers.get('Content-Disposition')
      let filename = 'download'
      if (contentDisposition) {
        const filenameMatch = contentDisposition.match(/filename="?(.+)"?/)
        if (filenameMatch) {
          filename = filenameMatch[1]
        }
      }
      
      // Create blob and download
      const blob = await response.blob()
      const blobUrl = window.URL.createObjectURL(blob)
      const a = document.createElement('a')
      a.href = blobUrl
      a.download = filename
      document.body.appendChild(a)
      a.click()
      document.body.removeChild(a)
      window.URL.revokeObjectURL(blobUrl)
      
      return { success: true }
    } catch (error) {
      console.error('Error downloading media:', error)
      throw error
    }
  }

  return {
    getMedia,
    getMediaById,
    uploadMedia,
    uploadMediaWithProgress,
    updateMedia,
    deleteMedia,
    getMediaByCategory,
    getMediaByType,
    downloadMedia,
  }
}
