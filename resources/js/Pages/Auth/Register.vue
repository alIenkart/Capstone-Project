<template>

    <Head title="Register" />

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center">
        <div class="bg-white shadow-lg rounded-lg flex w-4/5 max-w-4xl overflow-hidden">
            <div class="w-2/5 bg-[#1E71B8] text-white flex flex-col items-center justify-center p-8">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-[#73BE5D] w-24 h-24 mb-4">
                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-500">
                                    <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                    <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5 text-gray-500 size-6">
                                        <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5 text-gray-500 size-6">
                                        <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-500 size-6">
                                <path d="M10.5 18.75a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" />
                                <path fill-rule="evenodd" d="M8.625.75A3.375 3.375 0 0 0 5.25 4.125v15.75a3.375 3.375 0 0 0 3.375 3.375h6.75a3.375 3.375 0 0 0 3.375-3.375V4.125A3.375 3.375 0 0 0 15.375.75h-6.75ZM7.5 4.125C7.5 3.504 8.004 3 8.625 3H9.75v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V3h1.125c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-6.75A1.125 1.125 0 0 1 7.5 19.875V4.125Z" clip-rule="evenodd" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-500">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-500">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
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
import LandingIndex from '../Landing/LandingIndex.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, computed } from 'vue';
import { useToast } from 'vue-toastification';

defineOptions({ layout: LandingIndex });

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