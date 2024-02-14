<template>
  <div id="app" class="font-sans text-center text-gray-700">
    <NavigationMenu />
    <router-view />
    <Footer />
    <Notification
      v-if="showNotification"
      :type="notificationType"
      :message="notificationMessage"
    />
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import NavigationMenu from '@/components/layout/NavigationMenu.vue';
import Footer from '@/components/layout/Footer.vue';
import Notification from '@/components/utils/Notification.vue';

export default {
  name: 'App',
  components: {
    NavigationMenu,
    Footer,
    Notification
  },
  setup() {
    const showNotification = ref(false);
    const notificationType = ref('');
    const notificationMessage = ref('');

    // Handle global errors
    const errorHandler = (err, vm, info) => {
      console.error('Vue error:', err, info);
      // Optionally, display a notification for the error
      showNotification.value = true;
      notificationType.value = 'error';
      notificationMessage.value = 'An error occurred. Please try again later.';
    };

    // Handle unhandled promise rejections
    const unhandledRejectionHandler = (event) => {
      console.error('Unhandled promise rejection:', event.reason?.path);
      // Optionally, display a notification for the unhandled rejection
      showNotification.value = true;
      notificationType.value = 'error';
      notificationMessage.value = 'An unhandled promise rejection occurred.';
    };

    // Set up error handlers on component creation
    onMounted(() => {
      window.addEventListener('error', errorHandler);
      window.addEventListener('unhandledrejection', unhandledRejectionHandler);
    });

    // Clean up error handlers on component destruction
    onUnmounted(() => {
      window.removeEventListener('error', errorHandler);
      window.removeEventListener('unhandledrejection', unhandledRejectionHandler);
    });

    return {
      showNotification,
      notificationType,
      notificationMessage
    };
  }
};
</script>

<style lang="postcss">
#app {
  margin-top: 60px;
}
</style>
