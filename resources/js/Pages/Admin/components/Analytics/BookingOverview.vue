<template>
  <div class="space-y-10">

    <div
      v-for="(group, index) in bookingOverview"
      :key="index"
      class="space-y-8"
    >

      <!-- LEGEND -->
      <div class="flex">
        <div class="flex items-center gap-4 text-sm text-gray-600 ml-auto">
          <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-green-500"></span>
            Completed
          </div>
          <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
            Pending Payment
          </div>
        </div>
      </div>

      <!-- PACKAGE HEADER -->
      <div class="border-b pb-2">
        <h2 class="text-lg font-semibold text-gray-800">
          {{ group.package.name }}
        </h2>

        <p class="text-sm text-gray-500">
          Max Capacity: {{ group.package.capacity }} |
          Available Slot: {{ group.package.available_slot }}
        </p>
      </div>

      <!-- TYPES -->
      <div v-for="(items, type) in group.types" :key="type" class="space-y-6">

        <!-- TYPE HEADER -->
        <h3 class="text-md font-semibold text-gray-700">
          {{ type }}
        </h3>

        <!-- GROUP BY DATE (RESTORED) -->
        <div
          v-for="(dateGroup, date) in groupByDate(items)"
          :key="date"
          class="space-y-3"
        >

          <!-- DATE HEADER -->
          <h4 class="text-sm font-semibold text-gray-600">
            {{ formatDate(date) }}
          </h4>

          <!-- CARDS -->
          <div class="flex flex-wrap gap-4">

            <div
              v-for="(item, i) in dateGroup"
              :key="i"
              class="w-64 rounded-xl p-4 shadow-sm relative"
              :class="item.is_paid ? 'bg-green-50' : 'bg-yellow-50'"
            >

              <!-- STATUS DOT -->
              <span
                class="absolute top-3 right-3 w-3 h-3 rounded-full"
                :class="item.is_paid ? 'bg-green-500' : 'bg-yellow-400'"
              ></span>

              <!-- NAME -->
              <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                  👤
                </div>
                <p class="font-medium text-gray-800">
                  {{ item.customer_name }}
                </p>
              </div>

              <!-- PACKAGE INFO -->
              <p class="text-sm text-gray-700">
                Duration: {{ item.duration }} days
              </p>

              <!-- PAX -->
              <p class="text-sm text-gray-500">
                {{ item.total_quantity }} pax
              </p>

            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
const props = defineProps({
  bookingOverview: {
    type: Array,
    required: true,
  },
});

// GROUP BY DATE (RESTORED)
const groupByDate = (items) => {
  return items.reduce((acc, item) => {
    const date = item.start_date;

    if (!acc[date]) acc[date] = [];
    acc[date].push(item);

    return acc;
  }, {});
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
};
</script>