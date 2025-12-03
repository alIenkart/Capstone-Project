<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
  >
    <div
      id="receipt-content"
      class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
    >
      <div class="flex items-center justify-center p-6 border-b">
        <div class="flex items-center gap-3">
          <img
            src="/storage/logo/Logo.png"
            alt="JE Travel & Tours"
            class="w-16 h-16 object-contain"
          />
          <div>
            <h3 class="text-sm font-semibold text-gray-600">
              JE TRAVEL & TOURS
            </h3>
            <p class="text-xs text-gray-400">Adventure Awaits</p>
          </div>
        </div>
      </div>

      <div class="p-8">
        <div class="text-center mb-6">
          <h2 class="text-2xl font-bold text-gray-800 mb-1">
            OFFICIAL PAYMENT RECEIPT
          </h2>
          <p class="text-sm text-gray-600">
            Receipt No: {{ receiptData.booking_id ? `B${String(receiptData.booking_id).padStart(5, "0")}` : "XXXX-XXXX" }}
          </p>
          <p class="text-sm text-gray-600">
            Date:
            {{
              formattedPayments
            }}
          </p>
        </div>

        <hr class="border-gray-300 mb-6" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <h3 class="font-bold text-gray-800 mb-3">Customer Information</h3>
            <div class="space-y-1 text-sm">
              <p>
                <span class="text-gray-600">Name: </span>
                <span class="font-medium">{{
                  receiptData.customer_name || receiptData.booking.customer_name
                }}</span>
              </p>
              <p>
                <span class="text-gray-600">Email: </span>
                <span class="font-medium">{{
                  receiptData.customer_email || receiptData.booking.customer_email
                }}</span>
              </p>
              <p>
                <span class="text-gray-600">Phone No: </span>
                <span class="font-medium">{{
                  receiptData.customer_phone || receiptData.booking.customer_phone
                }}</span>
              </p>
            </div>
          </div>

          <div>
            <h3 class="font-bold text-gray-800 mb-3">Payment Details</h3>
            <div class="space-y-1 text-sm">
              <p>
                <span class="text-gray-600">Payment Via: </span>
                <span class="font-medium">{{
                  receiptData.mode_of_payment
                }}</span>
              </p>
              <p>
                <span class="text-gray-600">Quantity: </span>
                <span class="font-medium">{{
                  receiptData.total_quantity || receiptData.booking.total_quantity
                }}</span>
              </p>
              <p>
                <span class="text-gray-600">Type of Payment: </span>
                <span class="font-medium">{{
                  receiptData.type_of_payment
                }}</span>
              </p>
            </div>
          </div>
        </div>

        <div class="mb-6">
          <h3 class="font-bold text-gray-800 mb-3">Booking Details</h3>
          <div class="space-y-1 text-sm">
            <p>
              <span class="text-gray-600">Tour Classification: </span>
              <span class="font-medium">{{
                receiptData.tour_classification?.length
                  ? receiptData.tour_classification.length > 2
                    ? receiptData.tour_classification.slice(0, -1).join(", ") + " and " + receiptData.tour_classification.slice(-1)
                    : receiptData.tour_classification.join(" and ")
                  : "N/A"
              }}</span>
            </p>
            <p>
              <span class="text-gray-600">Package: </span>
              <span class="font-medium">{{
                receiptData.package_destination ? receiptData.package_destination + " Tour" : receiptData.booking.package_destination ? receiptData.booking.package_destination + " Tour" : "N/A"
              }}</span>
            </p>
            <p>
              <span class="text-gray-600">Duration: </span>
              <span class="font-medium">{{
                receiptData.duration ? receiptData.duration + " Days" : receiptData.booking.duration ? receiptData.booking.duration + " Days" : "N/A"
              }}</span>
            </p>
            <p>
              <span class="text-gray-600">Booking Type: </span>
              <span class="font-medium">{{
                receiptData.tour_type || receiptData.booking.tour_type
              }}</span>
            </p>
            <p>
              <span class="text-gray-600">Trip Start Date: </span>
              <span class="font-medium">{{
                receiptData.start_date
                  ? new Date(receiptData.start_date).toLocaleDateString("en-US", {
                      year: "numeric",
                      month: "long",
                      day: "numeric"
                    })
                  : receiptData.booking.start_date
                   ? new Date(receiptData.booking.start_date).toLocaleDateString("en-US", {
                      year: "numeric",
                      month: "long",
                      day: "numeric"
                    }) : "N/A"
              }}</span>
            </p>
            <p>
              <span class="text-gray-600">Trip End Date: </span>
              <span class="font-medium">{{
                receiptData.start_date
                  ? new Date(receiptData.end_date).toLocaleDateString("en-US", {
                      year: "numeric",
                      month: "long",
                      day: "numeric"
                    })
                  : receiptData.booking.end_date
                   ? new Date(receiptData.booking.end_date).toLocaleDateString("en-US", {
                      year: "numeric",
                      month: "long",
                      day: "numeric"
                    }) : "N/A"
              }}</span>
            </p>
          </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Amount Paid:</span>
              <span class="font-bold text-gray-800">₱ 
              {{
                formattedPaymentAmount && formattedPaymentAmount !== 0
                  ? Number(formattedPaymentAmount).toLocaleString(undefined, { 
                      minimumFractionDigits: 2, 
                      maximumFractionDigits: 2 
                    })
                  : Number(receiptData.total_price - receiptData.remaining_balance).toLocaleString(undefined, { 
                      minimumFractionDigits: 2, 
                      maximumFractionDigits: 2 
                    })
              }}
            </span>
            </div>
            <div v-if=(receiptData.discount_amount) class="flex justify-between">
              <span class="font-bold text-gray-800">Discount ({{ receiptData.discount_percent }}%):</span>
              <span class="font-bold text-gray-800"
                >₱ {{ receiptData.discount_amount }}</span
              >
            </div>
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Total Amount:</span>
              <span class="font-bold text-gray-800"
                  >₱ 
                  {{
                  formattedPaymentAmount && formattedPaymentAmount !== 0
                    ? Number(receiptData.total_price).toLocaleString(undefined, { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                      })
                    : Number(receiptData.total_price).toLocaleString(undefined, { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                      })
                }}
              </span>
            </div>
            <div v-if="receiptData.type_of_payment === 'Down Payment' && !isMatch(receiptData.total_price, formattedPaymentAmount)">
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Remaining Balance:</span>
              <span class="font-bold text-red-600"
                >₱ {{ formattedPaymentAmount.toLocaleString(undefined, { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                      }) }}</span
              >
            </div>
            </div>
          </div>
        </div>

        <hr class="border-gray-300 mb-6" />

        <div class="mb-6">
          <p class="font-bold text-gray-800 mb-3">Authorized by:</p>
          <div class="text-center">
            <img
              src="/storage/Signature/Signature.png"
              alt="Signature"
              class="w-32 h-20 object-contain mx-auto mb-1"
            />
            <p class="font-semibold text-gray-800 italic">Admin Name</p>
            <p class="text-sm text-gray-600 italic">Position</p>
          </div>
        </div>

        <hr class="border-gray-300 mb-6" />

        <div class="text-center text-sm text-gray-600">
          <p class="font-medium mb-1">
            Thank you for booking with JE Travel & Tours!
          </p>
          <p>
            For more inquiries, contact us at
            <a
              href="mailto:contactus@jetravelandtours.com"
              class="text-blue-600 hover:underline"
              >contactus@jetravelandtours.com</a
            >
          </p>
        </div>
      </div>

      <div
        id="receipt-buttons"
        class="flex justify-center gap-4 p-6 border-t bg-gray-50"
      >
        <button
          @click="closeModal"
          class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition"
        >
          Close
        </button>
        <button
          @click="downloadReceipt"
          class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition"
        >
          Download Receipt
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits, watch, computed } from "vue";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  receiptData: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["close"]);

