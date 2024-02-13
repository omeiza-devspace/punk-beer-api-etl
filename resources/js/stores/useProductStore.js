// ProductStore.js
import { defineStore } from 'pinia';
import { useAPI } from '@/services/api'; 

export const useProductStore = defineStore('product', {
  state: () => ({
    products: [],
    currentPage: 1,
    itemsPerPage: 10,
    totalItems: 0,
    error: null, //chage to notification
    selectedProduct: null,
  }),

  actions: {
    async fetchPaginatedProducts() {
      try {
        const api = useAPI();
        const response = await api.get(`/beers/search-limit-and-offset?page=${this.currentPage}`);
        this.products = response.data.data;
        this.totalItems = response.data.total;
        this.error = null;
      } catch (error) {
        this.error = 'Failed to fetch products';
      }
    },

    async searchProductByName(name) {
      try {
        const api = useAPI();
        const response = await api.get(`/beers/search-name/${name}`);
        this.products = [response.data];
        this.totalItems = 1;
        this.error = null;
      } catch (error) {
        this.error = 'Product not found';
      }
    },

    async searchProductById(id) {
      try {
        const api = useAPI();
        const response = await api.get(`/beers/search-id/${id}`);
        this.selectedProduct = response.data;
        this.error = null;
      } catch (error) {
        this.error = 'Product not found';
      }
    },

    async fetchAllProducts() {
      try {
        const api = useAPI();
        const response = await api.get('/beers');
        this.products = response.data.data;
        this.totalItems = response.data.total;
        this.error = null;
      } catch (error) {
        this.error = 'Failed to fetch all products';
      }
    },

    async fetchProductProperties() {
      try {
        const api = useAPI();
        const response = await api.get('/beers/properties');
        // Process the properties as needed
        this.error = null;
      } catch (error) {
        this.error = 'Failed to fetch product properties';
      }
    },

    async fetchExternalData() {
      try {
        const api = useAPI();
        const response = await api.get('/beers/get-external-data');
        // Process the external data as needed
        this.error = null;
      } catch (error) {
        this.error = 'Failed to fetch external data';
      }
    },

    async fetchPaginatedData(query, perPage) {
      try {
        const api = useAPI();
        const response = await api.get(`/beers/search-paginated-data?query=${query}&perPage=${perPage}`);
        this.products = response.data.data;
        this.totalItems = response.data.total;
        this.error = null;
      } catch (error) {
        this.error = 'Failed to fetch paginated data';
      }
    },

    clearNotification() {
        this.showNotification = false;
        this.notificationMessage = '';
        this.notificationType = '';
      },
  },
});


export function useProduct() {
    return useProductStore();
}