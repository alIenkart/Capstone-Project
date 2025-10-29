import { mount } from '@vue/test-utils'
import { describe, it, expect, vi, beforeEach } from 'vitest'
import Calendar from '@/resources/js/Pages/Landing/Calendar.vue'
import { createTestingPinia } from '@pinia/testing'
import { createPinia, setActivePinia, defineStore } from 'pinia'

// Mock vue-toastification useToast
vi.mock('vue-toastification', () => ({
  useToast: () => ({
    warning: vi.fn(),
    success: vi.fn(),
    error: vi.fn(),
    info: vi.fn(),
  })
}))

// Provide a mock layout component dependency used by defineOptions({ layout: LandingIndex })
vi.mock('@/resources/js/Pages/Landing/LandingIndex.vue', () => ({
  default: { name: 'LandingIndex', template: '<div><slot /></div>' }
}))

// Mock storeBooking composable
vi.mock('@/resources/js/state/storeBooking', () => {
  const state = {
    startDate: '',
    endDate: '',
    tourType: '',
    tourClassification: '',
  }
  return {
    storeBooking: () => ({
      ...state,
      $state: state,
      getSelectedPackage: null,
      setCalendar: vi.fn(({ startDate, endDate }) => {
        state.startDate = startDate
        state.endDate = endDate
      }),
    }),
  }
})

describe('Calendar.vue', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  function mountCalendar() {
    return mount(Calendar, {
      global: {
        stubs: {},
      },
    })
  }

  it('selects a date when clicking on a non-past day and opens tooltip', async () => {
    const wrapper = mountCalendar()
    // Find a clickable cell: search for a div with cursor-pointer and not disabled
    const cell = wrapper.findAll('.grid .cursor-pointer').find(el => !el.classes().includes('opacity-40'))
    expect(cell).toBeTruthy()
    await cell!.trigger('click')

    // Tooltip should be open
    expect(wrapper.find('[ref="tooltipRef"]').exists()).toBe(false)
    // Instead, check for tooltip container by style class
    expect(wrapper.find('.rounded-xl.border').exists()).toBe(true)
  })

  it('does not allow selecting past dates', async () => {
    const wrapper = mountCalendar()

    // Mark a cell as past by directly calling component method isPastDate
    const vm = wrapper.vm as any
    // Go to previous month to ensure there are past days in grid
    await wrapper.find('button').trigger('click')

    const pastCells = wrapper.findAll('.opacity-40')
    if (pastCells.length) {
      await pastCells[0].trigger('click')
    }

    // Ensure no selection class applied (bg-[#73BE5D] when selected)
    const selected = wrapper.findAll('.bg-\\[\\#73BE5D\\]')
    expect(selected.length).toBe(0)
  })

  it('toggles Tour Type dropdown and selects an option', async () => {
    const wrapper = mountCalendar()

    const typeBtn = wrapper.findAll('button').find(b => b.text().includes('Tour Type') || b.text().trim() === '')
    // open via the specific button by label association
    const allButtons = wrapper.findAll('button')
    const openType = allButtons[1]
    await openType.trigger('click')

    // options should render
    const option = wrapper.find('.dropdown-menu .dropdown-item')
    expect(option.exists()).toBe(true)

    await option.trigger('click')

    // dropdown should close
    expect(wrapper.find('.dropdown-menu').exists()).toBe(false)
  })

  it('warns when clicking Next without selecting a date', async () => {
    const wrapper = mountCalendar()

    // Spy on toast
    const { useToast } = await import('vue-toastification')
    const toast = useToast()
    const warnSpy = vi.spyOn(toast, 'warning')

    const nextBtn = wrapper.findAll('button').find(b => b.text().includes('Next'))
    expect(nextBtn).toBeTruthy()
    await nextBtn!.trigger('click')

    expect(warnSpy).toHaveBeenCalled()
  })

  it('stores selected date and emits next on Next click', async () => {
    const wrapper = mountCalendar()

    // Click a valid day
    const cell = wrapper.findAll('.grid .cursor-pointer').find(el => !el.classes().includes('opacity-40'))
    await cell!.trigger('click', { clientX: 50, clientY: 50 })

    // Mock booking store and toast already set above
    const nextBtn = wrapper.findAll('button').find(b => b.text().includes('Next'))
    await nextBtn!.trigger('click')

    // Emitted next
    expect(wrapper.emitted('next')).toBeTruthy()
  })
})
