<template>
  <div class="relative" ref="dropdownRef">
    <label
      v-if="label"
      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2"
    >
      {{ label }}
    </label>

    <div
      @click="toggleDropdown"
      class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all cursor-pointer flex flex-wrap gap-2"
    >
      <template v-if="selectedValues.length">
        <span
          v-for="option in selectedValues"
          :key="option"
          class="bg-[#217093] text-white px-2 py-1 rounded-lg text-xs flex items-center gap-1"
        >
          {{ option }}
          <button
            @click.stop="removeOption(option)"
            class="text-white hover:text-red-200 font-bold"
          >
            ×
          </button>
        </span>
      </template>
      <span v-else class="text-slate-400">{{ placeholder }}</span>
    </div>

    <ul
      v-if="isOpen"
      class="absolute z-20 bg-white border-2 border-slate-200 mt-1 rounded-xl shadow-md w-full max-h-48 overflow-y-auto"
    >
      <li
        v-for="option in options"
        :key="option"
        class="px-4 py-2 text-sm cursor-pointer hover:bg-slate-100 flex items-center gap-2"
        @click.stop="toggleOption(option)"
      >
        <input
          type="checkbox"
          class="accent-[#217093]"
          :checked="selectedValues.includes(option)"
        />
        <span>{{ option }}</span>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from "vue";

const props = defineProps({
  options: {
    type: Array,
    required: true,
  },
  modelValue: {
    type: Array,
    default: () => [],
  },
  label: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "Select options",
  },
});

const emit = defineEmits(["update:modelValue"]);

const isOpen = ref(false);
const selectedValues = ref([...props.modelValue]);
const dropdownRef = ref(null);

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
}

const toggleOption = (option) => {
  const index = selectedValues.value.indexOf(option);
  if (index > -1) {
    selectedValues.value.splice(index, 1);
  } else {
    selectedValues.value.push(option);
  }
  emit("update:modelValue", [...selectedValues.value]);
}

const removeOption = (option) => {
  selectedValues.value = selectedValues.value.filter((o) => o !== option);
  emit("update:modelValue", [...selectedValues.value]);
}

const handleClickOutside = (e) => {
  if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
    isOpen.value = false;
  }
}

onMounted(() => document.addEventListener("click", handleClickOutside));
onBeforeUnmount(() =>
  document.removeEventListener("click", handleClickOutside)
);

watch(
  () => props.modelValue,
  (newVal) => {
    selectedValues.value = [...newVal];
  }
);
</script>
