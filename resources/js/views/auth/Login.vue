<template>
  <div class="container mt-5">
    <h1 class="text-center">Login</h1>
    <form @submit.prevent="onSubmit" class="mx-auto mt-4" style="max-width: 400px">
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input v-model="email" type="email" id="email" required class="form-control">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input v-model="password" type="password" id="password" required class="form-control">
      </div>

      <button type="submit" class="btn btn-primary mt-3 w-100">Login</button>
    </form>

  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const { login, setNotification } = authStore;

const email = ref('');
const password = ref('');

const onSubmit = async () => {
  try {
    await login({ email: email.value, password: password.value });
    // Redirect to the dashboard upon successful login
    router.push('/dashboard');
  } catch (error) {
    // Handle login error
    setNotification(error.message, false);
  }
};
</script>

<style scoped>
/* Add specific styles for this component if needed */
</style>
