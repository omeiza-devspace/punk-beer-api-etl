import { createApp } from 'vue';
import App from './App.vue';
import { createPinia } from 'pinia';
import { useAuthStore } from '@/stores/useAuthStore';
import router from './router'; 
import Notification from '@/components/utils/Notification.vue';

const app = createApp(App);
const pinia = createPinia();

app.component('Notification', Notification);

app.use(router); 
app.use(pinia);
app.mount('#app');

const authStore = useAuthStore();

// Add this to handle global errors
app.config.errorHandler = (err, vm, info) => {
  console.error('Vue error:', err, info);
  authStore.showNotification = true;
  authStore.notificationMessage = 'An error occurred. Please try again later.';
  authStore.notificationType = 'error';
};

// If you want to handle unhandled promise rejections
window.addEventListener('unhandledrejection', (event) => {
  console.error('Unhandled promise rejection:', event.reason);
  authStore.showNotification = true;
  authStore.notificationMessage = 'An error occurred. Please try again later.';
  authStore.notificationType = 'error';
});
