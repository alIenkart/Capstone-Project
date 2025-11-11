<template>
  <div class="min-h-screen bg-white">
    <section
      class="relative h-[60vh] min-h-[400px] flex items-center justify-center overflow-hidden"
    >
      <div
        class="absolute inset-0 bg-cover bg-center bg-no-repeat bg-fixed"
        style="
          background-image: url('/storage/travel-blogs/Header.jpg');
          background-size: 100% 100%;
        "
      >
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/60 via-slate-800/60 to-slate-900/60 z-[1]"></div>
      </div>
      <div class="relative z-[2] text-center">
        <h1
          class="text-7xl md:text-8xl font-bold text-white m-0"
          style="
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            letter-spacing: -1px;
          "
        >
          Travel and <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">Explore</span>
        </h1>
      </div>
    </section>

    <section
      class="mt-12 py-2.5 overflow-hidden"
      @mouseenter="handleMouseEnter"
      @mouseleave="handleMouseLeave"
    >
      <div class="relative w-full h-[30vh] min-h-[200px] overflow-hidden">
        <div class="slider-track flex gap-5 h-full w-fit" ref="sliderRef">
          <div
            v-for="(image, index) in infiniteImages"
            :key="index"
            class="flex-none w-[400px] h-full bg-cover bg-center bg-no-repeat rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer hover:scale-105 group"
            :style="{ backgroundImage: `url(${image})` }"
          >
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300 rounded-2xl"></div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-5">
        <div class="mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-2">Latest Stories</h2>
          <p class="text-gray-600">Inspiring tales from travelers around the globe</p>
        </div>
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-7 mt-10"
        >
          <div
            v-for="post in visiblePosts"
            :key="post.id"
            class="group bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-300 cursor-pointer hover:-translate-y-2 hover:shadow-2xl border border-gray-100"
          >
            <div class="relative h-[250px] overflow-hidden bg-gray-200">
              <img
                v-if="post.image"
                :src="post.image"
                alt="Thumbnail"
                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
              />
            </div>
            <div class="p-6">
              <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-gray-700 text-sm leading-relaxed font-bold">
                  {{ post.destination }}
                </p>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-3 leading-tight group-hover:text-blue-600 transition-colors">
                {{ post.title }}
              </h3>
              <p class="text-gray-600 text-sm leading-relaxed mb-4">
                {{ post.excerpt }}
              </p>
              <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <span class="text-gray-500 text-xs font-medium"
                  >Author: {{ post.author }}</span
                >
                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <div v-if="hasMorePosts" class="flex justify-center mt-12">
          <button
            @click="loadMorePosts"
            class="group px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-full shadow-md hover:shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-105 flex items-center gap-2"
          >
            Load More
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </section>

    <section
      class="py-20 bg-gradient-to-br from-gray-50 via-white to-blue-50 border-t border-gray-200"
    >
      <div class="max-w-7xl mx-auto px-5">
        <div class="mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-2">
            Traveler Reviews & Feedback
          </h2>
          <p class="text-gray-600">
            See what our travelers have to say about their experiences
          </p>
        </div>

        <div
          v-if="filteredReviews.length > 0"
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12"
        >
          <div
            v-for="review in filteredReviews"
            :key="review.id"
            class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 transition-all duration-300 hover:shadow-xl group"
            :class="review.is_public ? 'border-green-500' : 'border-yellow-500'"
          >
            <div class="p-6">
              <div class="flex justify-between items-start mb-4">
                <div class="flex items-center">
                  <div
                    class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mr-3 border-2 border-gray-200 font-bold text-blue-600"
                  >
                    {{ review.name.charAt(0) }}
                  </div>
                  <div>
                    <p class="text-lg font-semibold text-gray-900">
                      {{ review.name }}
                    </p>
                    <p class="text-sm text-gray-500">{{ review.date }}</p>
                  </div>
                </div>

                <div class="flex items-center space-x-1">
                  <template v-for="n in 5" :key="review.id + '-star-' + n">
                    <svg
                      class="w-5 h-5"
                      :class="
                        n <= review.rating
                          ? 'text-yellow-400 fill-current'
                          : 'text-gray-300'
                      "
                      fill="currentColor"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 18.25l-6.18 3.57L7 14.14 2 9.27l6.91-1.01L12 2z"
                      />
                    </svg>
                  </template>
                </div>
              </div>

              <blockquote
                class="text-gray-700 italic border-l-4 border-blue-300 pl-4 mb-4 text-sm line-clamp-3"
              >
                "{{ review.comment }}"
              </blockquote>
            </div>
          </div>
        </div>

        <div
          v-else
          class="py-12 text-center bg-white rounded-2xl shadow-lg mb-12 border border-gray-100"
        >
          <svg
            class="w-16 h-16 mx-auto text-gray-300 mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
            />
          </svg>
          <h3 class="text-lg font-semibold text-gray-700 mb-2">
            No Reviews Found
          </h3>
          <p class="text-gray-500">
            Try adjusting your search or filter criteria.
          </p>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 p-8 md:p-12 rounded-3xl shadow-lg border border-gray-200">
          <h3 class="text-3xl font-bold text-gray-900 mb-2">
            Share Your Experience
          </h3>
          <p class="text-gray-600 mb-8">
            We'd love to hear how your trip went! Share your thoughts,
            suggestions, or anything that stood out. Your feedback helps us
            improve and provide better service for future travelers.
          </p>

          <div class="border-t border-gray-200 pt-6">
            <div class="mb-6">
              <label class="block text-gray-900 font-semibold mb-4"
                >Your Rating</label
              >
              <div class="flex gap-3">
                <template v-for="star in 5" :key="star">
                  <button
                    @click="newTestimonial.rating = star"
                    class="transition-all duration-150 hover:scale-125"
                  >
                    <svg
                      class="w-8 h-8"
                      :class="
                        star <= newTestimonial.rating
                          ? 'text-yellow-400 fill-current cursor-pointer'
                          : 'text-gray-300 cursor-pointer hover:text-yellow-300'
                      "
                      fill="currentColor"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 18.25l-6.18 3.57L7 14.14 2 9.27l6.91-1.01L12 2z"
                      />
                    </svg>
                  </button>
                </template>
              </div>
            </div>

            <div class="mb-6">
              <label class="block text-gray-900 font-semibold mb-3"
                >Your Comment</label
              >
              <textarea
                v-model="newTestimonial.comment"
                rows="4"
                placeholder="Share your thoughts..."
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none shadow-sm"
              />
            </div>

            <button
              @click="submitTestimonial"
              class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 group"
            >
              <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8m0 8l6.946-2.975M12 5.568l-6.946 2.974" />
              </svg>
              Submit Feedback
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>
  <Footer></Footer>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { api } from "../../api/api";
