<template>
  <Transition>
    <div v-if="show" class="fixed inset-0 z-[70] bg-black/50 backdrop-blur-sm flex items-center justify-center">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md h-[80vh] overflow-hidden transform transition-all flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-6 flex-shrink-0">
                <h3 class="text-xl font-bold text-white flex items-center gap-3">
                    Create New Mode of Payment
                </h3>
            </div>

            <!-- Scrollable content -->
            <div class="px-6 py-6 space-y-4 overflow-y-auto flex-1">
                <!-- Mode of Payment -->
                <div class="mb-6">
                    <label for="modeOfPayment" class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                        Mode of Payment*
                    </label>
                    <input type="text" id="modeOfPayment" v-model="modeOfPayment" placeholder="GCASH, PAYMAYA, ETC."
                        class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093]
                            focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium"
                        />
                </div>

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                        Name*
                    </label>
                    <input type="text" id="name" v-model="name" placeholder="Enter name"
                        class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093]
                            focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium"
                        />
                </div>

                <!-- Number -->
                <div class="mb-6">
                    <label for="number" class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                        Number*
                    </label>
                    <input type="text" id="number" v-model="number" placeholder="Enter number"
                        class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093]
                            focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium"
                        />
                </div>

                <!-- QR Image -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md">
                    <h4 class="text-xl font-bold text-slate-800 mb-5">Payment QR Image</h4>

                    <div class="relative flex items-center justify-center border-2 border-dashed rounded-xl p-8 cursor-pointer"
                        :class="imagePreview ? 'border-[#217093]' : 'border-slate-300'">

                        <label for="imageUpload" class="flex flex-col items-center w-full cursor-pointer">
                            <template v-if="imagePreview">
                            <img :src="imagePreview"
                                alt="Preview"
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

                <!-- Notes -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md">
                    <h4 class="text-xl font-bold text-slate-800 mb-5">Payment Notes*</h4>

                  <textarea id="paymentNotes" rows="5" v-model="paymentNotes"
                    class="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm resize-none"
                    placeholder="Enter notes that apply to this mode of payment..."
                  ></textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="bg-slate-50 px-6 py-4 border-t flex justify-end gap-3 flex-shrink-0">
                <button
                  @click="$emit('close')"
                  class="rounded-lg px-6 py-2.5 text-sm font-semibold bg-slate-200 btn-cancel"
                >
                  Cancel
                </button>
                <button @click="submitModeOfPayment" :disabled="isSubmitting"
                    class="rounded-lg bg-gradient-to-r from-green-500 to-green-600 
                        px-6 py-2.5 text-sm font-semibold text-white disabled:opacity-60 btn-save">
                    {{ isSubmitting ? "Processing..." : "Save" }}
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
});

const emit = defineEmits(["close", "saved"]);

const toast = useToast();
const service = new api();

const modeOfPayment = ref("");
const name = ref("");
const number = ref("");
const paymentNotes = ref("");
const qrImageFile = ref(null);
const imagePreview = ref(null);
const isSubmitting = ref(false);

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (!file) return;
  qrImageFile.value = file;
  imagePreview.value = URL.createObjectURL(file);
};

const resetForm = () => {
  modeOfPayment.value = "";
  name.value = "";
  number.value = "";
  paymentNotes.value = "";
  qrImageFile.value = null;
  imagePreview.value = null;
};

const submitModeOfPayment = async () => {
  if (!modeOfPayment.value || !name.value || !number.value || !paymentNotes.value || !qrImageFile.value) {
    toast.error("All fields are required.");
    return;
  }

  isSubmitting.value = true;

  try {
    const formData = new FormData();
    formData.append("mode_of_payment", modeOfPayment.value);
    formData.append("name", name.value);
    formData.append("number", number.value);
    formData.append("notes", paymentNotes.value);
    formData.append("qr_image", qrImageFile.value);

    await service.createModeOfPayment(formData);
    toast.success("Mode of Payment added successfully.");
    resetForm();
    emit("saved");
    emit("close");
  } catch (error) {
    toast.error("Failed to add mode of payment.");
    console.error(error);
  } finally {
    isSubmitting.value = false;
  }
};
</script>
