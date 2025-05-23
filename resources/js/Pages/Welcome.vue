<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});


</script>

<template>
    <Head title="GuestPage" />
    <p>Hello World</p>

    <Link :href="route('login')">
        Log in
    </Link>

    <Link :href="route('register')">
        Register
    </Link>
</template>