import LandingIndex from "./LandingIndex.vue";
import { useToast } from "vue-toastification";
import Footer from "./Footer.vue";

defineOptions({ layout: LandingIndex });

const page = usePage();
const toast = useToast();
const isSubmitting = ref(false);
const sliderRef = ref(null);
const isPaused = ref(false);
const service = new api();
const feedback = ref();
const users = ref();
const visiblePostsCount = ref(4);
const postsPerLoad = 4;
const backgroundImages = [
  "/storage/travel-blogs/travel-slider/Slider1.jpg",
  "/storage/travel-blogs/travel-slider/Slider2.jpg",
  "/storage/travel-blogs/travel-slider/Slider3.jpg",
  "/storage/travel-blogs/travel-slider/Slider4.jpg",
  "/storage/travel-blogs/travel-slider/Slider5.jpg",
  "/storage/travel-blogs/travel-slider/Slider6.jpg",
];
const infiniteImages = [
  ...backgroundImages,
  ...backgroundImages,
  ...backgroundImages,
];
const handleMouseEnter = () => {
  isPaused.value = true;
  if (sliderRef.value) sliderRef.value.style.animationPlayState = "paused";
};
const handleMouseLeave = () => {
  isPaused.value = false;
  if (sliderRef.value) sliderRef.value.style.animationPlayState = "running";
};
const blogPosts = ref([]);
const visiblePosts = computed(() =>
  blogPosts.value.slice(0, visiblePostsCount.value)
);
const hasMorePosts = computed(
  () => visiblePostsCount.value < blogPosts.value.length
);
const loadMorePosts = () => {
  visiblePostsCount.value += postsPerLoad;
};
const testimonials = ref([]);
const getImageUrl = (path) =>
  path ? `${window.location.origin}/storage/${path}` : "";
