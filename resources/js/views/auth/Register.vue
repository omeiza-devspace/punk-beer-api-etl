<template>
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Register</h1>
    <form @submit.prevent="onSubmit" class="max-w-md mx-auto">
      <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
      <input v-model="name" type="text" id="name" required
             class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

      <label for="email" class="block mt-4 text-sm font-medium text-gray-700">Email:</label>
      <input v-model="email" type="email" id="email" required
             class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

      <label for="password" class="block mt-4 text-sm font-medium text-gray-700">Password:</label>
      <input v-model="password" type="password" id="password" required
             class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

      <label for="confirmPassword" class="block mt-4 text-sm font-medium text-gray-700">Confirm Password:</label>
      <input v-model="confirmPassword" type="password" id="confirmPassword" required
             class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

      <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        Register
      </button>
    </form>

    <Notification
      v-if="authStore.showNotification"
      :message="authStore.notificationMessage"
      :type="authStore.notificationType"
    />
  </div>
</template>

<script>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore';
import Notification from '@/components/utils/Notification.vue';
import { useRouter } from 'vue-router';

export default {
  name: 'Register',
  components: {
    Notification,
  },
  setup() {
    const authStore = useAuthStore();
    const router = useRouter();
    const name = ref('');
    const email = ref('');
    const password = ref('');
    const confirmPassword = ref('');

    const onSubmit = async () => {
      try {
        // Basic password confirmation check
        if (password.value !== confirmPassword.value) {
          throw new Error('Passwords do not match');
        }

        await auth.register({
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
          authStore.showNotification = true;
          authStore.notificationMessage = error.response.data.message || 'Registration failed.';
          authStore.notificationType = 'error';
        } else if (error.message === 'Passwords do not match') {
          // Password confirmation error
          authStore.showNotification = true;
          authStore.notificationMessage = 'Passwords do not match';
          authStore.notificationType = 'error';
        } else {
          // Other unexpected errors
          authStore.showNotification = true;
          authStore.notificationMessage = 'An unexpected error occurred. Please try again later.';
          authStore.notificationType = 'error';
        }
      }
    };

    return {
      authStore,
      name,
      email,
      password,
      confirmPassword,
      onSubmit,
    };
  },
};
</script>

<style scoped>
/* Add specific styles for this component */
.form {
  margin-top: 20px;
}
</style>
