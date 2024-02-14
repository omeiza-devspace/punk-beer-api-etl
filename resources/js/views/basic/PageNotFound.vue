<template>
  <div class="container mx-auto text-center text-danger">
    <p class="mb-4">Page not found!</p>
    <router-link @click="redirectToHome" class="btn btn-danger">Home</router-link>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const redirectToHome = () => {
  router.push({ name: 'home' });
};
</script>

<style scoped>
/* Add specific styles for this component */
.container {
  margin-top: 20px;
}
</style>
