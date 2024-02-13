<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const redirectToHome = () => {
  router.push({ name: 'home' });
};
</script>

<template>
  <div class="text-center text-red-500">
    Page not found!
    <router-link @click="redirectToHome">Home</router-link>
  </div>
</template>

<style scoped>
/* Add specific styles for this component */
</style>