const loadTravelBlogs = async () => {
  try {
    const response = await service.getTravelBlogs();
    blogPosts.value = response.data.map((blog) => ({
      ...blog,
      image: getImageUrl(blog.image),
    }));
  } catch (err) {
    console.error("Failed to load travel blogs", err);
  }
};
const loadTestimonials = async () => {
  try {
    const responseFeedbacks = await service.getFeedbacks();
    const responseGetAllUsers = await service.getUsers();
    feedback.value = responseFeedbacks.data;
    users.value = responseGetAllUsers.data.data;
    if (Array.isArray(feedback.value)) {
      testimonials.value = feedback.value.map((item) => {
        const user = users.value.find((u) => u.id === item.user_id);
        return {
          id: item.id,
          name: user
            ? `${user.first_name} ${
                user.last_name
                  ? user.last_name.charAt(0).toUpperCase() + "."
                  : ""
              }`
            : "Anonymous Traveler",
          rating: item.rate || 0,
          comment: item.message || "No comment provided.",
          date: item.created_at
            ? new Date(item.created_at).toLocaleDateString("en-US", {
                month: "short",
                day: "numeric",
                year: "numeric",
              })
            : "Recently",
          is_public: item.visibility !== "0",
        };
      });
    } else {
      testimonials.value = [];
    }
  } catch (error) {
    console.error("Error loading testimonials:", error);
  }
};
const filteredReviews = computed(() => {
  return testimonials.value
    .filter((t) => t.is_public)
    .map((t, index) => ({
      id: index,
      name: t.name,
      date: t.date || "Recently",
      rating: t.rating,
      comment: t.comment,
      is_public: t.is_public,
    }));
});
const newTestimonial = ref({
  user_id: page.props?.auth?.user?.id,
  rating: 0,
  comment: "",
});
const submitTestimonial = async () => {
  if (!newTestimonial.value.user_id) {
    toast.warning("You need to login first.");
    return;
  }

  if (
    !newTestimonial.value.comment ||
    newTestimonial.value.rating === 0
  ) {
    toast.warning("Please complete all fields before submitting.");
    return;
  }

  isSubmitting.value = true;
  try {
    const testimonialData = {
      user_id: newTestimonial.value.user_id,
      rate: newTestimonial.value.rating,
      message: newTestimonial.value.comment,
      visibility: false,
    };
    const response = await fetch("/api/feedbacks", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify(testimonialData),
    });
    if (!response.ok) {
      const err = await response.json();
      throw new Error(err.message || "Failed to submit testimonial");
    }
    const result = await response.json();
    testimonials.value.unshift({
      id: result.data.id,
      name: page.props?.auth?.user?.name || "Anonymous Traveler",
      rating: testimonialData.rate,
      comment: testimonialData.message,
      date: new Date().toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
      }),
    });
    newTestimonial.value = {
      user_id: page.props?.auth?.user?.id,
      rating: 0,
      comment: "",
    };
    toast.success("Thank you for your feedback!");
  } catch (error) {
    toast.error(
      "There was an error submitting your feedback. Please try again."
    );
  } finally {
    isSubmitting.value = false;
  }
};
onMounted(() => {
  loadTestimonials();
  loadTravelBlogs();
});
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