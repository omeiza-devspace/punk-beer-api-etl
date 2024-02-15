<template>
  <div v-if="isVisible" class="notification" :class="notificationType">
    <p>{{ message }}</p>
    <button @click="closeNotification">&times;</button>
  </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import { useNotification } from '@/helpers/useNotification.js';

const { isVisible, message, notificationType, closeNotification } = useNotification();

watchEffect(() => {
  if (isVisible && notificationType === 'error') {
    console.error('Error in Notification component:', message);
  }
});
</script>

<style scoped>
.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 1em;
  border-radius: 4px;
  color: #fff;
  z-index: 1000;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.error {
  background-color: #e74c3c;
}

.success {
  background-color: #2ecc71;
}
</style>


