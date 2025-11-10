<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-md transition-opacity" @click="closeModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all sm:my-8 w-full max-w-7xl">
                <button type="button" class="absolute right-4 top-4 z-10 rounded-full p-2 text-white/80 hover:text-white hover:bg-white/20 transition-all" @click="closeModal">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="bg-gradient-to-r from-[#217093] to-[#2a8bb5] px-8 py-8">
                    <h3 class="text-3xl font-bold text-white tracking-tight">New Package</h3>
                    <p class="mt-2 text-white/80 text-sm">Create a new travel package with detailed information</p>
                </div>

                <form @submit.prevent="savePackage" class="px-8 py-8 max-h-[calc(100vh-280px)] overflow-y-auto bg-gradient-to-br from-slate-50 to-white">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="space-y-6">
                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Package Image</h4>
                                </div>
                                <div class="relative flex items-center justify-center border-2 border-dashed rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 p-8 text-slate-500 cursor-pointer hover:text-[#217093] hover:border-[#217093] hover:bg-gradient-to-br hover:from-blue-50 hover:to-slate-50 transition-all group" :class="imagePreview ? 'border-[#217093] bg-white' : 'border-slate-300'">
                                    <label for="imageUpload" class="flex flex-col items-center justify-center w-full cursor-pointer">
                                        <template v-if="imagePreview">
                                            <div class="relative w-full">
                                                <img :src="imagePreview" alt="Preview" class="w-full h-72 object-cover rounded-xl shadow-2xl ring-4 ring-[#217093]/20" />
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                                                    <span class="text-white font-semibold text-sm bg-[#217093] px-4 py-2 rounded-full shadow-lg">Click to change</span>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="p-5 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl mb-4 group-hover:from-[#217093]/20 group-hover:to-blue-200 transition-all shadow-inner">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <span class="text-base font-bold text-slate-700 group-hover:text-[#217093] mb-1">Upload Package Image</span>
                                            <span class="text-xs text-slate-400">PNG, JPG • Max 10MB</span>
                                        </template>
                                        <input type="file" id="imageUpload" class="hidden" accept="image/*" @change="handleImageUpload" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Package Information</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="md:col-span-2">
                                        <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Package Name*</label>
                                        <input type="text" id="name" v-model="formData.name" class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all" placeholder="e.g., Paradise Island Getaway" required />
                                    </div>

                                    <DateRangePicker v-model:modelValueStart="formData.startDate" v-model:modelValueEnd="formData.endDate" @update:modelValueStart="onStartDateChange" @update:modelValueEnd="onEndDateChange" />

                                    <div>
                                        <label for="destination" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Destination</label>
                                        <input type="text" id="destination" v-model="formData.destination" class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all" placeholder="e.g., Boracay" />
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="region" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Region</label>
                                        
                                        <div class="relative" ref="regionDropdown">
                                            <button type="button" @click="isRegionFilterOpen = !isRegionFilterOpen" class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                                <span class="font-semibold text-gray-800">{{ formData.region === '' ? 'Select region' : formData.region }}</span>
                                                <svg :class="['w-5 h-5 text-blue-600 transition-transform duration-300', isRegionFilterOpen ? 'rotate-180' : '']" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                </svg>
                                            </button>

                                            <div v-if="isRegionFilterOpen" class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden max-h-96 overflow-y-auto">
                                                <div @click="handleRegionSelect('')" :class="['px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 sticky top-0 bg-white hover:bg-blue-50', formData.region === '' ? 'bg-blue-50 border-l-4 border-l-blue-500' : '']">
                                                    <span :class="['font-medium', formData.region === '' ? 'text-blue-700' : 'text-gray-700']">All Regions</span>
                                                    <svg v-if="formData.region === ''" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>

                                                <div v-for="region in regionOptions" :key="region" @click="handleRegionSelect(region)" :class="['px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 hover:bg-blue-50', formData.region === region ? 'bg-blue-50 border-l-4 border-l-blue-500' : '']">
                                                    <span :class="['font-medium', formData.region === region ? 'text-blue-700' : 'text-gray-700']">{{ region }}</span>
                                                    <svg v-if="formData.region === region" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <MultiSelectDropdown label="Tour Classification" :options="['Land Travel', 'Water Adventure', 'Air Travel']" v-model="formData.tourClassification" placeholder="Select Classification" />
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Pricing Information</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <div>
                                        <label for="basePrice" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Base Price per Pax*</label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-lg">₱</span>
                                            <input type="number" id="basePrice" v-model="formData.basePrice" class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all" placeholder="0.00" required />
                                        </div>
                                    </div>
                                    <div>
                                        <label for="kidsBasePrice" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kids Price per Pax</label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-lg">₱</span>
                                            <input type="number" id="kidsBasePrice" v-model="formData.kidsBasePrice" class="w-full rounded-xl border-2 border-emerald-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all" placeholder="0.00" />
                                        </div>
                                    </div>
                                    <div>
                                        <label for="discountedRate" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Discounted Rate</label>
                                        <div class="relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-slate-400">
                                                <path fill-rule="evenodd" d="M11.99 2.243a4.49 4.49 0 0 0-3.398 1.55 4.49 4.49 0 0 0-3.497 1.306 4.491 4.491 0 0 0-1.307 3.498 4.491 4.491 0 0 0-1.548 3.397c0 1.357.6 2.573 1.548 3.397a4.491 4.491 0 0 0 1.307 3.498 4.49 4.49 0 0 0 3.498 1.307 4.49 4.49 0 0 0 3.397 1.549 4.49 4.49 0 0 0 3.397-1.549 4.49 4.49 0 0 0 3.497-1.307 4.491 4.491 0 0 0 1.306-3.497 4.491 4.491 0 0 0 1.55-3.398c0-1.357-.601-2.573-1.549-3.397a4.491 4.491 0 0 0-1.307-3.498 4.49 4.49 0 0 0-3.498-1.307 4.49 4.49 0 0 0-3.396-1.549Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6Zm-5.78-.905a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm4.5 4.5a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" clip-rule="evenodd" />
                                            </svg>
                                            <input type="number" id="discountedRate" v-model="formData.discountedRate" class="w-full rounded-xl border-2 border-emerald-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all" placeholder="0" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Package Settings</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="maxOccupancy" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Maximum Occupancy</label>
                                        <input type="number" id="maxOccupancy" v-model="formData.maxOccupancy" class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all" placeholder="0" />
                                    </div>

                                    <div class="relative" ref="statusDropdown">
                                        <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                                        <button type="button" @click="isStatusOpen = !isStatusOpen" class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                            <span class="font-semibold text-gray-800">{{ formData.status }}</span>
                                            <svg :class="['w-5 h-5 text-blue-600 transition-transform duration-300', isStatusOpen ? 'rotate-180' : '']" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                        </button>

                                        <div v-if="isStatusOpen" class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
                                            <div @click="handleStatusSelect('Active')" :class="['px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 hover:bg-blue-50', formData.status === 'Active' ? 'bg-blue-50 border-l-4 border-l-blue-500' : '']">
                                                <span :class="['font-medium', formData.status === 'Active' ? 'text-blue-700' : 'text-gray-700']">Active</span>
                                                <svg v-if="formData.status === 'Active'" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div @click="handleStatusSelect('Inactive')" :class="['px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50', formData.status === 'Inactive' ? 'bg-blue-50 border-l-4 border-l-blue-500' : '']">
                                                <span :class="['font-medium', formData.status === 'Inactive' ? 'text-blue-700' : 'text-gray-700']">Inactive</span>
                                                <svg v-if="formData.status === 'Inactive'" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Description*</h4>
                                </div>
                                <textarea id="description" v-model="formData.description" rows="5" class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none" placeholder="Describe the package in detail. What makes it special? What experiences await?" required></textarea>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center gap-3">
                                        <h4 class="text-xl font-bold text-slate-800">Itinerary*</h4>
                                    </div>
                                    <div class="text-sm font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">
                                        {{ itineraryDays.length }} / {{ maxItineraryDays }} {{ itineraryDays.length === 1 ? 'Day' : 'Days' }}
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <TransitionGroup name="list">
                                        <div v-for="(day, index) in itineraryDays" :key="day.id" class="bg-white border-2 border-blue-200 rounded-xl p-5 hover:border-blue-400 transition-all shadow-sm hover:shadow-md">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center gap-3">
                                                    <h4 class="text-lg font-bold text-slate-800">Day {{ day.id }}</h4>
                                                </div>
                                                <button v-if="itineraryDays.length > 1" type="button" @click="removeItineraryDay(day.id)" class="p-2 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-600 transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <textarea v-model="day.content" :placeholder="`Describe the activities and highlights for Day ${day.id}...`" rows="4" class="w-full rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 px-4 py-3 text-sm outline-none transition-all resize-none"></textarea>
                                        </div>
                                    </TransitionGroup>

                                    <div v-if="isAddDayButtonDisabled" class="group relative">
                                        <button type="button" disabled class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-gradient-to-r from-slate-300 to-slate-400 text-white text-sm font-bold rounded-xl cursor-not-allowed opacity-60 shadow-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add Another Day
                                        </button>
                                        <div class="opacity-0 group-hover:opacity-100 absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-2 bg-slate-800 text-white text-xs rounded-lg whitespace-nowrap transition-opacity z-10 pointer-events-none">
                                            <span v-if="!formData.startDate || !formData.endDate">Please select start and end dates first</span>
                                            <span v-else>Maximum {{ maxItineraryDays }} days reached</span>
                                        </div>
                                    </div>

                                    <button v-else type="button" @click="addItineraryDay" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Another Day
                                    </button>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Terms & Conditions*</h4>
                                </div>
                                <textarea id="termsCondition" v-model="formData.termsCondition" rows="5" class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none" placeholder="Enter terms and conditions that apply to this package..."></textarea>
                            </div>

                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Exclusions*</h4>
                                </div>
                                <textarea id="exclusions" v-model="formData.exclusions" rows="5" class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none" placeholder="List what's not included in the package (e.g., airfare, meals, activities)..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="bg-gradient-to-r from-slate-50 to-white px-8 py-6 border-t-2 border-slate-200">
                    <div class="flex justify-end gap-3">
                        <button type="button" class="flex items-center gap-2 rounded-xl px-7 py-3 text-sm font-bold bg-slate-600 text-white hover:bg-slate-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0" @click="closeModal">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" @click="savePackage" class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#217093] to-[#2a8bb5] hover:from-[#1a5a7a] hover:to-[#217093] px-7 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Create Package
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, computed } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import MultiSelectDropdown from '@/components/MultiSelectDropdown.vue'
import DateRangePicker from './Analytics/DateRangePicker.vue'

