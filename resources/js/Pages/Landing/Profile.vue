<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="w-full h-48 bg-gradient-to-r from-[#1E71B8] to-[#2582cc] relative overflow-hidden">
      <div class="absolute inset-0 opacity-40">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS1vcGFjaXR5PSIwLjA1IiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')"></div>
      </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 -mt-24 pb-16">
      <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 backdrop-blur-sm border border-slate-100">
        <div class="relative p-8 sm:p-10 overflow-visible">
          <div class="absolute -top-20 left-8 z-10">
            <div class="relative group">
              <div class="absolute inset-0 bg-gradient-to-br from-[#1E71B8] to-[#2582cc] rounded-full blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
              <img
                :src="selectedAvatar"
                alt="Profile"
                class="relative w-36 h-36 sm:w-44 sm:h-44 rounded-full object-cover border-4 border-white shadow-2xl"
              />
              <button
                @click="showAvatarModal = true"
                type="button"
                class="absolute bottom-1 right-1 bg-white hover:bg-slate-50 text-[#1E71B8] p-2.5 rounded-full shadow-lg border border-slate-200 transition-all hover:scale-105 active:scale-95"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 20h9" />
                  <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                </svg>
              </button>
            </div>
          </div>

          <div class="sm:pl-52 pt-20 sm:pt-4">
            <div class="flex items-center justify-between gap-4 mb-8">
              <div>
                <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent mb-2">
                  Profile Details
                </h1>
                <p class="text-slate-500 text-sm">Manage your personal information</p>
              </div>
              <button
                v-if="!isEditing"
                @click="isEditing = true"
                type="button"
                class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-[#1E71B8] to-[#2582cc] text-white rounded-xl shadow-lg shadow-blue-200/50 hover:shadow-xl hover:shadow-blue-300/50 transition-all hover:scale-105 active:scale-95 font-medium"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 20h9" />
                  <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                </svg>
                Edit Profile
              </button>
            </div>

            <div class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-700">
                    First Name
                  </label>
                  <input
                    v-model="firstName"
                    type="text"
                    :disabled="!isEditing"
                    class="w-full rounded-xl border-2 border-slate-200 focus:border-[#1E71B8] focus:ring-4 focus:ring-blue-50 px-4 py-3 outline-none transition-all disabled:bg-slate-50 disabled:text-slate-500"
                    placeholder="John"
                  />
                </div>

                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-700">
                    Last Name
                  </label>
                  <input
                    v-model="lastName"
                    type="text"
                    :disabled="!isEditing"
                    class="w-full rounded-xl border-2 border-slate-200 focus:border-[#1E71B8] focus:ring-4 focus:ring-blue-50 px-4 py-3 outline-none transition-all disabled:bg-slate-50 disabled:text-slate-500"
                    placeholder="Doe"
                  />
                </div>

                <div class="space-y-2 md:col-span-2">
                  <label class="block text-sm font-semibold text-slate-700">
                    Email Address
                  </label>
                  <input
                    v-model="email"
                    type="email"
                    :disabled="!isEditing"
                    class="w-full rounded-xl border-2 border-slate-200 focus:border-[#1E71B8] focus:ring-4 focus:ring-blue-50 px-4 py-3 outline-none transition-all disabled:bg-slate-50 disabled:text-slate-500"
                    placeholder="name@example.com"
                  />
                </div>

                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-700">
                    Phone Number
                  </label>
                  <input
                    v-model="phone"
                    type="tel"
                    :disabled="!isEditing"
                    class="w-full rounded-xl border-2 border-slate-200 focus:border-[#1E71B8] focus:ring-4 focus:ring-blue-50 px-4 py-3 outline-none transition-all disabled:bg-slate-50 disabled:text-slate-500"
                    placeholder="+63XXXXXXXXXX"
                  />
                </div>

                <div class="space-y-2">
                  <label class="block text-sm font-semibold text-slate-700">
                    Password
                  </label>
                  <input
                    v-model="password"
                    type="password"
                    :disabled="!isEditing"
                    class="w-full rounded-xl border-2 border-slate-200 focus:border-[#1E71B8] focus:ring-4 focus:ring-blue-50 px-4 py-3 outline-none transition-all disabled:bg-slate-50 disabled:text-slate-500"
                    placeholder="••••••••••"
                  />
                </div>
              </div>

              <div v-if="isEditing" class="flex gap-3 pt-4 border-t border-slate-100">
                <button
                  @click="isEditing = false"
                  type="button"
                  class="flex-1 sm:flex-none px-6 py-3 bg-white border-2 border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all hover:scale-105 active:scale-95"
                >
                  Cancel
                </button>
                <button
                  @click="saveChanges"
                  type="button"
                  class="flex-1 sm:flex-none px-8 py-3 bg-gradient-to-r from-[#1E71B8] to-[#2582cc] text-white rounded-xl shadow-lg shadow-blue-200/50 hover:shadow-xl hover:shadow-blue-300/50 font-semibold transition-all hover:scale-105 active:scale-95"
                >
                  Save Changes
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div v-if="showAvatarModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click="showAvatarModal = false">
      <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden" @click.stop>
        <div class="bg-gradient-to-r from-[#1E71B8] to-[#2582cc] px-6 py-5 flex items-center justify-between">
          <h2 class="text-2xl font-bold text-white">Choose Your Avatar</h2>
          <button @click="showAvatarModal = false" type="button" class="text-white hover:bg-white/20 rounded-full p-2 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 6L6 18M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <div class="p-6 overflow-y-auto max-h-[calc(80vh-80px)]">
          <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
            <button
              v-for="avatar in avatarOptions"
              :key="avatar"
              @click="selectAvatar(avatar)"
              type="button"
              class="relative group"
            >
              <div class="absolute inset-0 bg-gradient-to-br from-[#1E71B8] to-[#2582cc] rounded-2xl blur opacity-0 group-hover:opacity-20 transition-opacity"></div>
              <img
                :src="avatar"
                :alt="`Avatar option`"
                :class="[
                  'relative w-full aspect-square rounded-2xl object-cover border-3 transition-all',
                  selectedAvatar === avatar 
                    ? 'border-4 border-[#1E71B8] ring-4 ring-blue-100' 
                    : 'border-2 border-slate-200 hover:border-[#1E71B8] hover:scale-105'
                ]"
              />
              <div v-if="selectedAvatar === avatar" class="absolute top-2 right-2 bg-[#1E71B8] text-white rounded-full p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                  <path d="M20 6L9 17l-5-5" />
                </svg>
              </div>
            </button>
          </div>
        </div>
        
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
          <button
            @click="showAvatarModal = false"
            type="button"
            class="px-6 py-2.5 bg-white border-2 border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all"
          >
            Cancel
          </button>
          <button
            @click="confirmAvatar"
            type="button"
            class="px-6 py-2.5 bg-gradient-to-r from-[#1E71B8] to-[#2582cc] text-white rounded-xl shadow-lg shadow-blue-200/50 hover:shadow-xl hover:shadow-blue-300/50 font-semibold transition-all"
          >
            Save Avatar
          </button>
        </div>
      </div>
    </div>
    
    <Footer></Footer>
  </div>
