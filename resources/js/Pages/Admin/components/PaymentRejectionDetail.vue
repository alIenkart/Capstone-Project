<template>
  <Transition
    enter-active-class="transition-all duration-300 ease-out"
    enter-from-class="opacity-0 scale-95"
    enter-to-class="opacity-100 scale-100"
    leave-active-class="transition-all duration-200 ease-in"
    leave-from-class="opacity-100 scale-100"
    leave-to-class="opacity-0 scale-95"
  >
    <div
      v-if="visible"
      class="fixed inset-0 z-[70] flex items-center justify-center bg-black/40 backdrop-blur-md p-4 sm:p-6"
    >
      <div
        class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-100 mx-auto"
      >
        <div
          class="relative px-5 py-6 sm:px-8 sm:py-8 bg-gradient-to-br from-red-500 to-red-600 border-b border-red-600"
        >
          <div class="flex items-start gap-4">
            <div class="flex-1">
              <h3 class="text-2xl font-bold text-white">{{ title }}</h3>
              <p class="text-sm font-medium text-white/80 mt-1">
                {{ formattedDate }}
              </p>
            </div>
          </div>
        </div>
        <div class="px-5 py-6 sm:px-8 sm:py-8 space-y-6">
          <div>
            <label
              class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2"
              >Rejection Category</label
            >
            <div
              class="inline-block px-4 py-2 bg-rose-50 border border-rose-200 rounded-lg"
            >
              <p class="text-sm font-semibold text-rose-700">{{ category }}</p>
            </div>
          </div>
          <div>
            <label
              class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3"
              >Rejection Reason</label
            >
            <div class="relative">
              <textarea
                class="w-full rounded-xl border border-slate-200 p-4 text-sm text-slate-700 resize-none bg-slate-50 pointer-events-none"
                :value="reason"
                rows="4"
                readonly
              ></textarea>
            </div>
          </div>
        </div>
        <div
          class="bg-slate-50/50 py-5 border-t border-slate-100 flex flex-col sm:flex-row sm:justify-end px-5 sm:px-8 gap-3"
        >
          <button
            type="button"
            @click="$emit('close')"
            class="px-6 py-2.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg transition-all duration-200 hover:shadow-sm active:scale-95"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  title: { type: String, default: "Booking Rejected" },
  reason: { type: String, required: true },
  category: { type: String, required: true },
  date: { type: [String, Date], required: true },
  visible: { type: Boolean, default: false },
});

const formattedDate = computed(() => {
  if (!props.date) return "";
  const d = new Date(props.date);
  return d.toLocaleDateString("en-US", {
    month: "short",
    day: "numeric",
    year: "numeric",
  });
});
</script>
