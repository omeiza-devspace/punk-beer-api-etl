// services/loadingService.js
import { ref } from 'vue';

const loading = ref(false);

const startLoading = () => {
  loading.value = true;
};

const stopLoading = () => {
  loading.value = false;
};

const useLoading = () => {
  return {
    isLoading: loading,
    startLoading,
    stopLoading,
  };
};

export { useLoading };