const props = defineProps({
    show: {
        type: Boolean,
        required: true
    }
})

const toast = useToast()
const emit = defineEmits(['close', 'save'])

const formData = ref({
    image: null,
    name: '',
    startDate: '',
    endDate: '',
    destination: '',
    region: '',
    description: '',
    itinerary: '',
    termsCondition: '',
    exclusions: '',
    basePrice: '',
    kidsBasePrice: '',
    maxOccupancy: '',
    status: 'Active',
    discountedRate: '',
    tourClassification: []
})

const itineraryDays = ref([
    { id: 1, content: '' }
])

const imagePreview = ref(null)
const isStatusOpen = ref(false)
const isRegionFilterOpen = ref(false)
const statusDropdown = ref(null)
const regionDropdown = ref(null)

const regionOptions = ref([
    'National Capital Region (NCR)',
    'Cordillera Administrative Region (CAR)',
    'Region I: Ilocos Region',
    'Region II: Cagayan Valley',
    'Region III: Central Luzon',
    'Region IV-A: Calabarzon (CALABARZON)',
    'Region IV-B: Mimaropa (MIMAROPA)',
    'Region V: Bicol Region',
    'Region VI: Western Visayas',
    'Region VII: Central Visayas',
    'Region VIII: Eastern Visayas',
    'Region IX: Zamboanga Peninsula',
    'Region X: Northern Mindanao',
    'Region XI: Davao Region',
    'Region XII: SOCCSKSARGEN',
    'Region XIII: Caraga',
    'BARMM: Bangsamoro Autonomous Region in Muslim Mindanao'
])

