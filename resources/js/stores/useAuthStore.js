import { defineStore } from 'pinia';
import { useApiStore } from '@/stores/useApiStore';

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
      const api = useApiStore();

      try {
        const response = await api.post('/login', credentials);
        const { access_token, refresh_token } = response.data;
        localStorage.setItem('token', access_token);
        localStorage.setItem('refresh_token', refresh_token);
        await this.fetchUser();
      } catch (error) {
        throw error;
      } 
    },

    async logout() {
      const api = useApiStore();

      try {
        await api.post('/logout');
        localStorage.removeItem('token');
        localStorage.removeItem('refresh_token');
        this.setUser(null);
      } catch (error) {
        throw error;
      } 
    },

    async refreshToken() {
      const refresh_token = localStorage.getItem('refresh_token');
      if (!refresh_token) {
        throw new Error('No refresh token found');
      }

      const api = useApiStore();

      try {
        setLoading(true); 
        const response = await api.post('/refresh', { refresh_token });
        const { access_token } = response.data;
        localStorage.setItem('token', access_token);
      } catch (error) {
        throw error;
      }
    },

    async fetchUser() {
      const api = useApiStore();

      try {
        const response = await api.post('/user');
        this.setUser(response.data);
      } catch (error) {
        throw new Error('No refresh token found', error);
      }
    },

    async register(userData) {
      const { showNotification,  clearNotification} = useNotification();
      const api = useApiStore();

      try {
        await api.post('/register', userData); 
      } catch (error) {
        showNotification('Registration error:', false, error);
        throw new Error('Registration failed. Please try again', error);
      }
    },
  },
});

export function useAuth() {
  return useAuthStore();
}
