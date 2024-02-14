import { defineStore } from 'pinia';
import {useApiStore} from '@/stores/useApiStore';

export const useProductStore = defineStore({
  id : 'product',
  state: () => ({
    products: [],
    currentPage: 1,
    itemsPerPage: 10,
    totalItems: 0,
    selectedProduct: null,

    error: null,
    showNotification: false,
    notificationMessage: '',
    notificationType: '',
  }),

  actions: {
    async fetchPaginatedProducts() {
      try {
        const api = useApiStore();
        const response = await api.get(`/beers/search-limit-and-offset?page=${this.currentPage}`);
        this.products = response.data.data;
        this.totalItems = response.data.total;
        const message = 'Fetch products successful';
        this.setNotification(message, true)

      } catch (error) {
        const message = 'Failed to fetch products';
        this.setNotification(message, false, error)
      }
    },

    async searchProductByName(name) {
      try {
        const api = useApiStore();
        const response = await api.get(`/beers/search-name/${name}`);
        this.products = [response.data];
        this.totalItems = 1;
        const message = 'Fetch product successful';
        this.setNotification(message, true)

      } catch (error) {
        const message = 'Product not found';
        this.setNotification( message, false, error)
      }
    },

    async searchProductById(id) {
      try {
        const api = useApiStore();
        const response = await api.get(`/beers/search-id/${id}`);
        this.selectedProduct = response.data;
        this.setNotification('Fetch product successful', true)
      } catch (error) {
        const message = 'Product not found';
        this.setNotification( message, false, error)
      }
    },

    async fetchAllProducts() {
      try {
        const api = useApiStore();
        const response = await api.get('/beers');
        this.products = response.data.data;
        this.totalItems = response.data.total;
        const message = 'Fetch all products successfully';
        this.setNotification( message, true)
      } catch (error) {
        const message = 'Failed to fetch all products';
        this.setNotification(message, false, error)
      }
    },

    async fetchProductProperties() {
      try {
        const api = useApiStore();
        const response = await api.get('/beers/properties');
        // Process the properties as needed
        this.setNotification( message, true)
      } catch (error) {
        const message = 'Failed to fetch product properties';
        this.setNotification(message, false, error)

      }
    },

    async fetchExternalData() {
      try {
        const api = useApiStore();
        const response = await api.get('/beers/get-external-data');
        // Process the external data as needed
        const message = 'External data fetched successfully';
        this.setNotification(message, true)
      } catch (error) {
        const message = 'Failed to fetch external data';
        this.setNotification(message, false, error)

      }
    },

    async fetchPaginatedData(query, perPage) {
      try {
        const api = useApiStore();
        const response = await api.get(`/beers/search-paginated-data?query=${query}&perPage=${perPage}`);
        this.products = response.data.data;
        this.totalItems = response.data.total;
        const message = 'fetched paginated data successfully';
        this.setNotification(message, true)

      } catch (error) {
        const message = 'Failed to fetch paginated data';
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

export function useProduct() {
    return useProductStore();
}