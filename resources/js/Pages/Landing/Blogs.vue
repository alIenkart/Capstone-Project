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
        <section class="py-20 bg-gradient-to-br from-gray-50 to-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-5">
                <h2 class="text-4xl font-bold text-gray-800 mb-2 text-center">Traveler Reviews & Feedback</h2>
                <p class="text-gray-600 text-center mb-12">See what our travelers have to say about their experiences
                </p>

                <div v-if="filteredReviews.length > 0"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div v-for="review in filteredReviews" :key="review.id"
                        class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 transition-all duration-300 hover:shadow-xl"
                        :class="review.is_public ? 'border-green-500' : 'border-yellow-500'">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3 border-2 border-gray-200">
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900">{{ review.name }}</p>
                                        <p class="text-sm text-gray-500">{{ review.date }}</p>
                                    </div>
                                </div>

                                <!-- Stars -->
                                <div class="flex items-center space-x-1">
                                    <template v-for="n in 5" :key="review.id + '-star-' + n">
                                        <svg class="w-5 h-5"
                                            :class="n <= review.rating ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                                            fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 18.25l-6.18 3.57L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    </template>
                                </div>
                            </div>

                            <blockquote
                                class="text-gray-700 italic border-l-4 border-gray-200 pl-4 mb-4 text-sm line-clamp-3">
                                "{{ review.comment }}"
                            </blockquote>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="py-12 text-center bg-white rounded-2xl shadow-lg mb-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No Reviews Found</h3>
                    <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                </div>

                <!-- Add Review Form -->
                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Share Your Experience</h3>
                    <p class="text-gray-600 mb-6">
                        We'd love to hear how your trip went! Share your thoughts, suggestions, or anything that stood
                        out. Your
                        feedback helps us improve and provide better service for future travelers.
                    </p>

                    <div class="border-t border-gray-200 pt-6">
                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-3">Your Rating</label>
                            <div class="flex gap-3">
                                <template v-for="star in 5" :key="star">
                                    <button @click="newTestimonial.rating = star"
                                        class="transition-all duration-150 hover:scale-125">
                                        <svg class="w-8 h-8"
                                            :class="star <= newTestimonial.rating ? 'text-yellow-400 fill-current cursor-pointer' : 'text-gray-300 cursor-pointer'"
                                            fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 18.25l-6.18 3.57L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Your Comment</label>
                            <textarea v-model="newTestimonial.comment" rows="4" placeholder="Share your thoughts..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none" />
                        </div>

                        <button @click="submitTestimonial"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg transition-all shadow-md hover:shadow-lg">
                            Submit Feedback
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { api } from '../../api/api'
import LandingIndex from './LandingIndex.vue'
import { useToast } from 'vue-toastification'

defineOptions({ layout: LandingIndex })

// Slider refs
const page = usePage();
const toast = useToast()
const isSubmitting = ref(false)
const sliderRef = ref(null)
const isPaused = ref(false)
const service = new api();
const feedback = ref()
const users = ref()

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
        image: "/storage/travel-blogs/blogs/Blog1.jpg",
        category: "Nature",
        date: "2024-01-15"
    },
    {
        id: 2,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog2.jpg",
        category: "Nature",
        date: "2024-01-12"
    },
    {
        id: 3,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg",
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 4,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg",
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 5,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg",
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 6,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg",
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 7,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg",
        category: "Nature",
        date: "2024-01-10"
    },
    {
        id: 8,
        title: "Lorem ipsum dolor sit amet",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        image: "/storage/travel-blogs/blogs/Blog3.jpg",
        category: "Nature",
        date: "2024-01-10"
    },
]

// Computed properties
const visiblePosts = computed(() => blogPosts.slice(0, visiblePostsCount.value))
const hasMorePosts = computed(() => visiblePostsCount.value < blogPosts.length)
const loadMorePosts = () => visiblePostsCount.value += postsPerLoad

// Testimonials filters
const searchQuery = ref('')
const selectedRating = ref('')
const selectedStatus = ref('')

