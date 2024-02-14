import { defineStore } from 'pinia';
import {useApiStore} from '@/stores/useApiStore';

export const useAuthStore = defineStore({
  id: 'auth',
  state: () => ({
    user: null,
    error: null,
    showNotification: false,
    notificationMessage: '',
    notificationType: '',
  }),

  getters: {
    isAuthenticated: (state) => !!state.user,
  },

  actions: {
    setUser(userData) {
      this.user = userData;
    },

    async login(credentials) {
      try {
        const api = useApiStore();
        const response = await api.post('/login', credentials);
        const { access_token, refresh_token } = response.data;
        localStorage.setItem('token', access_token);
        localStorage.setItem('refresh_token', refresh_token);
        await this.fetchUser();
        this.setNotification('Login successfully', 'success')

      } catch (error) {
        const message = 'Login error:'
        this.setNotification('Login failed. Please check your credentials.', false, error)
        throw error;
      }
    },

    async logout() {
      try {
        await api.post('/logout');
        localStorage.removeItem('token');
        localStorage.removeItem('refresh_token');
        this.setUser(null);
        this.setNotification('Logout successfully', 'success')

      } catch (error) {
        const message = 'Logout error:'
        this.setNotification('Logout failed.', false, error)
        throw error;
      }
    },

    async refreshToken() {
      try {
        const refresh_token = localStorage.getItem('refresh_token');
        if (!refresh_token) {
          throw new Error('No refresh token found');
        }

        const api = useApiStore();
        const response = await api.post('/refresh', { refresh_token });
        const { access_token } = response.data;
        localStorage.setItem('token', access_token);
        const message = 'Token refreshed successfully'
        this.setNotification(message, true)
       
      } catch (error) {
        const message = "Token refresh failed. Please log in again.";
        this.setNotification(message, false, error)
      }
    },

    async fetchUser() {
      try {
        const api = useApiStore();
        const response = await api.post('/user');
        this.setUser(response.data);
      } catch (error) {
        const message = "Error fetching user data.";
        this.setNotification(message, false, error)
      }
    },

    async register(userData) {
      try {
        await api.post('/register', userData);
        this.showNotification = true;
        this.notificationMessage = 'Registration successful. You can now login.';
        this.notificationType = 'success';
      } catch (error) {
        const message = 'Registration error:'
        this.setNotification(message, false, error)
      
      }
    },

    setNotification(message,  isSuccess = true, error = null) {
      this.clearNotification()
      this.showNotification = true;
      this.notificationMessage = message;
      this.notificationType = isSuccess == true ?'success' : 'error';
      this.error = error;
    },

    clearNotification() {
      this.showNotification = false;
      this.notificationMessage = '';
      this.notificationType = '';
      this.error = null;
    },
  },
});

export function useAuth() {
  return useAuthStore();
}
