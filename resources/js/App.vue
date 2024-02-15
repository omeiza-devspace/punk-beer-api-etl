<!-- App.vue -->
<template>
  <div id="app" class="font-sans text-center text-gray-700">
    <NavigationMenu />
    <router-view v-slot="{ Component }">
      <component :is="Component || PageNotFound"></component>
    </router-view>
    <Footer />
    <Notification />
  </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue';
import NavigationMenu from '@/components/layout/NavigationMenu.vue';
import Footer from '@/components/layout/Footer.vue';
import Notification from '@/components/utils/Notification.vue';
import PageNotFound from '@/views/basic/PageNotFound.vue';
import { useNotification } from '@/helpers/useNotification.js';

const { show, type, message, setNotification, clearNotification } = useNotification();

const errorHandler = (err, vm, info) => {
  console.error('Vue error:', err, info);
  setNotification('An error occurred. Please try again later.', false);
};

const unhandledRejectionHandler = (event) => {
  console.error('Unhandled promise rejection:', event.reason?.path);
  setNotification('An unhandled promise rejection occurred.', false);
};

onMounted(() => {
  window.addEventListener('error', errorHandler);
  window.addEventListener('unhandledrejection', unhandledRejectionHandler);
});

onUnmounted(() => {
  window.removeEventListener('error', errorHandler);
  window.removeEventListener('unhandledrejection', unhandledRejectionHandler);
});
</script>

<style lang="postcss">
#app {
  margin-top: 60px;
}
</style>
