<script setup>
import Navbar from './Includes/Navbar.vue';
import Footer from './Includes/Footer.vue';
</script>
<template>
        <Navbar />

        <!-- Content goes here -->
        <slot />


    <Footer />
</template>
