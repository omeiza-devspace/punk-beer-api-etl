<template>
  <div class="container mt-5">
    <h1 class="text-center">Login</h1>
    <form @submit.prevent="onSubmit" class="mx-auto mt-4" style="max-width: 400px">

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" v-model="email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" v-model="password" required>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary mt-3 w-100" :disabled="isLoading">Login</button>
    </form>

    <Notification />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore';
import { useRouter } from 'vue-router';
import Notification from '@/components/utils/Notification.vue';
import { useNotification } from '@/helpers/useNotification.js';

const authStore = useAuthStore();
const router = useRouter();
const { login, setNotification } = authStore;
const { isLoading, setLoading } = useNotification();

const email = ref('');
const password = ref('');

const onSubmit = async () => {
  try {
    setLoading(true);
    await login({ email: email.value, password: password.value });
    // Redirect to the dashboard upon successful login
    router.push('/dashboard');
  } catch (error) {
    // Handle login error
    setNotification(error.message, false);
  } finally {
    setLoading(false);
  }
};
</script>

<style scoped>
/* Add specific styles for this component if needed */
</style>
