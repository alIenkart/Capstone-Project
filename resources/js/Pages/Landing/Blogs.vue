<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import LandingIndex from './LandingIndex.vue'

defineOptions({ layout: LandingIndex })

// Slider refs
const sliderRef = ref(null)
const isPaused = ref(false)

// Pagination for blog posts
const visiblePostsCount = ref(4)
const postsPerLoad = 4

// Background images for sliders
const backgroundImages = [
    '/storage/travel-blogs/travel-slider/Slider1.jpg',
    '/storage/travel-blogs/travel-slider/Slider2.jpg',
    '/storage/travel-blogs/travel-slider/Slider3.jpg',
    '/storage/travel-blogs/travel-slider/Slider4.jpg',
    '/storage/travel-blogs/travel-slider/Slider5.jpg',
    '/storage/travel-blogs/travel-slider/Slider6.jpg'
]

// Infinite loop images
const infiniteImages = [...backgroundImages, ...backgroundImages, ...backgroundImages]

// Pause/Resume functions
const handleMouseEnter = () => {
    isPaused.value = true
    if (sliderRef.value) sliderRef.value.style.animationPlayState = 'paused'
}

const handleMouseLeave = () => {
    isPaused.value = false
    if (sliderRef.value) sliderRef.value.style.animationPlayState = 'running'
}

const blogPosts = [
    {
        id: 1,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog1.jpg", // ← local image
        category: "Nature",
        date: "2024-01-15"
    },
    {
        id: 2,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog2.jpg", // ← local image
        category: "Nature",
        date: "2024-01-12"
    },
    {
        id: 3,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg", // ← local image
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 4,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg", // ← local image
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 5,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg", // ← local image
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 6,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg", // ← local image
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 7,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg", // ← local image
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 8,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg", // ← local image
        category: "Nature",
        date: "2024-01-10"
    },
]

// Computed properties
const visiblePosts = computed(() => blogPosts.slice(0, visiblePostsCount.value))
const hasMorePosts = computed(() => visiblePostsCount.value < blogPosts.length)
const loadMorePosts = () => visiblePostsCount.value += postsPerLoad

// Testimonials data
const testimonials = ref([
    { name: "Lydon C.", rating: 5, comment: "Amazing experience! Everything was well-organized and smooth." },
    { name: "Kurt Allen E.", rating: 4, comment: "Great trip overall. I loved the scenery and activities!" }
])

// New testimonial
const newTestimonial = ref({
    name: "",
    rating: 0,
    comment: ""
})

// Submit testimonial
const submitTestimonial = () => {
    if (!newTestimonial.value.name || !newTestimonial.value.comment || newTestimonial.value.rating === 0) {
        alert("Please complete all fields before submitting.")
        return
    }

    testimonials.value.push({
        name: newTestimonial.value.name,
        rating: newTestimonial.value.rating,
        comment: newTestimonial.value.comment
    })

    newTestimonial.value = { name: "", rating: 0, comment: "" }
    alert("Thank you for your feedback!")
}
</script>

