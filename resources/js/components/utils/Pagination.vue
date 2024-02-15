<!-- BeerList.vue -->
<template>
  <div>
    <h1>Beer List</h1>

    <Notification v-if="beerStore.error" message="{{ beerStore.error }}" type="error" />

    <ul v-if="!beerStore.error">
      <li v-for="beer in beerStore.beers" :key="beer.id">
        {{ beer.name }}
        <button @click="viewBeerDetails(beer.id)">View Details</button>
      </li>
    </ul>

    <div>
      <button @click="previousPage" :disabled="beerStore.currentPage === 1">Previous Page</button>
      <span>{{ beerStore.currentPage }}</span>
      <button @click="nextPage" :disabled="beerStore.currentPage * beerStore.itemsPerPage >= beerStore.totalItems">Next Page</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useBeerStore } from '@/stores/beerStore';
import Notification from '@/components/utils/Notification.vue';

const beerStore = useBeerStore();

const beers = ref([]);

const fetchProducts = async () => {
  await beerStore.fetchPaginatedBeers();
  beers.value = beerStore.beers;
};

const viewBeerDetails = async (beerId) => {
  await beerStore.searchBeerById(beerId);
  // Implement logic to navigate to the beer details page
};

const nextPage = async () => {
  await beerStore.goToPage(beerStore.currentPage + 1);
  fetchProducts();
};

const previousPage = async () => {
  await beerStore.goToPage(beerStore.currentPage - 1);
  fetchProducts();
};

onMounted(fetchProducts);
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
