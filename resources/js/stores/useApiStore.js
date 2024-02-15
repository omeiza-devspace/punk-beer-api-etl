import axios from '@/plugins/axios';
import { defineStore } from 'pinia';

export const useApiStore = defineStore({
  id: 'api',
  actions: () => {
    const get = (url) => axios.get(url);
    const post = (url, data) => axios.post(url, data);
    const put = (url, data) => axios.put(url, data);
    const del = (url) => axios.delete(url);

    return {
      get,
      post,
      put,
      del, 
    };
  },
});
