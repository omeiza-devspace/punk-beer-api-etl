import axios from '@/plugins/axios';

export const api = {
  get: (url) => axios.get(url),
  post: (url, data) => axios.post(url, data),
  put: (url, data) => axios.put(url, data),
  del: (url) => axios.delete(url),
};
