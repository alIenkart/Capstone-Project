<template>
  <div class="max-w-[1800px] mx-auto">

    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="relative flex-1 max-w-md">
          <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input v-model="searchQuery" type="text" placeholder="Search reviews by name or content..."
            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all" />
        </div>

        <div class="flex items-center gap-3 flex-wrap">
          <div class="relative">
            <select v-model="selectedRating"
              class="appearance-none pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all cursor-pointer bg-white font-medium text-gray-700">
              <option value="">All Ratings</option>
              <option value="5">5 Stars</option>
              <option value="4">4 Stars & Up</option>
              <option value="3">3 Stars & Up</option>
              <option value="2">2 Stars & Up</option>
            </select>
            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </div>

          <div class="relative">
            <select v-model="selectedStatus"
              class="appearance-none pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all cursor-pointer bg-white font-medium text-gray-700">
              <option value="">All Status</option>
              <option value="public">Public</option>
              <option value="private">Private</option>
            </select>
            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </div>
        </div>
      </div>
    </div>

    <div class="space-y-6">
      <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between border-b-4 border-[#1E71B8]">
        <div>
          <h3 class="text-xl font-bold text-gray-800">Overall Rating</h3>
          <p class="text-4xl font-extrabold text-[#1E71B8]">{{ averageRating.toFixed(1) }} / 5.0</p>
          <p class="text-sm text-gray-500">Based on {{ filteredReviews.length }} visible reviews</p>
        </div>
        <div class="flex items-center space-x-1">
          <template v-for="n in 5" :key="'avg-star-' + n">
            <svg class="w-10 h-10 transition-transform duration-150"
              :class="n <= Math.round(averageRating) ? 'text-yellow-400 fill-current' : 'text-gray-300'"
              fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 18.25l-6.18 3.57L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
          </template>
        </div>
      </div>

      <div v-if="filteredReviews.length > 0" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <div v-for="review in filteredReviews" :key="review.id"
          class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 transition-all duration-300 hover:shadow-xl"
          :class="review.is_public ? 'border-[#73BE5D]' : 'border-yellow-500'">
          <div class="p-6">
            <div class="flex justify-between items-start mb-4">
              <div class="flex items-center">
                <div
                  class="w-10 h-10 bg-[#1E71B8]/10 rounded-full flex items-center justify-center mr-3 border-2 border-gray-200">
                  <svg class="w-5 h-5 text-[#1E71B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div>
                  <p class="text-lg font-semibold text-gray-900 leading-tight">{{ review.user_name }}</p>
                  <p class="text-sm text-gray-500">{{ review.date }}</p>
                </div>
              </div>

              <div class="flex items-center space-x-0.5">
                <template v-for="n in 5" :key="review.id + '-star-' + n">
                  <svg class="w-5 h-5" :class="n <= review.rating ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                    fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                      d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 18.25l-6.18 3.57L7 14.14 2 9.27l6.91-1.01L12 2z" />
                  </svg>
                </template>
              </div>
            </div>

            <blockquote class="text-gray-700 italic border-l-4 border-gray-200 pl-4 pt-1 mb-4 text-base line-clamp-4">
              "{{ review.comment }}"
            </blockquote>

            <div class="border-t border-gray-100 pt-4 mt-auto flex justify-between items-center">
              <span :class="review.is_public ? 'bg-[#73BE5D]/20 text-[#5aa846]' : 'bg-yellow-500/20 text-yellow-700'"
                class="px-3 py-1 text-xs font-semibold rounded-full transition-colors duration-200">
                {{ review.is_public ? 'PUBLIC' : 'PRIVATE' }}
              </span>

              <div class="flex gap-2">
                <button @click="togglePublic(review.id)" :title="review.is_public ? 'Make Private' : 'Make Public'"
                  class="p-2 rounded-full transition-all duration-200"
                  :class="review.is_public ? 'text-yellow-500 hover:bg-yellow-100' : 'text-[#73BE5D] hover:bg-green-100'">
                  <svg v-if="review.is_public" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.772-2.556a9.957 9.957 0 011.644-1.054A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.543 7a9.97 9.97 0 01-1.563 3.029m-5.772-2.556L15 13.5M12 15a3 3 0 100-6 3 3 0 000 6z" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
                <button @click="deleteReview(review.id)" title="Delete Review"
                  class="p-2 text-red-500 rounded-full hover:bg-red-100 transition-all duration-200">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="py-12 text-center bg-white rounded-2xl shadow-lg">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">No Reviews Found</h3>
        <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
      </div>

    </div>
  </div>
</template>

<script setup>
import AdminIndex from './AdminIndex.vue'
import { ref, computed } from 'vue';

defineOptions({ layout: AdminIndex })
// --- MOCK DATA ---
const allReviews = ref([
  { id: 1, user_name: 'Jane Doe', date: 'Oct 28, 2025', rating: 5, comment: 'The tour was flawlessly organized and the guide was fantastic! Five stars all the way. Exceeded all expectations.', is_public: true },
  { id: 2, user_name: 'John Smith', date: 'Oct 25, 2025', rating: 4, comment: 'Very good value, although the hotel check-in process was a bit slow. Still enjoyed the destination immensely.', is_public: false },
  { id: 3, user_name: 'Anya Taylor', date: 'Oct 20, 2025', rating: 5, comment: 'The best family vacation we have ever had. Everything exceeded expectations and the service was top-notch.', is_public: true },
  { id: 4, user_name: 'Mike Johnson', date: 'Oct 15, 2025', rating: 3, comment: 'Average experience. The scenery was nice, but transportation felt rushed and the seats were uncomfortable.', is_public: true },
  { id: 5, user_name: 'Sara Connor', date: 'Oct 10, 2025', rating: 5, comment: 'Unforgettable trip! The guides were knowledgeable and very friendly. Will definitely book again next year.', is_public: false },
  { id: 6, user_name: 'David Lee', date: 'Oct 05, 2025', rating: 2, comment: 'Disappointing. The package description was misleading about the accommodations. Needs significant improvement.', is_public: true },
  { id: 7, user_name: 'Emily Wong', date: 'Sep 30, 2025', rating: 4, comment: 'A solid four-star experience. Great food and lovely people. Just a minor issue with the pickup timing.', is_public: true },
]);

// --- FILTERS ---
const searchQuery = ref('');
const selectedRating = ref('');
const selectedStatus = ref('');

// --- COMPUTED PROPERTIES ---

/**
 * Filters and searches the reviews based on user input.
 */
const filteredReviews = computed(() => {
  let reviews = allReviews.value;

  // 1. Filter by Search Query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    reviews = reviews.filter(r =>
      r.user_name.toLowerCase().includes(query) ||
      r.comment.toLowerCase().includes(query)
    );
  }

  // 2. Filter by Rating
  if (selectedRating.value) {
    const minRating = parseInt(selectedRating.value);
    reviews = reviews.filter(r => r.rating >= minRating);
  }

  // 3. Filter by Status
  if (selectedStatus.value) {
    const isPublic = selectedStatus.value === 'public';
    reviews = reviews.filter(r => r.is_public === isPublic);
  }

  return reviews;
});

/**
 * Calculates the average rating of the currently filtered reviews.
 */
const averageRating = computed(() => {
  if (filteredReviews.value.length === 0) return 0;

  const totalRating = filteredReviews.value.reduce((sum, r) => sum + r.rating, 0);
  return totalRating / filteredReviews.value.length;
});


// --- ACTIONS ---

const togglePublic = (id) => {
  const review = allReviews.value.find(r => r.id === id);
  if (review) {
    review.is_public = !review.is_public;
    // TODO: Send update to backend API
    console.log(`Review ${id} public status toggled to ${review.is_public}`);
  }
};

const deleteReview = (id) => {
  // In a real app, you would send a DELETE request to your backend first.
  if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
    allReviews.value = allReviews.value.filter(r => r.id !== id);
    console.log(`Review ${id} deleted.`);
  }
};
</script>