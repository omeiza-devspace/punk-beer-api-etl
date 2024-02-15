import { ref } from 'vue';

const useNotification = () => {
  const notification = ref({
    show: false,
    type: '',
    message: '',
    details: null,
  });

  const setNotification = (message, type = 'info', details =null) => {
    clearNotification();
    notification.show = true;
    notification.message = message;
    notification.type = type;
    notification.details = details;
  };

  const setSuccessNotification = (message, details = null) => {
    setNotification(message, 'success', details);
  };

  const setErrorNotification = (message, details = null) => {
    setNotification(message, 'error', details);
  };

  const clearNotification = () => {
    notification.show = false;
    notification.message = '';
    notification.type = '';
    notification.details = null;
  };

  const closeNotification = () => {
    clearNotification();
  }

  return {
    ...notification,
    setNotification,
    setSuccessNotification,
    setErrorNotification,
    clearNotification,
    closeNotification,
  };
};


export { useNotification };
