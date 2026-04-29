import { defineStore } from 'pinia'

export const storeBooking = defineStore('booking', {
  state: () => ({
    startDate: null,
    endDate: null,
    packageId: null,
    packageType: null,
    packageDestination: '',
    packageName: '',
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
    customItinerary: [],
    itinerary: [],
    start_date: '',
    end_date: '',
    availableSlots: 0,
    adultExtraFee: 0,
    kidsExtraFee: 0,
  }),

  getters: {
    getSelectedPackage(state) {
      if (!state.selectedPackage) return;
      return state.selectedPackage;
    },

    getTourType(state){
      if (!state.tourType) return;
      return state.tourType;
    },

    getTourClassification(state){
      if (!state.tourClassification) return;
      return state.tourClassification;
    },

    getHowManyDays(state) {
      if (!state.startDate || !state.endDate) return 0
    
      const start = new Date(state.startDate)
      const end = new Date(state.endDate)
    
      start.setHours(0, 0, 0, 0)
      end.setHours(0, 0, 0, 0)
    
      const diffMs = end - start
    
      const days = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1
    
      return days > 0 ? days : 0
    }
  },

  actions: {
    setCalendar({ start_date, end_date }) {
      this.startDate = start_date
      this.endDate = end_date
      
      const startDate = new Date(start_date)
      const endDate = new Date(end_date)
      
      startDate.setHours(0, 0, 0, 0)
      endDate.setHours(0, 0, 0, 0)
      
      const diffMs = endDate - startDate
      const calculatedDays = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1
      
      this.duration = calculatedDays > 0 ? calculatedDays : 0
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
    setPackageName(name) {
      this.packageName = name
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
      this.packageName = packages?.package_name || '';
    },

    setTourType(type) {
      this.tourType = type;
    },

    setTourClassification(classification) {
      this.tourClassification = classification;
    },

    setCustomItinerary(itinerary) {
      this.customItinerary = itinerary
    },
    
    setItinerary(itinerary) {
      this.itinerary = itinerary
    },

    setDate(date) {
      this.start_date = date[0].startDate;
      this.end_date = date[1].endDate;
    },

    setAvailableSlots(slot) {
      this.availableSlots = slot;
    },

    setAdultExtraFee(extraFee) {
      this.adultExtraFee = extraFee;
    },

    setKidsExtraFee(extraFee) {
      this.kidsExtraFee = extraFee;
    },

    reset() {
      this.startDate = null;
      this.endDate = null;
      this.packageId = null;
      this.packageType = null;
      this.packageDestination = '';
      this.packageName = '';
      this.adultsQuantity = 0;
      this.kidsQuantity = 0;
      this.amount = 0;
      this.adultTotalAmount = 0;
      this.kidsTotalAmount = 0;
      this.discountId = null;
      this.voucherCode = '';
      this.customItinerary = [];
      this.duration = 0;
      this.amountWithDiscount = 0;
      this.adultRate = 0;
      this.kidsRate = 0;
      this.user = null;
      this.discountIdImage = null;
      this.discountImages = [];
      this.selectedIdType = '';
      this.tourType = '';
      this.tourClassification = '';
      this.remarks = '';
      this.selectedPackage = null;
      this.itinerary = [];
      this.start_date = '';
      this.end_date = '';
      this.availableSlots = 0;
      this.adultExtraFee = 0;
      this.kidsExtraFee = 0;
    }
  },
  persist: true
})