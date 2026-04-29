<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] p-8 text-white">
          <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-bold">Automation Settings</h1>
              <p class="text-blue-50/80 text-sm">Configure automated warnings and booking cancellations</p>
            </div>
          </div>
        </div>

        <div class="p-8 space-y-8">
          <!-- Toggle Master Switch -->
          <div class="flex items-center justify-between p-6 bg-blue-50 rounded-2xl border border-blue-100">
            <div>
              <h3 class="font-bold text-gray-900">Enable Automation</h3>
              <p class="text-sm text-gray-600">Master switch for warning messages and auto-cancellations</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" v-model="form.is_automation_enabled" class="sr-only peer">
              <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#1E71B8]"></div>
            </label>
          </div>

          <!-- Warning Settings -->
          <div class="space-y-4">
            <div class="flex items-center gap-2 text-[#1E71B8]">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <h2 class="font-bold uppercase tracking-wider text-sm">Warning Message Configuration</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
              <div class="md:col-span-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Days Before Travel</label>
                <div class="relative">
                  <input 
                    type="number" 
                    v-model="form.warning_days"
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 focus:border-[#1E71B8] focus:ring-4 focus:ring-blue-500/10 outline-none transition-all"
                  >
                  <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">days</span>
                </div>
              </div>
              <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Warning Message Template</label>
                <textarea 
                  v-model="form.warning_message"
                  rows="3"
                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 focus:border-[#1E71B8] focus:ring-4 focus:ring-blue-500/10 outline-none transition-all resize-none"
                  placeholder="Enter the message template..."
                ></textarea>
              </div>
            </div>
          </div>

          <div class="border-t border-gray-100 pt-8"></div>

          <!-- Cancellation Settings -->
          <div class="space-y-4">
            <div class="flex items-center gap-2 text-red-600">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <h2 class="font-bold uppercase tracking-wider text-sm">Automated Cancellation Configuration</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
              <div class="md:col-span-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Days Before Travel</label>
                <div class="relative">
                  <input 
                    type="number" 
                    v-model="form.cancellation_days"
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 outline-none transition-all"
                  >
                  <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">days</span>
                </div>
              </div>
              <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cancellation Message Template</label>
                <textarea 
                  v-model="form.cancellation_message"
                  rows="3"
                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 outline-none transition-all resize-none"
                  placeholder="Enter the message template..."
                ></textarea>
              </div>
            </div>
          </div>

          <!-- Save Button -->
          <div class="flex justify-end pt-4">
            <button 
              @click="saveSettings"
              :disabled="loading"
              class="flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:transform-none"
            >
              <svg v-if="loading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ loading ? 'Saving Changes...' : 'Save Settings' }}</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import AdminIndex from "./AdminIndex.vue";
import { ref, onMounted } from "vue";
import { api } from "../../api/api";
import { useToast } from "vue-toastification";

defineOptions({ layout: AdminIndex });

const service = new api();
const loading = ref(false);
const toast = useToast();

const form = ref({
  warning_days: 3,
  warning_message: '',
  cancellation_days: 1,
  cancellation_message: '',
  is_automation_enabled: false
});

const fetchSettings = async () => {
  try {
    const response = await service.getAutomationSettings();
    if (response.data) {
      form.value = response.data;
    }
  } catch (error) {
    console.error("Error fetching settings:", error);
  }
};

const saveSettings = async () => {
  loading.value = true;
  try {
    await service.updateAutomationSettings(form.value);
    toast.success('Automation configurations have been updated successfully.');
  } catch (error) {
    console.error("Error saving settings:", error);
    toast.error('Something went wrong while saving the settings.');
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchSettings();
});
</script>
