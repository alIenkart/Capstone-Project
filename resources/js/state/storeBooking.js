import { defineStore } from 'pinia'

export const storeBooking = defineStore('booking', {
  state: () => ({
    startDate: null,
    endDate: null,
    packageId: null,
    packageType: null,
    quantity: 0,
    amount: 0,
    amountWithDiscount: 0,
    discountId: null,
    voucherCode: '',
    user:null
  }),

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
    setQuantity(count) {
      this.quantity = count
    },
    setAmount(amount){
      this.amount = amount
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

    reset() {
      this.startDate = null
      this.endDate = null
      this.packageId = null
      this.packageType = null
      this.quantity = 0
      this.amount = 0
      this.discountId = null
      this.voucherCode = ''
    }
  }
})