// Testimonials data with enhanced properties
const testimonials = ref([]);

const loadTestimonials = async () => {
    try {
        const responseFeedbacks = await service.getFeedbacks();
        const responseGetAllUsers = await service.getUsers();

        feedback.value = responseFeedbacks.data;
        users.value = responseGetAllUsers.data.data;

        if (Array.isArray(feedback.value)) {
            const apiTestimonials = feedback.value.map(item => {
                const user = users.value.find(u => u.id === item.user_id);

                return {
                    id: item.id,
                    name: user ? `${user.first_name} ${user.last_name ? user.last_name.charAt(0).toUpperCase() + '.' : ''}` : 'Anonymous Traveler',
                    rating: item.rate || 0,
                    comment: item.message || 'No comment provided.',
                    date: item.created_at
                        ? new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
                        : 'Recently',
                    is_public: item.visibility === 'public'
                }
            })

            testimonials.value = [...apiTestimonials];
        } else {
            testimonials.value = [];
        }
    } catch (error) {
        console.error("Error loading testimonials:", error);
    }
}


// Filtered reviews computed property
const filteredReviews = computed(() => {
    let reviews = testimonials.value
        .filter(t => t.is_public !== false)
        .map((t, index) => ({
            id: index,
            name: t.name,
            date: t.date || 'Recently',
            rating: t.rating,
            comment: t.comment,
            is_public: t.is_public !== false
        }))

    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        reviews = reviews.filter(r =>
            r.name.toLowerCase().includes(query) ||
            r.comment.toLowerCase().includes(query)
        )
    }

    // Filter by rating
    if (selectedRating.value) {
        const minRating = parseInt(selectedRating.value)
        reviews = reviews.filter(r => r.rating >= minRating)
    }

    // Filter by status
    if (selectedStatus.value) {
        const isPublic = selectedStatus.value === 'public'
        reviews = reviews.filter(r => r.is_public === isPublic)
    }

    console.log("🚀 ~ reviews:", reviews)
    return reviews
})

// Average rating computed property
const averageRating = computed(() => {
    if (filteredReviews.value.length === 0) return 0
    const totalRating = filteredReviews.value.reduce((sum, r) => sum + r.rating, 0)
    return (totalRating / filteredReviews.value.length).toFixed(1)
})

// New testimonial
const newTestimonial = ref({
    user_id: page.props?.auth?.user?.id,
    rating: 0,
    comment: ""
})

// Submit testimonial
const submitTestimonial = async () => {
    if (
        !newTestimonial.value.user_id ||
        !newTestimonial.value.comment ||
        newTestimonial.value.rating === 0
    ) {
        toast.warning("Please complete all fields before submitting.")
        return
    }

    isSubmitting.value = true

    try {
        const testimonialData = {
            user_id: newTestimonial.value.user_id,
            rate: newTestimonial.value.rating,
            message: newTestimonial.value.comment,
            visibility: false
        }

        const response = await fetch('/api/feedbacks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(testimonialData)
        })

        if (!response.ok) {
            const err = await response.json()
            console.error("Server error:", err)
            throw new Error(err.message || 'Failed to submit testimonial')
        }

        const result = await response.json()

        // Add the new testimonial locally
        testimonials.value.unshift({
            id: result.data.id,
            name: page.props?.auth?.user?.name || 'Anonymous Traveler',
            rating: testimonialData.rate,
            comment: testimonialData.message,
            date: new Date().toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            })
        })

        // Reset form
        newTestimonial.value = {
            user_id: page.props?.auth?.user?.id,
            rating: 0,
            comment: ""
        }

        toast.success("Thank you for your feedback!")
    } catch (error) {
        console.error('Error submitting testimonial:', error)
        toast.error("There was an error submitting your feedback. Please try again.")
    } finally {
        isSubmitting.value = false
    }
}

onMounted(() => {
    loadTestimonials()
})
</script>

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

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
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