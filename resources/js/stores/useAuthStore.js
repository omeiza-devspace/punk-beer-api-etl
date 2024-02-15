import { defineStore } from 'pinia';
import { useApiStore } from '@/stores/useApiStore';
import { useNotification } from '@/helpers/useNotification.js';

export const useAuthStore = defineStore({
  id: 'auth',
  state: () => ({
    user: null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.user,
  },

  actions: {
    async login(credentials) {
      const { showNotification, clearNotification, setLoading } = useNotification();
      const api = useApiStore();

      try {
        setLoading(true);
        const response = await api.post('/login', credentials);
        const { access_token, refresh_token } = response.data;
        localStorage.setItem('token', access_token);
        localStorage.setItem('refresh_token', refresh_token);
        await this.fetchUser();
        showNotification('Login successful', 'success');
      } catch (error) {
        showNotification('Login failed. Please check your credentials.', false, error);
        throw error;
      } finally {
        setLoading(false);
        clearNotification()
      }
    },

    async logout() {
      const { showNotification, setLoading, clearNotification } = useNotification();
      const api = useApiStore();

      try {
        setLoading(true);
        await api.post('/logout');
        localStorage.removeItem('token');
        localStorage.removeItem('refresh_token');
        this.setUser(null);
        showNotification('Logout successful', 'success');
      } catch (error) {
        showNotification('Logout failed.', false, error);
        throw error;
      } finally {
        setLoading(false);
        clearNotification()
      }
    },

    async refreshToken() {
      const { showNotification, clearNotification } = useNotification();
      const refresh_token = localStorage.getItem('refresh_token');
      if (!refresh_token) {
        throw new Error('No refresh token found');
      }

      const api = useApiStore();

      try {
        const response = await api.post('/refresh', { refresh_token });
        const { access_token } = response.data;
        localStorage.setItem('token', access_token);
        showNotification('Token refreshed successfully', 'success');
      } catch (error) {
        showNotification('Token refresh failed. Please log in again.', false, error);
      }finally {
        clearNotification();
      }
    },

    async fetchUser() {
      const { showNotification, clearNotification } = useNotification();
      const api = useApiStore();

      try {
        const response = await api.post('/user');
        this.setUser(response.data);
      } catch (error) {
        showNotification('Error fetching user data.', false, error);
      }finally {
        clearNotification();
      }
    },

    async register(userData) {
      const { showNotification,  clearNotification} = useNotification();
      const api = useApiStore();

      try {
        await api.post('/register', userData);
        showNotification('Registration successful. You can now login.', 'success');
      } catch (error) {
        showNotification('Registration error:', false, error);
        throw error;
      }finally {
        clearNotification();
      }
    },
  },
});

export function useAuth() {
  return useAuthStore();
}
