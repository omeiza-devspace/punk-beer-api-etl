<!-- BeerList.vue -->

<template>
    <div>
      <h1 class="text-3xl font-bold mb-4">Beer List</h1>
  
      <!-- Add search dropdown and button -->
      <div class="flex mb-4">
        <div class="flex-1">
          <select v-model="searchBy" class="p-2 border border-gray-300 rounded">
            <option value="name">Search by Name</option>
            <option value="id">Search by ID</option>
          </select>
        </div>
        <div class="flex-1">
          <input v-model="searchTerm" type="text" class="p-2 border border-gray-300 rounded" />
        </div>
        <div>
          <button @click="search" class="px-4 py-2 bg-blue-500 text-white rounded">Search</button>
        </div>
      </div>
  
      <!-- Display the beer list -->
      <div v-if="beers.length > 0">
        <div v-for="beer in beers" :key="beer.id" class="mb-8">
          <router-link :to="{ name: 'beer-details', params: { id: beer.id } }">
            <h2 class="text-xl font-bold">{{ beer.name }}</h2>
          </router-link>
          <p>{{ beer.tagline }}</p>
          <img :src="beer.image_url" alt="Beer Image" class="w-32 h-32 object-cover rounded-md mt-2">
        </div>
      </div>
  
      <!-- Show loading message while fetching data -->
      <div v-else>
        <p>Loading...</p>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  
  export default {
    setup() {
      const beers = ref([]);
      const searchBy = ref('name');
      const searchTerm = ref('');
  
      const fetchBeers = async () => {
        try {
          const response = await this.$axios.get('/api/beers');
          beers.value = response.data.data;
        } catch (error) {
          console.error('Error fetching beers:', error);
        }
      };
  
      const search = async () => {
        try {
          const response = await this.$axios.get('/api/beers/search', {
            params: {
              [searchBy.value]: searchTerm.value,
            },
          });
          beers.value = response.data.data;
        } catch (error) {
          console.error('Error searching beers:', error);
        }
      };
  
      onMounted(() => {
        fetchBeers();
      });
  
      return {
        beers,
        searchBy,
        searchTerm,
        search,
      };
    },
  };
  </script>
  