<template>
    <div class="min-h-screen bg-white">
        <!-- Hero Section -->
        <section class="relative h-[60vh] min-h-[400px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat bg-fixed"
                style="background-image: url('/storage/travel-blogs/Header.jpg'); background-size: 100% 100%;">
                <div class="absolute inset-0 z-[1]"></div>
            </div>
            <div class="relative z-[2] text-center">
                <h1 class="text-7xl md:text-8xl font-bold text-white m-0"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); letter-spacing: -1px;">
                    Travel and Explore
                </h1>
            </div>
        </section>

        <!-- First Slider -->
        <section class="mt-12 py-2.5 overflow-hidden" @mouseenter="handleMouseEnter" @mouseleave="handleMouseLeave">
            <div class="relative w-full h-[30vh] min-h-[200px] overflow-hidden">
                <div class="slider-track flex gap-5 h-full w-fit" ref="sliderRef">
                    <div v-for="(image, index) in infiniteImages" :key="index"
                        class="flex-none w-[400px] h-full bg-cover bg-center bg-no-repeat rounded-lg shadow-md transition-transform duration-300 cursor-pointer hover:scale-105"
                        :style="{ backgroundImage: `url(${image})` }"></div>
                </div>
            </div>
        </section>

        <!-- Blog Grid Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-5">
                <h2 class="text-3xl font-bold text-gray-800 mb-4 text-center">Blogs</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-7 mt-10">
                    <div v-for="post in visiblePosts" :key="post.id"
                        class="bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl">
                        <div class="relative h-[250px] overflow-hidden">
                            <img :src="post.image" :alt="post.title"
                                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
                            <div class="absolute top-4 left-4 z-[2]">
                                <span
                                    class="bg-blue-500/90 text-white px-3 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wide">
                                    {{ post.category }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 leading-tight">{{ post.title }}</h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">{{ post.description }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400 text-xs font-medium">{{ post.date }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="hasMorePosts" class="flex justify-center mt-12">
                    <button @click="loadMorePosts"
                        class="px-8 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        Load More
                    </button>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-20 bg-gray-50 border-t border-gray-200">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Traveler Testimonials</h2>

                <!-- Display Testimonials -->
                <div class="space-y-6 mb-10">
                    <div v-for="(testimonial, index) in testimonials" :key="index"
                        class="bg-white p-6 rounded-2xl shadow-md text-left">
                        <div class="flex items-start mb-3">
                            <!-- Profile icon -->
                            <div class="flex-shrink-0 mr-3 mt-1">
                                <!-- Simple user SVG icon -->
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="8" r="4" />
                                    <path d="M4 20c0-4 4-6 8-6s8 2 8 6" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <!-- Name -->
                                <h4 class="text-lg font-semibold text-gray-800">{{ testimonial.name }}</h4>
                                <!-- Date/time under the name, in small, muted text -->
                                <div class="text-xs text-gray-500 mb-1">March 2, 2025 at 1:15 pm</div>
                                <!-- Rating, right under the name with a small gap -->
                            </div>
                        </div>
                        <div class="flex text-yellow-400 mt-1 mb-1">
                            <span v-for="n in 5" :key="n">
                                <i v-if="n <= testimonial.rating" class="fas fa-star"></i>
                                <i v-else class="far fa-star text-gray-300"></i>
                            </span>
                        </div>
                        <p class="text-gray-600 italic">"{{ testimonial.comment }}"</p>
                    </div>
                </div>

                <!-- Add Testimonial Form -->
                <div class="bg-white p-8 rounded-2xl shadow-xl text-left">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">Share Your Experience</h3>
                    <p class="text-gray-600 mb-6">
                        We’d love to hear how your trip went! Share your thoughts, suggestions, or anything that stood
                        out.
                        Your feedback helps us improve and provide better service for future travelers.
                    </p>
                    <hr class="my-6 border-t border-gray-200" />

                    <!-- Name -->
                    <label class="block text-gray-700 font-medium mb-1" for="testimonial-name">Your Name</label>
                    <input v-model="newTestimonial.name" id="testimonial-name" type="text"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all"
                        placeholder="Enter your name" />

                    <!-- Rating -->
                    <label class="block text-gray-700 font-medium mb-1">Your Rating</label>
                    <div class="flex mb-4">
                        <template v-for="star in 5" :key="star">
                            <i class="fa-star fa-2x transition-all duration-150" :class="[
                                star <= newTestimonial.rating ? 'fas text-yellow-400' : 'far text-gray-300',
                                'mr-2 cursor-pointer hover:scale-125',
                            ]" aria-hidden="true" @click="newTestimonial.rating = star"
                                @keydown.enter="newTestimonial.rating = star" tabindex="0" role="button"></i>
                        </template>
                    </div>

                    <!-- Comment -->
                    <label class="block text-gray-700 font-medium mb-1" for="testimonial-comment">Your Comment</label>
                    <textarea v-model="newTestimonial.comment" id="testimonial-comment" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all"
                        placeholder="Share your thoughts..."></textarea>

                    <button @click="submitTestimonial"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg transition-all shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        Submit Feedback
                    </button>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
@keyframes scroll {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-33.333%);
    }
}

@keyframes scrollReverse {
    0% {
        transform: translateX(-33.333%);
    }

    100% {
        transform: translateX(0);
    }
}

.slider-track {
    animation: scroll 30s linear infinite;
}

.slider-track-reverse {
    animation: scrollReverse 30s linear infinite;
    animation-delay: 1s;
}

/* Responsive adjustments */
@media (max-width: 768px) {

    .slider-track,
    .slider-track-reverse {
        animation-duration: 25s;
    }
}

@media (max-width: 480px) {

    .slider-track,
    .slider-track-reverse {
        animation-duration: 20s;
    }
}
</style>

<!-- Add this in your main HTML head -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
