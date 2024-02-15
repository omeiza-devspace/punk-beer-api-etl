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
    showNotification: false,
    notificationMessage: '',
    notificationType: '',
  }),

  actions: {
    async fetchPaginatedBeers() {
      const api = useApiStore();
      const { setNotification, clearNotification } = useNotification();

      try {
        const response = await api.get(`/beers/search-limit-and-offset?page=${this.currentPage}`);
        this.beers = response.data.data;
        this.totalItems = response.data.total;
        setNotification('Fetch beers successful', true);
      } catch (error) {
        setNotification('Failed to fetch beers', false, error);
      }finally {
        clearNotification();
      }
    },

    async searchBeerByName(name) {
      const api = useApiStore();
      const { setNotification, clearNotification } = useNotification();

      try {
        const response = await api.get(`/beers/search-name/${name}`);
        this.beers = [response.data];
        this.totalItems = 1;
        setNotification('Fetch beer successful', true);
      } catch (error) {
        setNotification('Beer not found', false, error);
      }finally {
        clearNotification();
      }
    },

    async searchBeerById(id) {
      const api = useApiStore();
      const { setNotification, clearNotification } = useNotification();

      try {
        const response = await api.get(`/beers/search-id/${id}`);
        this.selectedBeer = response.data;
        setNotification('Fetch beer successful', true);
      } catch (error) {
        setNotification('Beer not found', false, error);
      }finally {
        clearNotification();
      }
    },

    async fetchAllBeers() {
      const api = useApiStore();
      const { setNotification, clearNotification } = useNotification();

      try {
        const response = await api.get('/beers');
        this.beers = response.data.data;
        this.totalItems = response.data.total;
        setNotification('Fetch all beers successfully', true);
      } catch (error) {
        setNotification('Failed to fetch all beers', false, error);
      }finally {
        clearNotification();
      }
    },

    async fetchBeerProperties() {
      const api = useApiStore();
      const { setNotification, clearNotification } = useNotification();

      try {
        const response = await api.get('/beers/properties');
        // Process the properties as needed
        setNotification('Fetch beer properties successful', true);
      } catch (error) {
        setNotification('Failed to fetch beer properties', false, error);
      }finally {
        clearNotification();
      }
    },

    async fetchExternalData() {
      const api = useApiStore();
      const { setNotification, clearNotification } = useNotification();

      try {
        const response = await api.get('/beers/get-external-data');
        // Process the external data as needed
        setNotification('External data fetched successfully', true);
      } catch (error) {
        setNotification('Failed to fetch external data', false, error);
      }finally {
        clearNotification();
      }
    },

    async fetchPaginatedData(query, perPage) {
      const api = useApiStore();
      const { setNotification, clearNotification } = useNotification();

      try {
        const response = await api.get(`/beers/search-paginated-data?query=${query}&perPage=${perPage}`);
        this.beers = response.data.data;
        this.totalItems = response.data.total;
        setNotification('Fetched paginated data successfully', true);
      } catch (error) {
        setNotification('Failed to fetch paginated data', false, error);
      }finally {
        clearNotification();
      }
    },
  },
});

export function useBeer() {
  return useBeerStore();
}
