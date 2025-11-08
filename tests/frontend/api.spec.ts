import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest'

// Mock the axios plainInstance used by api.ts
const getMock = vi.fn()
const postMock = vi.fn()
const patchMock = vi.fn()
const deleteMock = vi.fn()

vi.mock('@/resources/js/api/axios-api', () => ({
  plainInstance: {
    get: getMock,
    post: postMock,
    patch: patchMock,
    delete: deleteMock,
  }
}))

import { api } from '@/resources/js/api/api'

describe('api.ts', () => {
  let client: api

  beforeEach(() => {
    client = new api()
    getMock.mockReset()
    postMock.mockReset()
    patchMock.mockReset()
    deleteMock.mockReset()
  })

  afterEach(() => {
    vi.clearAllMocks()
  })

  it('builds GET requests with correct paths and params for notifications', async () => {
    getMock.mockResolvedValue({ data: [] })

    await client.getNotifications(42)
    expect(getMock).toHaveBeenCalledWith('/api/notifications', { params: { user_id: 42 } })

    await client.getUnreadNotifications(7)
    expect(getMock).toHaveBeenCalledWith('/api/notifications/unread', { params: { user_id: 7 } })

    await client.getUnreadNotificationCount(9)
    expect(getMock).toHaveBeenCalledWith('/api/notifications/unread-count', { params: { user_id: 9 } })
  })

  it('sends multipart/form-data when creating a booking', async () => {
    postMock.mockResolvedValue({ data: { ok: true } })
    const payload = new FormData()
    payload.append('field', 'value')

    await client.createBooking(payload)
    expect(postMock).toHaveBeenCalled()
    const [url, body, config] = postMock.mock.calls[0]
    expect(url).toBe('/api/bookings')
    expect(body).toBe(payload)
    expect(config).toEqual({ headers: { 'Content-Type': 'multipart/form-data' } })
  })

  it('uploads images using multipart/form-data for content and blogs', async () => {
    postMock.mockResolvedValue({ data: { ok: true } })

    // Fake File for browser-like environment
    const file = new File([new Blob(['x'])], 'a.png', { type: 'image/png' })

    await client.uploadContentImage(5, file)
    expect(postMock).toHaveBeenCalled()
    {
      const [url, body, config] = postMock.mock.calls[0]
      expect(url).toBe('/api/contents/5/upload-image')
      expect(body).toBeInstanceOf(FormData)
      expect(config).toEqual({ headers: { 'Content-Type': 'multipart/form-data' } })
    }

    await client.uploadTravelBlogImage(3, file)
    expect(postMock).toHaveBeenCalledTimes(2)
    {
      const [url, body, config] = postMock.mock.calls[1]
      expect(url).toBe('/api/travel-blogs/3/upload-image')
      expect(body).toBeInstanceOf(FormData)
      expect(config).toEqual({ headers: { 'Content-Type': 'multipart/form-data' } })
    }
  })

  it('marks all notifications as read using POST with params', async () => {
    postMock.mockResolvedValue({ data: { ok: true } })

    await client.markAllNotificationsAsRead(11)

    expect(postMock).toHaveBeenCalledWith('/api/notifications/mark-all-read', null, { params: { user_id: 11 } })
  })

  it('calls correct endpoints for CRUD-like helpers', async () => {
    getMock.mockResolvedValue({ data: [] })
    patchMock.mockResolvedValue({ data: {} })
    deleteMock.mockResolvedValue({})

    await client.getUsers()
    expect(getMock).toHaveBeenCalledWith('/api/users')

    await client.updateUser(1, { name: 'A' })
    expect(patchMock).toHaveBeenCalledWith('/api/users/1', { name: 'A' })

    await client.getPackages()
    expect(getMock).toHaveBeenCalledWith('/api/packages')

    await client.getPackage(2)
    expect(getMock).toHaveBeenCalledWith('/api/packages/2')

    await client.getBookings()
    expect(getMock).toHaveBeenCalledWith('/api/bookings')

    await client.updateBooking(3, { x: 1 })
    expect(patchMock).toHaveBeenCalledWith('/api/bookings/3', { x: 1 })

    await client.getPayments()
    expect(getMock).toHaveBeenCalledWith('/api/payments')

    await client.createInquiry({ email: 'a@b.com' })
    expect(postMock).toHaveBeenCalledWith('/api/inquiries', { email: 'a@b.com' })

    await client.getFeedbacks()
    expect(getMock).toHaveBeenCalledWith('/api/feedbacks')

    await client.updateFeedback(4, { status: 'read' })
    expect(patchMock).toHaveBeenCalledWith('/api/feedbacks/4', { status: 'read' })

    await client.deleteFeedback(5)
    expect(deleteMock).toHaveBeenCalledWith('/api/feedbacks/5')

    await client.getContents()
    expect(getMock).toHaveBeenCalledWith('/api/contents')

    await client.getContent(6)
    expect(getMock).toHaveBeenCalledWith('/api/contents/6')

    await client.createContent(new FormData())
    expect(postMock).toHaveBeenCalled()

    await client.updateContent(7, { title: 't' })
    expect(patchMock).toHaveBeenCalledWith('/api/contents/7', { title: 't' })

    await client.deleteContent(8)
    expect(deleteMock).toHaveBeenCalledWith('/api/contents/8')

    await client.getTravelBlogs()
    expect(getMock).toHaveBeenCalledWith('/api/travel-blogs')

    await client.getTravelBlog(9)
    expect(getMock).toHaveBeenCalledWith('/api/travel-blogs/9')

    await client.createTravelBlog(new FormData())
    expect(postMock).toHaveBeenCalled()

    await client.updateTravelBlog(10, { title: 'TB' })
    expect(patchMock).toHaveBeenCalledWith('/api/travel-blogs/10', { title: 'TB' })

    await client.deleteTravelBlog(12)
    expect(deleteMock).toHaveBeenCalledWith('/api/travel-blogs/12')
  })

  it('handles About Us and Our Story endpoints correctly', async () => {
    getMock.mockResolvedValue({ data: {} })
    patchMock.mockResolvedValue({ data: {} })
    postMock.mockResolvedValue({ data: {} })

    await client.getAboutUs()
    expect(getMock).toHaveBeenCalledWith('/api/about-us')

    await client.updateAboutUs({ a: 1 })
    expect(patchMock).toHaveBeenCalledWith('/api/about-us', { a: 1 })

    const img = new File([new Blob(['x'])], 'x.jpg', { type: 'image/jpeg' })
    await client.uploadAboutUsImage(img)
    {
      const [url, body, config] = postMock.mock.calls.at(-1)!
      expect(url).toBe('/api/about-us/upload-image')
      expect(body).toBeInstanceOf(FormData)
      expect(config).toEqual({ headers: { 'Content-Type': 'multipart/form-data' } })
    }

    await client.getOurStory()
    expect(getMock).toHaveBeenCalledWith('/api/our-story')

    await client.updateOurStory({ b: 2 })
    expect(patchMock).toHaveBeenCalledWith('/api/our-story', { b: 2 })

    await client.uploadOurStoryImage(img)
    {
      const [url, body, config] = postMock.mock.calls.at(-1)!
      expect(url).toBe('/api/our-story/upload-image')
      expect(body).toBeInstanceOf(FormData)
      expect(config).toEqual({ headers: { 'Content-Type': 'multipart/form-data' } })
    }
  })

  it('handles accreditations endpoints correctly', async () => {
    getMock.mockResolvedValue({ data: [] })
    deleteMock.mockResolvedValue({})
    postMock.mockResolvedValue({ data: {} })

    await client.getAccreditations()
    expect(getMock).toHaveBeenCalledWith('/api/accreditations')

    const img = new File([new Blob(['x'])], 'a.png', { type: 'image/png' })
    await client.uploadAccreditation(img)
    {
      const [url, body, config] = postMock.mock.calls.at(-1)!
      expect(url).toBe('/api/accreditations')
      expect(body).toBeInstanceOf(FormData)
      expect(config).toEqual({ headers: { 'Content-Type': 'multipart/form-data' } })
    }

    await client.deleteAccreditation(15)
    expect(deleteMock).toHaveBeenCalledWith('/api/accreditations/15')
  })

  it('marks single notification as read and delete notification', async () => {
    patchMock.mockResolvedValue({})
    deleteMock.mockResolvedValue({})

    await client.markNotificationAsRead(22)
    expect(patchMock).toHaveBeenCalledWith('/api/notifications/22/read')

    await client.deleteNotification(22)
    expect(deleteMock).toHaveBeenCalledWith('/api/notifications/22')
  })
})
