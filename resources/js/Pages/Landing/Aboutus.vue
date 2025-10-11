<script setup>
import LandingIndex from './LandingIndex.vue'
defineOptions({ layout: LandingIndex })
</script>

<template>
    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-start">
            <div class="rounded-xl overflow-hidden shadow ring-1 ring-gray-200/60 bg-gray-50">
                <img
                    src="/storage/about-us/about1.jpg"
                    class="w-full h-full object-cover aspect-[4/3] md:aspect-[4/5]"
                    loading="lazy"
                />
            </div>

            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-semibold tracking-wide text-[#1E71B8] uppercase">About Us</h2>
                    <div class="mt-2 h-0.5 w-32 bg-sky-500"></div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-[#000000] uppercase">Mission</h3>
                    <p class="text-[#000000] text-base leading-relaxed">
                        To bring every Filipino closer to their dream destinations by making
                        travel simple, affordable, and unforgettable.
                    </p>
                </div>

                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-[#000000] uppercase">Vision</h3>
                    <p class="text-[#000000] text-base leading-relaxed">
                        To become a leading travel agency in the Philippines, recognized for
                        integrity, customer satisfaction, and innovation in providing affordable
                        travel experiences both at home and abroad.
                    </p>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-[#000000] uppercase">Why Must Choose Us</h3>
                    <ul class="list-disc pl-6 space-y-2 text-[#000000] text-base">
                        <li>Affordable, All-In-One Packages</li>
                        <li>Reliable and Personalized Service</li>
                        <li>Strong Industry Partnerships</li>
                        <li>Supportive of Local Tourism</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-12 lg:pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-start">
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold tracking-wide text-[#1E71B8] uppercase">Our Story</h2>
                    <div class="mt-2 h-0.5 w-32 bg-sky-500"></div>
                </div>

                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-[#1E71B8]">Ms. Dorie Anne Magbojos</h3>
                    <p class="text-[#000000] font-base">Owner of JE Travel and Tours | Traveller Laguna</p>
                </div>

                <p class="text-[#000000] text-base leading-relaxed">
                    Traveller Laguna, founded in 2018 and located at Biñan, Laguna, offers both local tour packages, ensuring smooth and convenient travel booking for customers. With years of experience in the industry, Traveller Laguna has built a strong reputation for reliable, hands-on, and customer-centered services with complete transparency in every transaction.
                </p>
            </div>

            <div class="rounded-2xl overflow-hidden shadow ring-1 ring-gray-200/60 bg-gray-50 justify-self-center md:justify-self-end">
                <img
                    src="/storage/about-us/about2.jpg"
                    class="w-72 h-72 md:w-[380px] md:h-[380px] object-cover"
                    loading="lazy"
                />
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-16 lg:pb-24">
        <div class="space-y-8">
            <div class="text-center">
                <h2 class="text-2xl font-semibold tracking-wide text-[#1E71B8] uppercase">Accreditation</h2>
                <div class="mx-auto mt-2 h-0.5 w-32 bg-sky-500"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 md:gap-8 justify-items-center">
                <div class="flex items-center justify-center rounded-xl border border-gray-200 bg-white shadow-sm h-64 w-64 overflow-hidden">
                    <img src="/storage/accreditation/philtoa-accreditation.png" alt="Accreditation 1" class="h-full w-full object-contain" loading="lazy" />
                </div>
                <div class="flex items-center justify-center rounded-xl border border-gray-200 bg-white shadow-sm h-64 w-64 overflow-hidden">
                    <img src="/storage/accreditation/PTAA-accreditation.png" alt="Accreditation 2" class="h-full w-full object-contain" loading="lazy" />
                </div>
                <div class="flex items-center justify-center rounded-xl border border-gray-200 bg-white shadow-sm h-64 w-64 overflow-hidden">
                    <img src="/storage/accreditation/tcp-accreditation.png" alt="Accreditation 3" class="h-full w-full object-contain" loading="lazy" />
                </div>
            </div>
        </div>
    </section>
</template>