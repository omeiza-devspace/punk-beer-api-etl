// useNotification.js
import { ref } from 'vue';

export const useNotification = () => {
  const showNotification = ref(false);
  const notificationType = ref('');
  const notificationMessage = ref('');

  const setNotification = (message, isSuccess = true) => {
    clearNotification();
    showNotification.value = true;
    notificationMessage.value = message;
    notificationType.value = isSuccess ? 'success' : 'error';
  };

  const clearNotification = () => {
    showNotification.value = false;
    notificationMessage.value = '';
    notificationType.value = '';
  };

  return {
    showNotification,
    notificationType,
    notificationMessage,
    setNotification,
    clearNotification,
  };
};
