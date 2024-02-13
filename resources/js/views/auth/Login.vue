<template>
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Login</h1>
    <form @submit.prevent="onSubmit" class="max-w-md mx-auto">
      <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
      <input v-model="email" type="email" id="email" required
             class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

      <label for="password" class="block mt-4 text-sm font-medium text-gray-700">Password:</label>
      <input v-model="password" type="password" id="password" required
             class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

      <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        Login
      </button>
    </form>

    <Notification
      v-if="authStore.showNotification"
      :type="authStore.notificationType"
      :message="authStore.notificationMessage"
    />
  </div>
</template>

<script>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore';
import Notification from '@/components/utils/Notification.vue';
import { useRouter } from 'vue-router';

export default {
  name: 'Login',
  components: {
    Notification,
  },
  setup() {
    const authStore = useAuthStore();
    const router = useRouter();
    const email = ref('');
    const password = ref('');

    console.log(authStore.notificationType);

    const onSubmit = async () => {
      try {
        await authStore.login({ email: email.value, password: password.value });
        // Redirect to the dashboard upon successful login
        router.push('/dashboard');
      } catch (error) {
        // Handle login error
      }
    };

    return {
      authStore,
      email,
      password,
      onSubmit,
    };
  },
};
</script>

<style scoped>
/* Add specific styles for this component */
</style>
