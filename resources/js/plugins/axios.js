import axios from 'axios'
import { useAuthStore } from '@/stores/useAuthStore'; 

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-Locale'] = localStorage.hasOwnProperty('locale') ? localStorage.locale : window.AppConfig.defaultLocale;
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.baseURL = window.AppConfig.url;

axios.interceptors.request.use(
    async (config) => {
      const authStore = useAuthStore();
      const token = authStore.accessToken;
  
      if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
      }
  
      return config;
    },
    (error) => {
      return Promise.reject(error);
    }
);

// Response interceptor for handling errors and token refresh
axios.interceptors.response.use(
  (response) => {
    // If the request was successful, return the response data
    return response.data;
  },
  async (error) => {
    const authStore = useAuthStore();
    const originalConfig = error.config;

    if (error.response && error.response.status === 401 && !originalConfig._retry) {
      originalConfig._retry = true;

      // Attempt to refresh the access token
      try {
        await authStore.refreshToken(); // Assume you have a Pinia action for refreshing the token
        return api(originalConfig);
      } catch (refreshError) {
        // If token refresh fails, redirect to login or handle as needed
        authStore.logout(); // Assume you have a Pinia action for logging out
        return Promise.reject(refreshError);
      }
    }

    // Handle other errors here
    const errorMessage = error.response?.data?.message || 'An error occurred.';
    
    // Optionally, you can emit or log the error for further handling
    console.error('API Error:', errorMessage);

    // Return a rejected promise with the error message
    return Promise.reject(errorMessage);
  }
);

export default axios;