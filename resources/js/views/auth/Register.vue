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
    <Loading />
</div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore';
import { useRouter } from 'vue-router';

import Notification from '@/components/utils/Notification.vue';
import Loading from '@/components/utils/Loading.vue';

import { useNotification } from '@/helpers/useNotification';
import { useLoading } from '@/helpers/useLoading';

const authStore = useAuthStore();
const router = useRouter();
const { register } = authStore;

const { setSuccessNotification, setErrorNotification, clearNotification } = useNotification();
const { isLoading, startLoading, stopLoading } = useLoading()

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');

const onSubmit = async () => {
  try {
    startLoading();
    // Basic password confirmation check
    if (password.value !== confirmPassword.value) {
      throw new Error('Passwords do not match');
    }

    await register({
      name: name.value,
      email: email.value,
      password: password.value,
    });

    router.push('/login');
  } catch (error) {
    // Handle registration error
    if (error.response) {
      // Server responded with a status code outside of the range 2xx
      setErrorNotification(error.response.data.message || 'Registration failed.', error);
    } else if (error.message === 'Passwords do not match') {
      // Password confirmation error
      setErrorNotification('Passwords do not match', false);
    } else {
      // Other unexpected errors
      setErrorNotification('An unexpected error occurred. Please try again later.', error);
    }
  } finally {
    clearNotification()
    stopLoading();
  }
};
</script>

<style scoped>
.form {
  margin-top: 20px;
}
</style>
