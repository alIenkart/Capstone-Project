<template>
  <div class="image-upload-container">
    <!-- Upload Area -->
    <div 
      class="upload-area"
      :class="{ 'drag-over': isDragOver, 'has-images': images.length > 0 }"
      @click="triggerFileInput"
      @dragover.prevent="isDragOver = true"
      @dragleave.prevent="isDragOver = false"
      @drop.prevent="handleDrop"
    >
      <input
        ref="fileInput"
        type="file"
        multiple
        accept="image/*"
        @change="handleFileSelect"
        class="hidden"
      />
      
      <div v-if="images.length === 0" class="upload-placeholder">
        <svg class="upload-icon" width="48" height="48" viewBox="0 0 24 24" fill="none">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="#008DDA" stroke-width="2" fill="none"/>
          <polyline points="7,10 12,15 17,10" stroke="#008DDA" stroke-width="2" fill="none"/>
          <line x1="12" y1="15" x2="12" y2="3" stroke="#008DDA" stroke-width="2"/>
        </svg>
        <p class="upload-text">Click to upload images or drag and drop</p>
        <p class="upload-subtext">PNG, JPG, GIF up to 10MB each</p>
      </div>
      
      <div v-else class="upload-summary">
        <svg class="upload-icon" width="32" height="32" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke="#008DDA" stroke-width="2" fill="none"/>
          <circle cx="8.5" cy="8.5" r="1.5" stroke="#008DDA" stroke-width="2" fill="none"/>
          <polyline points="21,15 16,10 5,21" stroke="#008DDA" stroke-width="2" fill="none"/>
        </svg>
        <p class="upload-text">{{ images.length }} image(s) selected</p>
        <p class="upload-subtext">Click to add more images</p>
      </div>
    </div>

    <!-- Image Grid -->
    <div v-if="images.length > 0" class="images-grid">
      <div 
        v-for="(image, index) in images" 
        :key="image.id" 
        class="image-item"
      >
        <div class="image-preview">
          <img :src="image.preview" :alt="image.alt || 'Uploaded image'" class="preview-img" />
          <button 
            @click="removeImage(index)" 
            class="remove-btn"
            type="button"
          >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
              <line x1="18" y1="6" x2="6" y2="18" stroke="white" stroke-width="2"/>
              <line x1="6" y1="6" x2="18" y2="18" stroke="white" stroke-width="2"/>
            </svg>
          </button>
        </div>
        
        <div class="image-details">
          <div class="image-info">
            <p class="image-name">{{ image.name }}</p>
            <p class="image-size">{{ formatFileSize(image.size) }}</p>
          </div>
          
          <div class="alt-text-section">
            <label :for="`alt-${image.id}`" class="alt-label">Alt Text (for accessibility)</label>
            <input
              :id="`alt-${image.id}`"
              v-model="image.alt"
              type="text"
              :placeholder="`Describe this image...`"
              class="alt-input"
              @input="updateImageAlt(index, $event.target.value)"
            />
            <p class="alt-help">Describe what's in the image for screen readers</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Upload Progress -->
    <div v-if="isUploading" class="upload-progress">
      <div class="progress-bar">
        <div class="progress-fill" :style="{ width: uploadProgress + '%' }"></div>
      </div>
      <p class="progress-text">Uploading... {{ uploadProgress }}%</p>
    </div>

    <!-- Error Messages -->
    <div v-if="errorMessage" class="error-message">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <circle cx="12" cy="12" r="10" stroke="#ef4444" stroke-width="2" fill="none"/>
        <line x1="15" y1="9" x2="9" y2="15" stroke="#ef4444" stroke-width="2"/>
        <line x1="9" y1="9" x2="15" y2="15" stroke="#ef4444" stroke-width="2"/>
      </svg>
      {{ errorMessage }}
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  maxFiles: {
    type: Number,
    default: 10
  },
  maxFileSize: {
    type: Number,
    default: 10 * 1024 * 1024 // 10MB
  },
  acceptedTypes: {
    type: Array,
    default: () => ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
  },
  autoUpload: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['images-updated', 'upload-complete', 'upload-error'])

const fileInput = ref(null)
const images = ref([])
const isDragOver = ref(false)
const isUploading = ref(false)
const uploadProgress = ref(0)
const errorMessage = ref('')

const triggerFileInput = () => {
  fileInput.value?.click()
}

const handleFileSelect = (event) => {
  const files = Array.from(event.target.files)
  processFiles(files)
  // Clear the input
  event.target.value = ''
}

const handleDrop = (event) => {
  isDragOver.value = false
  const files = Array.from(event.dataTransfer.files)
  processFiles(files)
}

const processFiles = (files) => {
  errorMessage.value = ''
  
  // Filter valid files
  const validFiles = files.filter(file => {
    if (!props.acceptedTypes.includes(file.type)) {
      errorMessage.value = `File ${file.name} is not a supported image type`
      return false
    }
    if (file.size > props.maxFileSize) {
      errorMessage.value = `File ${file.name} is too large. Maximum size is ${formatFileSize(props.maxFileSize)}`
      return false
    }
    return true
  })

  // Check if adding these files would exceed the limit
  const remainingSlots = props.maxFiles - images.value.length
  const filesToAdd = validFiles.slice(0, remainingSlots)
  
  if (validFiles.length > remainingSlots) {
    errorMessage.value = `Only ${remainingSlots} more images can be added`
  }

  // Process each file
  filesToAdd.forEach(file => {
    const reader = new FileReader()
    reader.onload = (e) => {
      const imageData = {
        id: Date.now() + Math.random(),
        file: file,
        preview: e.target.result,
        name: file.name,
        size: file.size,
        alt: '', // Initialize alt text as empty
        type: file.type
      }
      
      images.value.push(imageData)
    }
    reader.readAsDataURL(file)
  })

  emit('images-updated', images.value)
}

