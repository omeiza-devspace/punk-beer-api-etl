<!-- BeerDetail.vue -->

<template>
    <div>
      <h1 class="text-3xl font-bold">{{ beer.name }}</h1>
      <p class="text-gray-500">{{ beer.tagline }}</p>
      <img :src="beer.image_url" alt="Beer Image" class="w-64 h-64 object-cover rounded-md mt-4 mb-8">
  
      <div>
        <h2 class="text-xl font-bold mb-2">Description</h2>
        <p>{{ beer.description }}</p>
      </div>
  
      <div>
        <h2 class="text-xl font-bold mb-2">ABV: {{ beer.abv }}%</h2>
        <h2 class="text-xl font-bold mb-2">IBU: {{ beer.ibu }}</h2>
      </div>
  
      <div>
        <h2 class="text-xl font-bold mb-2">Food Pairing</h2>
        <ul>
          <li v-for="foodItem in beer.food_pairing" :key="foodItem">{{ foodItem }}</li>
        </ul>
      </div>
  
      <!-- Add more details as needed -->
  
      <router-link to="/beers" class="text-blue-500 mt-4">Back to Beer List</router-link>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  
  export default {
    setup() {
      const beer = ref({});
  
      onMounted(async () => {
        try {
          const response = await this.$axios.get(`/api/beers/${this.$route.params.id}`);
          beer.value = response.data.data;
        } catch (error) {
          console.error('Error fetching beer details:', error);
        }
      });
  
      return {
        beer,
      };
    },
  };
  </script>
  