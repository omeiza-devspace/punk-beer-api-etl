<template>
  <div class="container mt-5">
    <h1 class="text-center">Register</h1>
    <form @submit.prevent="onSubmit" class="mx-auto mt-4" style="max-width: 400px">
      <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input v-model="name" type="text" id="name" required class="form-control">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input v-model="email" type="email" id="email" required class="form-control">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input v-model="password" type="password" id="password" required class="form-control">
      </div>

      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password:</label>
        <input v-model="confirmPassword" type="password" id="confirmPassword" required class="form-control">
      </div>

      <button type="submit" class="btn btn-primary mt-3 w-100" :disabled="isLoading">Register</button>
    </form>

    <Notification />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore';
import Notification from '@/components/utils/Notification.vue';
import { useRouter } from 'vue-router';
import { useNotification } from '@/helpers/useNotification.js';

const authStore = useAuthStore();
const router = useRouter();
const { register, setNotification } = authStore;
const { isLoading, setLoading } = useNotification();

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');

const onSubmit = async () => {
  try {
    setLoading(true);
    // Basic password confirmation check
    if (password.value !== confirmPassword.value) {
      throw new Error('Passwords do not match');
    }

    await register({
      name: name.value,
      email: email.value,
      password: password.value,
    });

    // Optionally, you can redirect the user to the login page after successful registration
    router.push('/login');
  } catch (error) {
    // Handle registration error
    if (error.response) {
      // Server responded with a status code outside of the range 2xx
      setNotification(error.response.data.message || 'Registration failed.', false, error);
    } else if (error.message === 'Passwords do not match') {
      // Password confirmation error
      setNotification('Passwords do not match', false);
    } else {
      // Other unexpected errors
      setNotification('An unexpected error occurred. Please try again later.', false, error);
    }
  } finally {
    setLoading(false);
  }
};
</script>

<style scoped>
/* Add specific styles for this component if needed */
.form {
  margin-top: 20px;
}
</style>
