import { defineStore } from 'pinia'

export const useNotification = defineStore('notification', {
  state: () => ({
    notifications: [],
  }),

  actions: {
    setNotifications(notifications) {
      this.notifications = notifications
    },

    markAllAsRead() {
      this.notifications.forEach((n) => (n.unread = false))
    },

    markAsRead(bookingId) {
      const notif = this.notifications.find((n) => n.bookingId === bookingId)
      if (notif) notif.unread = false
    },
  },
})
