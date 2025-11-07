<template>

    <Head title="Register" />

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: url('build/assets/registration_bg.jpg');">
        <div class="bg-white shadow-lg rounded-lg flex w-4/5 max-w-4xl overflow-hidden">
            <div class="w-2/5 bg-orange-500 text-white flex flex-col items-center justify-center p-8">
                <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0L6.343 16.657A8 8 0 1117.657 16.657z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-center mb-6">
                    To keep connected with us please login with your personal info
                </p>
                <Link :href="route('login')"
                    class="border border-white text-white px-8 py-2 rounded-full hover:bg-white hover:text-orange-500 transition duration-300">
                Log In
                </Link>
            </div>

            <div class="w-3/5 p-8">
                <h2 class="text-3xl font-bold text-orange-600 text-center mb-6">Create Account</h2>

                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <InputLabel for="email" value="Email:" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-1 10a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2v12z" />
                                </svg>
                            </div>
                            <TextInput id="email" type="email" class="mt-1 block w-full pl-10" v-model="form.email"
                                required placeholder="e.g. john12@gmail.com" />
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <div class="w-1/2">
                            <InputLabel for="first_name" value="First Name:" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.486 0 4.797.607 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <TextInput id="first_name" type="text" class="mt-1 block w-full pl-10"
                                    v-model="form.first_name" required placeholder="John" />
                            </div>
                        </div>

                        <div class="w-1/2">
                            <InputLabel for="last_name" value="Last Name:" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.486 0 4.797.607 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <TextInput id="last_name" type="text" class="mt-1 block w-full pl-10"
                                    v-model="form.last_name" required placeholder="Cordova" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel for="password" value="Password:" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <TextInput id="password" type="password" class="mt-1 block w-full pl-10"
                                v-model="form.password" required placeholder="********" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel for="password_confirmation" value="Confirm Password:" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full pl-10"
                                v-model="form.password_confirmation" required placeholder="********" />
                        </div>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <PrimaryButton
                            class="w-80 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-3xl flex justify-center items-center mx-auto"
                            :disabled="form.processing">
                            {{ otpSent ? 'Verify OTP' : 'Sign Up' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div v-if="showOtpModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold text-orange-600 mb-4 text-center">Enter OTP</h2>
            <p class="text-gray-600 text-sm text-center mb-4">
                Check your email for a 6-digit OTP code
            </p>
            <input type="text" v-model="otp" maxlength="6"
                class="w-full border border-gray-300 rounded px-4 py-2 text-center text-lg tracking-widest"
                placeholder="Enter OTP" />
            <div class="flex justify-between mt-6">
                <button @click="showOtpModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button @click="verifyOtp" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
                    Verify
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const otp = ref('');
const otpSent = ref(false);
const showOtpModal = ref(false);

const sendOtp = async () => {
    try {
        await axios.post('/send-otp', { email: form.email });
        otpSent.value = true;
        showOtpModal.value = true;
        toast.success('OTP has been sent to your email.');
    } catch (error) {
        toast.error(error.response?.data?.message || 'Failed to send OTP');
    }
};

const verifyOtp = async () => {
    try {
        const payload = {
            ...form.data(),
            otp_code: otp.value,
        };
        await axios.post('/verify-otp', payload);
        toast.success('Registration successful! Redirecting to login...');
        setTimeout(() => {
            window.location.href = '/login';
        }, 2000);
    } catch (error) {
        toast.error(error.response?.data?.message || 'Invalid OTP');
    }
};

const submit = () => {
    if (!otpSent.value) {
        sendOtp();
    } else {
        showOtpModal.value = true;
    }
};
</script>

<style scoped>
input:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 1px #f97316;
}
</style>