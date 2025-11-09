<template>
    <Transition
      enter-active-class="transition-all duration-300 ease-out"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition-all duration-200 ease-in"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div v-if="visible" class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
          <!-- Header -->
          <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-6">
            <div class="flex items-center gap-3">
              <div class="p-3 bg-white/20 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4v2m0 0v2m0-6v-2m0 0v-2" />
                </svg>
              </div>
              <h3 class="text-xl font-bold text-white">Booking Rejected</h3>
            </div>
          </div>
  
          <!-- Body -->
          <div class="px-6 py-6 space-y-4">
            <div class="block text-sm font-semibold text-slate-700 mb-3 text-right">
              {{ formattedDate }}
            </div>
  
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-3">Rejection Category</label>
              <div class="block text-sm font-semibold text-slate-700 mb-1 pl-4">
                - {{ category }}
              </div>
            </div>
  
            <hr>
            <label class="block text-sm font-semibold text-slate-700">Reason:</label>
            <textarea
              class="w-full rounded-xl border-2 border-gray-300 p-3 text-sm text-slate-700 resize-none bg-gray-100"
              :value="reason"
              rows="4"
              readonly
            ></textarea>
          </div>
  
          <!-- Footer -->
          <div class="bg-slate-50 py-4 border-t border-slate-200 flex justify-end">
            <button
              type="button"
              @click="$emit('close')"
              class="rounded-lg px-6 py-2.5 text-sm font-semibold bg-slate-200 text-slate-800 hover:bg-slate-300 transition-all"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  
  const props = defineProps({
    reason: { type: String, required: true },
    category: { type: String, required: true },
    date: { type: [String, Date], required: true },
    visible: { type: Boolean, default: false }
  });

  console.log(props);
  
  const formattedDate = computed(() => {
    if (!props.date) return '';
    const d = new Date(props.date);
    return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
  });
  </script>
  
  