<template>
    <GuestLayout>

        <Head title="Log in" />

        <div class="mb-6 flex flex-col items-center">
            <img class="logo-img w-32 h-auto mb-4" src="/storage/logo/Logo.png" alt="JE Travel & Tours" />
            <h2 class="text-2xl font-bold text-[#1E71B8] mb-2">Login to your account.</h2>
            <p class="text-sm text-gray-600">Hello, welcome back to your account</p>
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <TextInput id="email" type="email" class="mt-1 block w-full pl-10" v-model="form.email" required
                        autofocus autocomplete="username" placeholder="e.g. johndoe12@gmail.com" />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mb-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <TextInput id="password" :type="showPassword ? 'text' : 'password'"
                        class="mt-1 block w-full pl-10 pr-10" v-model="form.password" required
                        autocomplete="current-password" placeholder="e.g. 12345bacd#" />
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400"
                        @click="showPassword = !showPassword" tabindex="-1">
                        <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex justify-between items-center mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>

                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="text-sm text-blue-600 hover:underline">
                Forgot password?
                </Link>
            </div>

            <div class="flex items-center justify-center mt-6">
                <PrimaryButton
                    class="w-48 py-3 bg-[#1E71B8] hover:bg-[#73BE5D] text-white font-bold rounded-3xl flex justify-center items-center"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log In
                </PrimaryButton>
            </div>

            <div class="text-center text-sm text-gray-600 mt-6">
                Don't have an account?
                <Link :href="route('register')" class="text-blue-600 hover:underline">
                Sign up
                </Link>
            </div>
        </form>
    </GuestLayout>
    <Footer></Footer>
</template>

<script setup>
import LandingIndex from '../Landing/LandingIndex.vue';
import Checkbox from '@/components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import { ref } from 'vue';
import Footer from '../Landing/Footer.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

defineOptions({ layout: LandingIndex });

const toast = useToast();
const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),

        onSuccess: () => {
            toast.success('Login successful!', {
                timeout: 3000,
                position: 'top-right',
            });
        },

        onError: (errors) => {
            if (errors.email?.includes('not verified')) {
                toast.warning('Your email is not verified. A verification link has been sent.', {
                    timeout: 5000,
                    position: 'top-right',
                });
            } else {
                toast.error('Login failed. Please check your credentials.', {
                    timeout: 4000,
                    position: 'top-right',
                });
            }
        },
    });
};
</script>