</template>

<script setup>
import LandingIndex from "./LandingIndex.vue";
import { usePage, router } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import { useToast } from "vue-toastification";
import Footer from "./Footer.vue";
import { api } from "@/api/api";


defineOptions({ layout: LandingIndex });
const page = usePage();
const user = computed(() => page.props.auth?.user);
const toast = useToast();

const firstName = ref("");
const lastName = ref("");
const email = ref("");
const phone = ref("");
const password = ref("password");
const isEditing = ref(false);
const showAvatarModal = ref(false);
const selectedAvatar = ref("https://api.dicebear.com/9.x/bottts-neutral/svg?seed=cutiepie");
const service = new api();
const form = ref({ user });

const avatarOptions = [
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=cutiepie",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=sweetie",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=bubbles",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=sunshine",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=cookie",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=muffin",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=cupcake",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=sprinkles",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=honeybee",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=buttercup",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=marshmallow",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=jellybean",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=peaches",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=blossom",
  "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=bambi"
];

const selectAvatar = (avatar) => {
  selectedAvatar.value = avatar;
};

const confirmAvatar = async () => {
  try {
    if (user.value?.id) {
      form.value.user.avatar = selectedAvatar.value
      const payload = { ...form.value.user };
      await service.updateUser(user.value.id, payload);
      showAvatarModal.value = false;
      toast.success("Avatar updated successfully!");
      router.reload();
    }
  } catch (error) {
    console.error(error);
    toast.error("Failed to update avatar");
  }
};

const saveChanges = async () => {
  try {
    if (!user.value?.id) return;

    const payload = preparePayload();

    await service.updateUser(user.value.id, payload);

    isEditing.value = false;
    toast.success("Profile updated successfully!");
    router.reload();
  } catch (e) {
    console.error(e);
    toast.error(e.response?.data?.message || "Failed to update profile");
  }
};

const preparePayload = () => {
  return {
    first_name: firstName.value?.trim(),
    last_name: lastName.value?.trim(),
    email: email.value?.trim(),
    phone_number: phone.value?.trim(),
    role: user.value?.role,
    avatar: selectedAvatar.value,
    ...(password.value
      ? {
          password: password.value,
          password_confirmation: password.value
        }
      : {})
  };
};

onMounted(() => {
  firstName.value = user?.value?.first_name ?? "";
  lastName.value = user?.value?.last_name ?? "";
  email.value = user?.value?.email ?? "";
  phone.value = user?.value?.phone_number ?? "";
  selectedAvatar.value = user?.value?.avatar ?? "https://api.dicebear.com/9.x/bottts-neutral/svg?seed=cutiepie";
});
</script>