const closeModal = () => {
  emit("close");
};

const downloadReceipt = async () => {
  const receiptElement = document.getElementById("receipt-content");

  if (!receiptElement) {
    alert("Receipt element not found");
    return;
  }

  const buttons = document.getElementById("receipt-buttons");

  if (buttons) buttons.style.display = "none";

  const originalMaxHeight = receiptElement.style.maxHeight;
  const originalOverflow = receiptElement.style.overflow;
  receiptElement.style.maxHeight = "none";
  receiptElement.style.overflow = "visible";

  try {
    await new Promise((resolve) => setTimeout(resolve, 500));

    const canvas = await html2canvas(receiptElement, {
      scale: 2.5,
      useCORS: false,
      allowTaint: true,
      logging: false,
      backgroundColor: "#ffffff",
      windowHeight: receiptElement.scrollHeight,
      height: receiptElement.scrollHeight,
      imageTimeout: 0,
      removeContainer: true,
      ignoreElements: (element) => {
        if (
          element.id === "close-button" ||
          element.classList.contains("print:hidden")
        ) {
          return true;
        }
        if (element.tagName === "IMG" && element.naturalHeight === 0) {
          return true;
        }
        return false;
      },
    });

    const imgData = canvas.toDataURL("image/png", 1.0);
    const pdf = new jsPDF({
      orientation: "portrait",
      unit: "mm",
      format: "a4",
      compress: true,
    });

    const pdfWidth = 210;
    const pdfHeight = 297;
    const imgWidth = pdfWidth - 20;
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    const xOffset = 10;
    const yOffset = 10;

    if (imgHeight <= pdfHeight - 20) {
      pdf.addImage(
        imgData,
        "PNG",
        xOffset,
        yOffset,
        imgWidth,
        imgHeight,
        undefined,
        "FAST"
      );
    } else {
      const scaledHeight = pdfHeight - 20;
      const scaledWidth = (canvas.width * scaledHeight) / canvas.height;
      const centeredX = (pdfWidth - scaledWidth) / 2;
      pdf.addImage(
        imgData,
        "PNG",
        centeredX,
        yOffset,
        scaledWidth,
        scaledHeight,
        undefined,
        "FAST"
      );
    }

    pdf.save(`Payment_Receipt_${props.receiptData.receiptNo || "XXXX"}.pdf`);
  } catch (error) {
    console.error("Error generating PDF:", error);
    alert("Failed to generate PDF. Please try again.");
  } finally {
    receiptElement.style.maxHeight = originalMaxHeight;
    receiptElement.style.overflow = originalOverflow;
    if (buttons) buttons.style.display = "flex";
  }
};