const maxItineraryDays = computed(() => {
    if (formData.value.startDate && formData.value.endDate) {
        const startParts = formData.value.startDate.split('-')
        const endParts = formData.value.endDate.split('-')
        
        const start = new Date(parseInt(startParts[0]), parseInt(startParts[1]) - 1, parseInt(startParts[2]))
        const end = new Date(parseInt(endParts[0]), parseInt(endParts[1]) - 1, parseInt(endParts[2]))
        
        const oneDay = 1000 * 60 * 60 * 24
        const diffDays = Math.floor((end - start) / oneDay) + 1
        return diffDays > 0 ? diffDays : 0
    }
    return 0
})

const isAddDayButtonDisabled = computed(() => {
    return !formData.value.startDate || !formData.value.endDate || (itineraryDays.value.length >= maxItineraryDays.value && maxItineraryDays.value > 0)
})

watch(() => props.show, (newValue) => {
    if (newValue) {
        formData.value = {
            image: null,
            name: '',
            startDate: '',
            endDate: '',
            destination: '',
            region: '',
            description: '',
            itinerary: '',
            tourClassification: [],
            termsCondition: '',
            exclusions: '',
            basePrice: '',
            kidsBasePrice: '',
            maxOccupancy: '',
            status: 'Active',
            discountedRate: ''
        }
        itineraryDays.value = [{ id: 1, content: '' }]
        imagePreview.value = null
        isStatusOpen.value = false
        isRegionFilterOpen.value = false
    }
})

