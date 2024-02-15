<template>
  <div>
    <h1 class="text-2xl font-weight-bold mb-4">Beer List</h1>

    <Notification v-if="beerStore.error" :message="beerStore.error" type="error" />

    <div class="row mb-4">
      <div class="col-md-4">
        <select v-model="searchBy" class="form-select">
          <option value="name">Search by Name</option>
          <option value="id">Search by ID</option>
        </select>
      </div>
      <div class="col-md-4">
        <input v-model="searchTerm" type="text" class="form-control" />
      </div>
      <div class="col-md-4">
        <button @click="search" class="btn btn-primary">Search</button>
      </div>
    </div>

    <div v-if="beers.length > 0">
      <ul v-if="!beerStore.error && !isLoading" class="list-unstyled">
        <li v-for="beer in beerStore.beers" :key="beer.id" class="mb-4 p-4 border rounded">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <router-link :to="{ name: 'beer-details', params: { id: beer.id } }">
                <h2 class="text-lg font-weight-bold">{{ beer.name }}</h2>
              </router-link>
              <p class="text-muted">{{ beer.tagline }}</p>
              <img :src="beer.image_url" alt="Beer Image" class="w-32 h-32 object-cover rounded-md mt-2">
            </div>
            <button @click="viewBeerDetails(beer.id)" class="btn btn-primary">View Details</button>
          </div>
        </li>
      </ul>
    </div>
    <div v-else class="text-center">
      <p>No beers found</p>
    </div>

    <div v-if="isLoading" class="text-center">
      Loading...
    </div>

    <div class="d-flex align-items-center space-x-4">
      <button @click="previousPage" :disabled="beerStore.currentPage === 1 || isLoading" class="btn btn-secondary">Previous Page</button>
      <span class="text-xl font-weight-bold">{{ beerStore.currentPage }}</span>
      <button @click="nextPage" :disabled="beerStore.currentPage * beerStore.itemsPerPage >= beerStore.totalItems || isLoading" class="btn btn-secondary">Next Page</button>
    </div>

    <Notification />
    <Loading />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useBeerStore } from '@/stores/useBeerStore';

import Notification from '@/components/utils/Notification.vue';
import Loading from '@/components/utils/Loading.vue';

import { useNotification } from '@/helpers/useNotification';
import { useLoading } from '@/helpers/useLoading';

const beers = ref([]);
const searchBy = ref('name');
const searchTerm = ref('');

const beerStore = useBeerStore();
const { setSuccessNotification, setErrorNotification, clearNotification } = useNotification();
const { startLoading, stopLoading } = useLoading()


onMounted(async () => {
  
  try {
    startLoading()
    await beerStore.fetchPaginatedBeers();
    setSuccessNotification("Successfully fetched all records")
  } catch (error) {
    setErrorNotification('Failed to fetch records', error);
  } finally {
    stopLoading() 
    clearNotification()
 }
});

const viewBeerDetails = async (beerId) => {
  try {
    startLoading()
    await beerStore.searchBeerById(beerId);
    // Implement logic to navigate to the beer details page
  } catch (error) {
    setErrorNotification('Failed to view beer details', error);
  } finally {
    stopLoading() 
    clearNotification()  
  }
};

const nextPage = async () => {
  try {
    startLoading()
    await beerStore.goToPage(beerStore.currentPage + 1);
    await fetchProducts();
  } catch (error) {
    setErrorNotification('Failed to navigate to the next page', error);
  } finally {
    stopLoading() 
    clearNotification()  
  }
};

const previousPage = async () => {
  try {
    startLoading()
    await beerStore.goToPage(beerStore.currentPage - 1);
    await fetchProducts();
  } catch (error) {
    setErrorNotification('Failed to navigate to the previous page', error);
  } finally {
    stopLoading() 
    clearNotification()   
  }
};

const fetchProducts = async () => {
  try {
    startLoading()
    await beerStore.fetchPaginatedBeers();
  } catch (error) {
    setErrorNotification('Failed to fetch beers', error);
  } finally {
    stopLoading() 
    clearNotification()   
  }
};

const filterRecords = async () => {
  try {
    startLoading()
    const response = await this.$axios.get('/api/beers/search', {
      params: {
        [searchBy.value]: searchTerm.value,
      },
    });
    beers.value = response.data.data;
  } catch (error) {
    console.error('Error searching beers:', error);
  }finally {
    stopLoading() 
    clearNotification()   
  }
};
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