const formattedPayments = computed(() => {
  const history = props.receiptData.payment_history;

  const payments = history ? (Array.isArray(history) ? history : [history]) : [];

  const type = payments.length > 1 ? "Down Payment" : payments.length === 1 ? "Full Payment" : "N/A";

  const relevantDate =
    payments.length > 0
      ? type === "Full Payment"
        ? payments[0].paymentDate
        : payments[payments.length - 1].paymentDate
      : props.receiptData.start_date;

  const date = new Date(relevantDate).toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });

  return date;
});


const formattedPaymentAmount = computed(() => {
  if (props.receiptData.payment_history === null) {
    const totalPrice = props.receiptData.total_price - (props.receiptData.remaining_balance || 0);
    return totalPrice;
  }

  const history = props.receiptData.payment_history;

  if (!history) return 0;

  const payments = Array.isArray(history) ? history : [history];

  if (props.receiptData.type_of_payment === 'Full Payment') {
    return payments.reduce((sum, p) => sum + (Number(p.fullPaymentAmount) || 0), 0);
  } else {
    return payments.reduce((sum, p) => sum + (Number(p.downPaymentAmount) || 0), 0);
  }
});

const isMatch = (amount, remaining) => {
  return Number(amount) === Number(remaining);
};


watch(
  () => props.receiptData,
  (newData) => {
    console.log("Updated Receipt Data:", newData);
  },
  { immediate: true, deep: true }
);
</script>
