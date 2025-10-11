<script setup>
import { defineProps, defineEmits } from 'vue';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  receiptData: {
    type: Object,
    default: () => ({})
  }
});

const emit = defineEmits(['close']);

const closeModal = () => {
  emit('close');
};

const downloadReceipt = async () => {
  const receiptElement = document.getElementById('receipt-content');
  
  if (!receiptElement) {
    alert('Receipt element not found');
    return;
  }
  
  // Hide buttons temporarily (close button will be hidden via print:hidden class)
  const buttons = document.getElementById('receipt-buttons');
  
  if (buttons) buttons.style.display = 'none';
  
  // Remove modal constraints for proper rendering
  const originalMaxHeight = receiptElement.style.maxHeight;
  const originalOverflow = receiptElement.style.overflow;
  receiptElement.style.maxHeight = 'none';
  receiptElement.style.overflow = 'visible';
  
  try {
    // Small delay to ensure rendering is complete
    await new Promise(resolve => setTimeout(resolve, 500));
    
    const canvas = await html2canvas(receiptElement, {
      scale: 2.5,
      useCORS: false,
      allowTaint: true,
      logging: false,
      backgroundColor: '#ffffff',
      windowHeight: receiptElement.scrollHeight,
      height: receiptElement.scrollHeight,
      imageTimeout: 0,
      removeContainer: true,
      ignoreElements: (element) => {
        // Ignore the close button and failed images
        if (element.id === 'close-button' || element.classList.contains('print:hidden')) {
          return true;
        }
        if (element.tagName === 'IMG' && element.naturalHeight === 0) {
          return true;
        }
        return false;
      }
    });
    
    const imgData = canvas.toDataURL('image/png', 1.0);
    const pdf = new jsPDF({
      orientation: 'portrait',
      unit: 'mm',
      format: 'a4',
      compress: true
    });
    
    const pdfWidth = 210;
    const pdfHeight = 297;
    const imgWidth = pdfWidth - 20; // 10mm margin on each side
    const imgHeight = (canvas.height * imgWidth) / canvas.width;
    
    // Center the content with margins
    const xOffset = 10;
    const yOffset = 10;
    
    // Add image to PDF, fitting to one page
    if (imgHeight <= pdfHeight - 20) {
      // Content fits on one page with margins
      pdf.addImage(imgData, 'PNG', xOffset, yOffset, imgWidth, imgHeight, undefined, 'FAST');
    } else {
      // Scale down to fit on one page
      const scaledHeight = pdfHeight - 20;
      const scaledWidth = (canvas.width * scaledHeight) / canvas.height;
      const centeredX = (pdfWidth - scaledWidth) / 2;
      pdf.addImage(imgData, 'PNG', centeredX, yOffset, scaledWidth, scaledHeight, undefined, 'FAST');
    }
    
    pdf.save(`Payment_Receipt_${props.receiptData.receiptNo || 'XXXX'}.pdf`);
  } catch (error) {
    console.error('Error generating PDF:', error);
    alert('Failed to generate PDF. Please try again.');
  } finally {
    // Restore original styles
    receiptElement.style.maxHeight = originalMaxHeight;
    receiptElement.style.overflow = originalOverflow;
    if (buttons) buttons.style.display = 'flex';
  }
};
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
    <div id="receipt-content" class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <!-- Header with Logo -->
      <div class="flex items-center justify-between p-6 border-b">
        <div class="flex items-center gap-3">
          <img src="/storage/logo/Logo.png" alt="JE Travel & Tours" class="w-16 h-16 object-contain" />
          <div>
            <h3 class="text-sm font-semibold text-gray-600">JE TRAVEL & TOURS</h3>
            <p class="text-xs text-gray-400">Adventure Awaits</p>
          </div>
        </div>
        <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Receipt Content -->
      <div class="p-8">
        <div class="text-center mb-6">
          <h2 class="text-2xl font-bold text-gray-800 mb-1">OFFICIAL PAYMENT RECEIPT</h2>
          <p class="text-sm text-gray-600">Receipt No: {{ receiptData.receiptNo || 'XXXX - XXXX' }}</p>
          <p class="text-sm text-gray-600">Date: {{ receiptData.date || new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) }}</p>
        </div>

        <hr class="border-gray-300 mb-6" />

        <!-- Customer Information & Payment Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <!-- Customer Information -->
          <div>
            <h3 class="font-bold text-gray-800 mb-3">Customer Information</h3>
            <div class="space-y-1 text-sm">
              <p><span class="text-gray-600">Name:</span> <span class="font-medium">{{ receiptData.customerName || 'John Doe' }}</span></p>
              <p><span class="text-gray-600">Email:</span> <span class="font-medium">{{ receiptData.customerEmail || 'abc@email.com' }}</span></p>
              <p><span class="text-gray-600">Phone No:</span> <span class="font-medium">{{ receiptData.customerPhone || '+63XXXXXXXXXXX' }}</span></p>
            </div>
          </div>

          <!-- Payment Details -->
          <div>
            <h3 class="font-bold text-gray-800 mb-3">Payment Details</h3>
            <div class="space-y-1 text-sm">
              <p><span class="text-gray-600">Payment Via:</span> <span class="font-medium">{{ receiptData.paymentVia || 'GCash' }}</span></p>
              <p><span class="text-gray-600">Quantity:</span> <span class="font-medium">{{ receiptData.quantity || '10' }}</span></p>
              <p><span class="text-gray-600">Type of Payment:</span> <span class="font-medium">{{ receiptData.paymentType || 'Downpayment' }}</span></p>
            </div>
          </div>
        </div>

        <!-- Booking Details -->
        <div class="mb-6">
          <h3 class="font-bold text-gray-800 mb-3">Booking Details</h3>
          <div class="space-y-1 text-sm">
            <p><span class="text-gray-600">Tour Classification:</span> <span class="font-medium">{{ receiptData.tourClassification || 'Land Tour' }}</span></p>
            <p><span class="text-gray-600">Package:</span> <span class="font-medium">{{ receiptData.package || 'Baguio Tour' }}</span></p>
            <p><span class="text-gray-600">Duration:</span> <span class="font-medium">{{ receiptData.duration || '3 Days' }}</span></p>
            <p><span class="text-gray-600">Booking Type:</span> <span class="font-medium">{{ receiptData.bookingType || 'Exclusive' }}</span></p>
            <p><span class="text-gray-600">Destination:</span> <span class="font-medium">{{ receiptData.destination || 'Baguio, Philippines' }}</span></p>
            <p><span class="text-gray-600">Travel Date:</span> <span class="font-medium">{{ receiptData.travelDate || 'April 2, 2025' }}</span></p>
          </div>
        </div>

        <!-- Total Amount -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Total Amount:</span>
              <span class="font-bold text-gray-800">₱ {{ receiptData.totalAmount || 'XXXX' }}</span>
            </div>
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Amount Paid:</span>
              <span class="font-bold text-green-600">₱ {{ receiptData.amountPaid || 'XXXX' }}</span>
            </div>
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Remaining Balance:</span>
              <span class="font-bold text-red-600">₱ {{ receiptData.remainingBalance || 'XXXX' }}</span>
            </div>
          </div>
        </div>

        <hr class="border-gray-300 mb-6" />

        <!-- Authorized By -->
        <div class="mb-6">
          <p class="font-bold text-gray-800 mb-3">Authorized by:</p>
          <div class="text-center">
            <img src="/storage/Signature/Signature.png" alt="Signature" class="w-32 h-20 object-contain mx-auto mb-1" />
            <p class="font-semibold text-gray-800 italic">Admin Name</p>
            <p class="text-sm text-gray-600 italic">Position</p>
          </div>
        </div>

        <hr class="border-gray-300 mb-6" />

        <!-- Footer -->
        <div class="text-center text-sm text-gray-600">
          <p class="font-medium mb-1">Thank you for booking with JE Travel & Tours!</p>
          <p>For more inquiries, contact us at <a href="mailto:contactus@jetravelandtours.com" class="text-blue-600 hover:underline">contactus@jetravelandtours.com</a></p>
        </div>
      </div>

      <!-- Action Buttons -->
      <div id="receipt-buttons" class="flex justify-center gap-4 p-6 border-t bg-gray-50">
        <button @click="closeModal" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
          Close
        </button>
        <button @click="downloadReceipt" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
          Download Receipt
        </button>
      </div>
    </div>
  </div>
</template>