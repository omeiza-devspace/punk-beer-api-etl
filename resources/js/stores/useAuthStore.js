import { ref } from 'vue';
import { defineStore } from 'pinia';
import axios from 'axios';

import Notification from '@/components/utils/Notification.vue';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    showNotification: ref(false),
    notificationMessage: ref(''),
    notificationType: ref(''),
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
        const response = await axios.post('/login', credentials);
        const { access_token, refresh_token } = response.data;
        localStorage.setItem('token', access_token);
        localStorage.setItem('refresh_token', refresh_token);
        await this.fetchUser();
        this.showNotification = true;
        this.notificationMessage = 'Login successful';
        this.notificationType = 'success';
      } catch (error) {
        console.error('Login error:', error);
        this.showNotification = true;
        this.notificationMessage = 'Login failed. Please check your credentials.';
        this.notificationType = 'error';
        throw error;
      }
    },

    async logout() {
      try {
        await axios.post('/logout');
        localStorage.removeItem('token');
        localStorage.removeItem('refresh_token');
        this.setUser(null);
        this.showNotification = true;
        this.notificationMessage = 'Logout successful';
        this.notificationType = 'success';
      } catch (error) {
        console.error('Logout error:', error);
        this.showNotification = true;
        this.notificationMessage = 'Logout failed.';
        this.notificationType = 'error';
        throw error;
      }
    },

    async refreshToken() {
      try {
        const refresh_token = localStorage.getItem('refresh_token');
        if (!refresh_token) {
          throw new Error('No refresh token found');
        }

        const response = await axios.post('/refresh', { refresh_token });
        const { access_token } = response.data;
        localStorage.setItem('token', access_token);
        this.showNotification = true;
        this.notificationMessage = 'Token refreshed successfully';
        this.notificationType = 'success';
      } catch (error) {
        console.error('Token refresh error:', error);
        this.showNotification = true;
        this.notificationMessage = 'Token refresh failed. Please log in again.';
        this.notificationType = 'error';
        throw error;
      }
    },

    async fetchUser() {
      try {
        const response = await axios.post('/user');
        this.setUser(response.data);
      } catch (error) {
        console.error('Error fetching user:', error);
        this.showNotification = true;
        this.notificationMessage = 'Error fetching user data.';
        this.notificationType = 'error';
      }
    },

    async register(userData) {
      try {
        await axios.post('/register', userData);
        this.showNotification = true;
        this.notificationMessage = 'Registration successful. You can now login.';
        this.notificationType = 'success';
      } catch (error) {
        console.error('Registration error:', error);
        this.showNotification = true;
        this.notificationMessage = 'Registration failed.';
        this.notificationType = 'error';
        throw error;
      }
    },

    clearNotification() {
      this.showNotification = false;
      this.notificationMessage = '';
      this.notificationType = '';
    },
  },
});

export function useAuth() {
  return useAuthStore();
}
