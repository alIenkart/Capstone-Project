<template>

    <Head title="Register" />

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center">
        <div class="bg-white shadow-lg rounded-lg flex w-4/5 max-w-4xl overflow-hidden">
            <div class="w-2/5 bg-[#1E71B8] text-white flex flex-col items-center justify-center p-8">
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
                    class="border border-[#73BE5D] text-white px-8 py-2 rounded-full bg-[#73BE5D] hover:bg-[#1E71B8] hover:text-white hover:border-white transition duration-300">
                Log In
                </Link>
            </div>

            <div class="w-3/5 p-8">
                <h2 class="text-3xl font-bold text-[#1E71B8] text-center mb-6">Create Account</h2>

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
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                                <TextInput id="last_name" type="text" class="mt-1 block w-full pl-10"
                                    v-model="form.last_name" required placeholder="Cordova" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                    <InputLabel for="phone_number" value="Contact Number:" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                        </div>
                        <TextInput
                            id="phone_number"
                            type="text"
                            maxlength="11"
                            class="mt-1 block w-full pl-10 py-2 border border-gray-300 rounded-md"
                            v-model="form.phone_number"
                            required
                            placeholder="09123456789"
                            @input="form.phone_number = form.phone_number.replace(/\D/g, '')"
                        />
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
                        <div class="text-sm mt-1" :class="{
                            'text-red-500': passwordStrength === 'Very Weak Password' || passwordStrength === 'Weak Password',
                            'text-yellow-500': passwordStrength === 'Moderate Password',
                            'text-green-500': passwordStrength === 'Strong Password'
                        }">
                            {{ passwordStrength }}
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
                            class="w-80 py-3 bg-[#1E71B8] hover:bg-[#73BE5D] text-white font-bold rounded-3xl flex justify-center items-center mx-auto"
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
import { ref, computed } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();
const otp = ref('');
const otpSent = ref(false);
const showOtpModal = ref(false);

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone_number: '',
    password: '',
    password_confirmation: '',
});

const passwordStrength = computed(() => {
    const pwd = form.password;
    if (!pwd) return '';

    let strength = 0;
    if (pwd.length >= 8) strength++;
    if (/[A-Z]/.test(pwd)) strength++;
    if (/[0-9]/.test(pwd)) strength++;
    if (/[^A-Za-z0-9]/.test(pwd)) strength++;

    switch (strength) {
        case 4: return 'Strong Password';
        case 3: return 'Moderate Password';
        case 2: return 'Weak Password';
        default: return 'Very Weak Password';
    }
});

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
    const email = form.email.trim();
    const firstName = form.first_name.trim();
    const phoneNumber = form.phone_number.trim();
    const password = form.password;
    const passwordConfirmation = form.password_confirmation;

    if (!email || !firstName || !phoneNumber || !password || !passwordConfirmation) {
        toast.error('Please fill in all required fields.');
        return;
    }

    if (password !== passwordConfirmation) {
        toast.error('Password and Confirm Password do not match.');
        return;
    }

    if (password.length < 8) {
        toast.error('Password must be at least 6 characters.');
        return;
    }

    const phoneDigits = phoneNumber.replace(/\D/g, '');
    if (phoneDigits.length !== 11) {
        toast.error('Contact Number must be exactly 11 digits.');
        return;
    }

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