const removeImage = (index) => {
  images.value.splice(index, 1)
  emit('images-updated', images.value)
}

const updateImageAlt = (index, altText) => {
  images.value[index].alt = altText
  emit('images-updated', images.value)
}

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const uploadImages = async () => {
  if (images.value.length === 0) return

  isUploading.value = true
  uploadProgress.value = 0

  try {
    const formData = new FormData()
    
    images.value.forEach((image, index) => {
      formData.append(`images[${index}]`, image.file)
      formData.append(`alts[${index}]`, image.alt || '')
    })

    // Simulate upload progress
    const progressInterval = setInterval(() => {
      if (uploadProgress.value < 90) {
        uploadProgress.value += 10
      }
    }, 200)

    // Here you would make the actual API call
    // const response = await fetch('/api/upload-images', {
    //   method: 'POST',
    //   body: formData,
    //   headers: {
    //     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //   }
    // })

    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 2000))
    
    clearInterval(progressInterval)
    uploadProgress.value = 100

    emit('upload-complete', images.value)
    
    // Clear images after successful upload
    setTimeout(() => {
      images.value = []
      isUploading.value = false
      uploadProgress.value = 0
    }, 1000)

  } catch (error) {
    isUploading.value = false
    uploadProgress.value = 0
    errorMessage.value = 'Upload failed. Please try again.'
    emit('upload-error', error)
  }
}

// Watch for auto-upload
watch(images, (newImages) => {
  if (props.autoUpload && newImages.length > 0) {
    uploadImages()
  }
}, { deep: true })

// Expose methods for parent component
defineExpose({
  uploadImages,
  clearImages: () => {
    images.value = []
    emit('images-updated', images.value)
  },
  getImages: () => images.value
})
</script>

<style scoped>
.image-upload-container {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
}

.upload-area {
  border: 2px dashed #008DDA;
  border-radius: 12px;
  padding: 40px 20px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
  background: #fafafa;
  margin-bottom: 20px;
}

.upload-area:hover {
  border-color: #73BE5D;
  background: #f0f9ff;
}

.upload-area.drag-over {
  border-color: #73BE5D;
  background: #f0f9ff;
  transform: scale(1.02);
}

.upload-area.has-images {
  padding: 20px;
  background: #f0f9ff;
  border-color: #73BE5D;
}

.upload-placeholder,
.upload-summary {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}

.upload-icon {
  color: #008DDA;
}

.upload-text {
  font-size: 16px;
  font-weight: 600;
  color: #008DDA;
  margin: 0;
}

.upload-subtext {
  font-size: 14px;
  color: #666;
  margin: 0;
}

.images-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 20px;
}

.image-item {
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  overflow: hidden;
  background: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  transition: transform 0.2s ease;
}

.image-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.image-preview {
  position: relative;
  width: 100%;
  height: 200px;
  overflow: hidden;
}

.preview-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.remove-btn {
  position: absolute;
  top: 8px;
  right: 8px;
  background: rgba(239, 68, 68, 0.9);
  border: none;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s ease;
}

.remove-btn:hover {
  background: rgba(239, 68, 68, 1);
}

.image-details {
  padding: 16px;
}

.image-info {
  margin-bottom: 12px;
}

.image-name {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  margin: 0 0 4px 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.image-size {
  font-size: 12px;
  color: #6b7280;
  margin: 0;
}

.alt-text-section {
  margin-top: 12px;
}

.alt-label {
  display: block;
  font-size: 12px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 6px;
}

.alt-input {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s ease;
  box-sizing: border-box;
}

.alt-input:focus {
  outline: none;
  border-color: #008DDA;
  box-shadow: 0 0 0 3px rgba(0, 141, 218, 0.1);
}

.alt-help {
  font-size: 11px;
  color: #6b7280;
  margin: 4px 0 0 0;
}

.upload-progress {
  margin-top: 20px;
  padding: 16px;
  background: #f0f9ff;
  border-radius: 8px;
  border: 1px solid #008DDA;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #e5e7eb;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 8px;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #008DDA, #73BE5D);
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 14px;
  color: #008DDA;
  margin: 0;
  text-align: center;
}

.error-message {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 16px;
  background: #fef2f2;
  border: 1px solid #fecaca;
  border-radius: 8px;
  color: #dc2626;
  font-size: 14px;
  margin-top: 16px;
}

.hidden {
  display: none;
}

@media (max-width: 768px) {
  .images-grid {
    grid-template-columns: 1fr;
  }
  
  .upload-area {
    padding: 30px 15px;
  }
  
  .upload-text {
    font-size: 14px;
  }
  
  .upload-subtext {
    font-size: 12px;
  }
}
</style>
