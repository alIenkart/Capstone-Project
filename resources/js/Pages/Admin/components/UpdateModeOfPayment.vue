<template>
  <Transition>
    <div v-if="show" class="fixed inset-0 z-[70] bg-black/50 backdrop-blur-sm flex items-center justify-center">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-6">
          <h3 class="text-xl font-bold text-white flex items-center gap-3">
            Update Mode of Payment
          </h3>
        </div>

        <!-- Form -->
        <div class="px-6 py-6 space-y-4">

          <!-- Mode of Payment -->
          <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
              Mode of Payment*
            </label>
            <input type="text" v-model="formData.mode_of_payment" placeholder="GCASH, PAYMAYA, ETC."
              class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093]
                     focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium" />
          </div>

          <!-- QR Image -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md">
            <h4 class="text-xl font-bold text-slate-800 mb-5">Payment QR Image</h4>
            <div class="relative flex items-center justify-center border-2 border-dashed rounded-xl p-8 cursor-pointer"
                 :class="formData.qr_image_preview ? 'border-[#217093]' : 'border-slate-300'">
              <label for="imageUpload" class="flex flex-col items-center w-full cursor-pointer">
                <template v-if="formData.qr_image_preview">
                  <img :src="formData.qr_image_preview" alt="Preview"
                       class="w-3/4 h-48 object-cover rounded-xl shadow-lg" />
                </template>
                <template v-else>
                  <span class="text-base font-bold text-slate-700">Upload QR Image</span>
                  <span class="text-xs text-slate-400">PNG, JPG • Max 2MB</span>
                </template>
                <input type="file" id="imageUpload" class="hidden" accept="image/*"
                       @change="handleImageUpload" />
              </label>
            </div>          
          </div>

          <!-- Payment Notes -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md">
            <h4 class="text-xl font-bold text-slate-800 mb-5">Payment Notes</h4>
            <textarea v-model="formData.notes" rows="5"
                      class="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm resize-none"
                      placeholder="Enter notes that apply to this mode of payment..."></textarea>
          </div>

        </div>

        <!-- Actions -->
        <div class="bg-slate-50 px-6 py-4 border-t flex justify-end gap-3">
          <button @click="$emit('close')" class="rounded-lg px-6 py-2.5 text-sm font-semibold bg-slate-200">
            Cancel
          </button>
          <button @click="updateModeOfPayment" :disabled="isSubmitting" class="rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 
                px-6 py-2.5 text-sm font-semibold text-white disabled:opacity-60">
            {{ isSubmitting ? "Processing..." : "Save" }}
          </button>
        </div>

      </div>
    </div>
  </Transition>
</template>

<script setup>
import { watch, ref } from "vue";
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

const formData = ref({
  mode_of_payment: "",
  notes: "",
  qr_image: null,
  qr_image_preview: null,
});

watch(() => props.payment, (val) => {
  if (val) {
    formData.value.mode_of_payment = val.mode_of_payment || "";
    formData.value.notes = val.notes || "";
    formData.value.qr_image = null;
    formData.value.qr_image_preview = val.qr_image ? `/storage/${val.qr_image}` : null;
  }
}, { immediate: true });


const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (!file) return;
  formData.qr_image = file;
  formData.qr_image_preview = URL.createObjectURL(file);
};

const updateModeOfPayment = async () => {
  if (!formData.mode_of_payment) {
    toast.error("Mode of Payment is required.");
    return;
  }

  isSubmitting.value = true;

  try {
    const data = new FormData();
    data.append("mode_of_payment", formData.mode_of_payment);
    data.append("notes", formData.notes || "");
    if (formData.qr_image) data.append("qr_image", formData.qr_image);

    // PATCH request
    await service.updateModeOfPayment(props.payment.id, data);

    toast.success("Mode of Payment updated successfully.");
    emit("saved");
    emit("close");
  } catch (error) {
    console.error("Error updating mode of payment:", error);
    toast.error("Failed to update mode of payment.");
  } finally {
    isSubmitting.value = false;
  }
};
</script>
