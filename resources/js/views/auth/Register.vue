<template>
  <div class="container mt-5">
    <h1 class="text-center">Register</h1>
    <form @submit.prevent="onSubmit" class="mx-auto mt-4" style="max-width: 400px">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="text" class="form-control" id="name" v-model="name" placeholder="Enter Name" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="email" class="form-control" id="email" v-model="email" placeholder="Enter Email" required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="password" class="form-control" id="password" v-model="password" placeholder="Enter Password" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="password" class="form-control" id="password_confirmation" v-model="confirmPassword" placeholder="Confirm Password" required>
          </div>
        </div>
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
