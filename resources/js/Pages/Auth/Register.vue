<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    contact_number: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('build/assets/registration_bg.jpg');">
        <div class="bg-white shadow-lg rounded-lg flex w-4/5 max-w-4xl overflow-hidden">
            <!-- Left Panel -->
            <div class="w-2/5 bg-orange-500 text-white flex flex-col items-center justify-center p-8">
                <!-- Location Pin Icon -->
                <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0L6.343 16.657A8 8 0 1117.657 16.657z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-center mb-6">To keep connected with us please login with your personal info</p>
                <Link :href="route('login')" class="border border-white text-white px-8 py-2 rounded-full hover:bg-white hover:text-orange-500 transition duration-300">
                    Log In
                </Link>
            </div>

            <!-- Right Panel (Form) -->
            <div class="w-3/5 p-8">
                <h2 class="text-3xl font-bold text-orange-600 text-center mb-6">Create Account</h2>

                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <InputLabel for="email" value="Email:" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-1 10a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2v12z"></path></svg>
                            </div>
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full pl-10"
                                v-model="form.email"
                                required
                                autocomplete="username"
                                placeholder="e.g. kurt@gmail.com"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="flex gap-4 mb-4">
                        <div class="w-1/2">
                            <InputLabel for="first_name" value="First Name:" />
                            <TextInput
                                id="first_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.first_name"
                                required
                                autofocus
                                autocomplete="first_name"
                                placeholder="e.g. Kurt"
                            />
                            <InputError class="mt-2" :message="form.errors.first_name" />
                        </div>
                        <div class="w-1/2">
                            <InputLabel for="last_name" value="Last Name:" />
                            <TextInput
                                id="last_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.last_name"
                                required
                                autocomplete="last_name"
                                placeholder="e.g. Manoot"
                            />
                            <InputError class="mt-2" :message="form.errors.last_name" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel for="contact_number" value="Contact Number:" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.135a11.042 11.042 0 005.516 5.516l1.134-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <TextInput
                                id="contact_number"
                                type="text"
                                class="mt-1 block w-full pl-10"
                                v-model="form.contact_number"
                                required
                                autocomplete="contact_number"
                                placeholder="e.g. 12345bacd"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.contact_number" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="password" value="Password:" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full pl-10"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                                placeholder="e.g. 12345bacd"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mb-4">
                        <InputLabel
                            for="password_confirmation"
                            value="Confirm Password:"
                        />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full pl-10"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="e.g. 12345bacd"
                            />
                        </div>
                        <InputError
                            class="mt-2"
                            :message="form.errors.password_confirmation"
                        />
                    </div>

                    <div class="mt-6 flex justify-center">
                        <PrimaryButton
                            class="w-80 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-3xl flex justify-center items-center mx-auto"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Sign Up
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
