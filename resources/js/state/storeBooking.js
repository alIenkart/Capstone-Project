import { defineStore } from 'pinia'

export const storeBooking = defineStore('booking', {
  state: () => ({
    startDate: null,
    endDate: null,
    packageId: null,
    packageType: null,
    packageDestination: '',
    duration: 0,
    adultsQuantity: 0,
    kidsQuantity: 0,
    amount: 0,
    amountWithDiscount: 0,
    adultTotalAmount: 0,
    kidsTotalAmount: 0,
    adultRate: 0,
    kidsRate: 0,
    discountId: null,
    voucherCode: '',
    user: null,
    discountIdImage: null,
    discountImages: [],
    selectedIdType: '',
    tourType: '',
    tourClassification: '',
    remarks: '',
    selectedPackage: null,
  }),

  getters: {
    getSelectedPackage(state) {
      if (!state.selectedPackage) return;
      return state.selectedPackage;
    }
  },

  actions: {
    setCalendar({ startDate, endDate }) {
      this.startDate = startDate
      this.endDate = endDate
    },
    setPackageId(id) {
      this.packageId = id
    },
    setPackageType(type) {
      this.packageType = type
    },
    setPackageDestination(destination) {
      this.packageDestination = destination
    },
    setDuration(days) {
      this.duration = days
    },
    setAdultsQuantity(count) {
      this.adultsQuantity = count
    },
    setKidsQuantity(count) {
      this.kidsQuantity = count
    },
    setAmount(amount){
      this.amount = amount
    },
    setAdultTotalAmount(amount) {
      this.adultTotalAmount = amount
    },
    setKidsTotalAmount(amount) {
      this.kidsTotalAmount = amount
    },
    setAdultRate(rate) {
      this.adultRate = rate
    },
    setKidsRate(rate) {
      this.kidsRate = rate
    },
    setTotalAmountWithDiscount(amountWithDiscount){
      this.amountWithDiscount = amountWithDiscount
    },
    setDiscountId(id) {
      this.discountId = id
    },
    setVoucher(code) {
      this.voucherCode = code
    },
    setUser({first_name, last_name, email, phone_number, address}) {
      this.user = {
        first_name,
        last_name,
        email,
        phone_number,
        address
      }
    },
    setDiscountIdImage(image) {
      this.discountIdImage = image;
    },
    setSelectedIdType(type) {
      this.selectedIdType = type;
    },
    setDiscountImages(images) {
      this.discountImages = images;
    },
    setRemarks(remarks) {
      this.remarks = remarks;
    },

    setPackage(packages) {
      this.selectedPackage = packages;
    },

    reset() {
      this.startDate = null
      this.endDate = null
      this.packageId = null
      this.packageType = null
      this.adultsQuantity = 0
      this.kidsQuantity = 0
      this.amount = 0
      this.adultTotalAmount = 0
      this.kidsTotalAmount = 0
      this.discountId = null
      this.voucherCode = ''
    }
  },
  persist: true
})