<template>
  <div class="text-center text-red-500">
    Page not found!
    <router-link :to="{ path: '/' }">Home</router-link>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const redirectToHome = () => {
  router.push({ path: '/' });
};
</script>

<style scoped>
/* Add specific styles for this component */
</style>
