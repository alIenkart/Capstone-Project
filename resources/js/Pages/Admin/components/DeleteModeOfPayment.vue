<template>
  <Transition>
    <div v-if="show" class="fixed inset-0 z-[70] bg-black/50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
         <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-6">
            <h3 class="text-xl font-bold text-white flex items-center gap-3">
              Delete Mode of Payment
            </h3>
        </div>

        <div class="px-6 py-6 space-y-4">
            <p class="text-gray-700">
              Are you sure you want to delete this mode of payment? This action cannot be undone.
            </p>
        </div>

        <div class="bg-slate-50 px-6 py-4 border-t flex justify-end gap-3">
            <button
              @click="$emit('close')"
              class="rounded-lg px-6 py-2.5 text-sm font-semibold bg-slate-200 btn-cancel"
            >
              Cancel
            </button>

            <button
                @click="deleteModeOfPayment"
                :disabled="isSubmitting"
                class="rounded-lg bg-gradient-to-r from-red-500 to-red-600 
                    px-6 py-2.5 text-sm font-semibold text-white disabled:opacity-60 btn-delete">
                {{ isSubmitting ? "Processing..." : "Delete" }}
            </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref } from "vue";
import { useToast } from "vue-toastification";
import { api } from "../../../api/api";

const props = defineProps({
  show: Boolean,
  payment: Object,
});

const emit = defineEmits(["close", "saved"]);

const toast = useToast();
const service = new api();
const isSubmitting = ref(false);

const deleteModeOfPayment = async () => {
  if (!props.payment?.id) return;

  isSubmitting.value = true;

  try {
    await service.deleteModeOfPayment(props.payment.id);
    toast.success("Mode of Payment deleted successfully.");
    emit("saved");
    emit("close");
  } catch (error) {
    console.error(error);
    toast.error("Failed to delete mode of payment.");
  } finally {
    isSubmitting.value = false;
  }
};
</script>
