<template>
    <transition name="fade">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">
                    {{ title || 'Delete Confirmation' }}
                </h2>
                <p class="text-gray-600 mb-6">
                    {{ message || 'Are you sure you want to delete this item? This action cannot be undone.' }}
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="$emit('cancel')"
                        class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition-colors">
                        Cancel
                    </button>
                    <button @click="$emit('confirm')"
                        class="px-5 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
defineProps({
    show: Boolean,
    title: String,
    message: String
})
defineEmits(['confirm', 'cancel'])
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>