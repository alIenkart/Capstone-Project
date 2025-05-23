<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});


</script>

<template>
    <Head title="Welcome" />
    <p>Hello World</p>

    <Link :href="route('login')">
        Log in
    </Link>

    <Link :href="route('register')">
        Register
    </Link>
</template>