watch([() => formData.value.startDate, () => formData.value.endDate], () => {
    adjustItineraryDays()
})

const closeModal = () => {
    emit('close')
}

const onStartDateChange = () => {
    adjustItineraryDays()
}

const onEndDateChange = () => {
    adjustItineraryDays()
}

const adjustItineraryDays = () => {
    const currentDays = itineraryDays.value.length
    const maxDays = maxItineraryDays.value

    if (maxDays > 0 && currentDays > maxDays) {
        itineraryDays.value = itineraryDays.value.slice(0, maxDays)
        itineraryDays.value.forEach((day, index) => {
            day.id = index + 1
        })
        toast.warning(`Itinerary reduced to ${maxDays} days based on your date range.`)
    }
}

const savePackage = async () => {
    if (!formData.value.name || !formData.value.basePrice || !formData.value.startDate || !formData.value.endDate) {
        toast.error('Please fill in Package Name, Base Price, Start Date, and End Date.')
        return
    }

    const startDate = new Date(formData.value.startDate)
    const endDate = new Date(formData.value.endDate)

    if (startDate > endDate) {
        toast.error('Start Date must be before End Date.')
        return
    }

    const duration = calculateDuration()

    if (duration <= 0) {
        toast.error('Please select a valid date range.')
        return
    }

    const data = new FormData()
    if (formData.value.image) {
        data.append('image', formData.value.image)
    }
    data.append('package_name', formData.value.name)
    data.append('start_date', formData.value.startDate)
    data.append('end_date', formData.value.endDate)
    data.append('tour_duration', duration.toString())
    data.append('destination', formData.value.destination)
    data.append('region', formData.value.region || '')
    data.append('description', formData.value.description || '')
    data.append('terms_condition', formData.value.termsCondition || '')
    data.append('exclusions', formData.value.exclusions || '')
    data.append('capacity', formData.value.maxOccupancy ? parseInt(formData.value.maxOccupancy) : 0)
    data.append('status', formData.value.status.toLowerCase())
    data.append('pax_rate', formData.value.basePrice ? parseFloat(formData.value.basePrice) : 0)
    data.append('kids_pax_rate', formData.value.kidsBasePrice ? parseFloat(formData.value.kidsBasePrice) : '')
    data.append('discounted_rate', formData.value.discountedRate ? parseFloat(formData.value.discountedRate) : 0)

    const formattedItinerary = {}
    itineraryDays.value.forEach(day => {
        formattedItinerary[`day_${day.id}`] = day.content
    })
    data.append('itinerary', JSON.stringify(formattedItinerary))
    data.append('tour_classification', JSON.stringify(formData.value.tourClassification))

    try {
        const response = await axios.post('/api/packages', data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        toast.success('Package created successfully!')
        emit('save', response.data.data)
        closeModal()
    } catch (error) {
        console.error('Error creating package:', error.response?.data || error)
        if (error.response && error.response.data && error.response.data.errors) {
            let errorMessages = 'Validation Errors:\n'
            for (const field in error.response.data.errors) {
                errorMessages += `- ${field}: ${error.response.data.errors[field].join(', ')}\n`
            }
            toast.error('Error creating package:\n' + errorMessages)
        } else {
            toast.error('Error creating package. Please check the console for details.')
        }
    }
}

const handleImageUpload = (event) => {
    const file = event.target.files[0]
    formData.value.image = file
    if (file) {
        imagePreview.value = URL.createObjectURL(file)
    } else {
        imagePreview.value = null
    }
}

const calculateDuration = () => {
    if (formData.value.startDate && formData.value.endDate) {
        const startParts = formData.value.startDate.split('-')
        const endParts = formData.value.endDate.split('-')
        
        const start = new Date(parseInt(startParts[0]), parseInt(startParts[1]) - 1, parseInt(startParts[2]))
        const end = new Date(parseInt(endParts[0]), parseInt(endParts[1]) - 1, parseInt(endParts[2]))
        
        const oneDay = 1000 * 60 * 60 * 24
        const timeDiff = end - start
        
        const diffDays = Math.floor(timeDiff / oneDay) + 1
        
        return diffDays > 0 ? diffDays : 0
    }
    return 0
}

const handleStatusSelect = (value) => {
    formData.value.status = value
    isStatusOpen.value = false
}

const handleRegionSelect = (region) => {
    formData.value.region = region
    isRegionFilterOpen.value = false
}

const addItineraryDay = () => {
    if (!formData.value.startDate || !formData.value.endDate) {
        toast.error('Please select start and end dates first.')
        return
    }

    if (isAddDayButtonDisabled.value) {
        toast.error(`Maximum ${maxItineraryDays.value} days allowed for this date range.`)
        return
    }

    const newDayNumber = itineraryDays.value.length + 1
    itineraryDays.value.push({ id: newDayNumber, content: '' })
}

const removeItineraryDay = (dayId) => {
    if (itineraryDays.value.length <= 1) {
        toast.warning('You must have at least one day in the itinerary.')
        return
    }

    itineraryDays.value = itineraryDays.value.filter(day => day.id !== dayId)

    itineraryDays.value.forEach((day, index) => {
        day.id = index + 1
    })
}

onMounted(() => {
    document.addEventListener('click', (e) => {
        if (statusDropdown.value && !statusDropdown.value.contains(e.target)) {
            isStatusOpen.value = false
        }
        if (regionDropdown.value && !regionDropdown.value.contains(e.target)) {
            isRegionFilterOpen.value = false
        }
    })
});
</script>

<style scoped>
.list-enter-active,
.list-leave-active {
    transition: all 0.3s ease;
}

.list-enter-from {
    opacity: 0;
    transform: translateY(-20px);
}

.list-leave-to {
    opacity: 0;
    transform: translateX(20px);
}

.list-move {
    transition: transform 0.3s ease;
}
</style>