import { defineStore } from 'pinia';
import { api } from '@/helpers/api';

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

      try {
        await api.post('/api/logout');
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


      try {
        setLoading(true); 
        const response = await api.post('/api/refresh', { refresh_token });
        const { access_token } = response.data;
        localStorage.setItem('token', access_token);
      } catch (error) {
        throw error;
      }
    },

    async fetchUser() {

      try {
        const response = await api.post('/api/user');
        this.setUser(response.data);
      } catch (error) {
        throw new Error('No refresh token found', error);
      }
    },

    async register(userData) {

      try {
        const response = await api.post('/api/register', userData); 
        console.log(response.data);
      } catch (error) {
       const {message} = error
       return message
        

      }
    },
  },
});

export function useAuth() {
  return useAuthStore();
}
