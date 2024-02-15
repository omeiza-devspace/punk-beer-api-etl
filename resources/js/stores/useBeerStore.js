import { defineStore } from 'pinia';
import { useApiStore } from '@/stores/useApiStore';
import { useNotification } from '@/helpers/useNotification.js';

export const useBeerStore = defineStore({
  id: 'beer',
  state: () => ({
    beers: [],
    currentPage: 1,
    itemsPerPage: 10,
    totalItems: 0,
    selectedBeer: null,
    error: null,
  }),

  actions: {
    async fetchPaginatedBeers() {
      const api = useApiStore();

      try {
        const response = await api.get(`/beers/search-limit-and-offset?page=${this.currentPage}`);
        this.beers = response.data.data;
        this.totalItems = response.data.total;
      } catch (error) {
        this.error = error;
        throw new Error('Failed to fetch beers', error);
      }
    },

    async searchBeerByName(name) {
      const api = useApiStore();

      try {
        const response = await api.get(`/beers/search-name/${name}`);
        this.beers = [response.data];
        this.totalItems = 1;
      } catch (error) {
        this.err
        throw new Error('Beer not found', error);
      }
    },

    async searchBeerById(id) {
      const api = useApiStore();

      try {
        const response = await api.get(`/beers/search-id/${id}`);
        this.selectedBeer = response.data;
      } catch (error) {
        this.err
        throw new Error('Beer not found', error);
      }
    },

    async fetchAllBeers() {
      const api = useApiStore();

      try {
        const response = await api.get('/beers');
        this.beers = response.data.data;
        this.totalItems = response.data.total;
      } catch (error) {
        this.err
        throw new Error('Failed to fetch all beers', error);
      }
    },

    async fetchBeerProperties() {
      const api = useApiStore();

      try {
        const response = await api.get('/beers/properties');
        // Process the properties as needed
      } catch (error) {
        this.err
        throw new Error('Failed to fetch beer properties', error);
      }
    },

    async fetchExternalData() {
      const api = useApiStore();

      try {
        const response = await api.get('/beers/get-external-data');
        // Process the external data as needed
      } catch (error) {
        this.err
        throw new Error('Failed to fetch external data', error);
      }
    },

    async fetchPaginatedData(query, perPage) {
      const api = useApiStore();

      try {
        const response = await api.get(`/beers/search-paginated-data?query=${query}&perPage=${perPage}`);
        this.beers = response.data.data;
        this.totalItems = response.data.total;
      } catch (error) {
        this.err
        throw new Error('Failed to fetch paginated data', error);
      }
    },


  },
});

export function useBeer() {
  return useBeerStore();
}
