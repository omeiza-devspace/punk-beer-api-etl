<template>
  <div class="container mt-8">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-xl">

      <!-- Beer Name, Tagline, and Description -->
      <div class="p-4">
        <h2 class="text-lg font-semibold mb-2">{{ beerStore.selectedBeer.name }}</h2>
        <p class="text-muted">{{ beerStore.selectedBeer.tagline }}</p>
        <p class="text-gray-700 mt-4">{{ beerStore.selectedBeer.description }}</p>
      </div>

      <!-- Display Image -->
      <img :src="beerStore.selectedBeer.image_url" alt="Beer Image" class="w-full object-cover">

      <!-- Display Ingredients -->
      <div class="p-4">
        <h3 class="text-lg font-semibold mb-2">Ingredients:</h3>
        <ul class="list-unstyled">
          <!-- ... other ingredient rendering ... -->
        </ul>
      </div>

      <!-- Display ABV, IBU, and Food Pairing -->
      <div class="p-4 bg-light">
        <p class="text-lg font-semibold">Details:</p>
        <p><span class="font-weight-bold">ABV:</span> {{ beerStore.selectedBeer.abv }}</p>
        <p><span class="font-weight-bold">IBU:</span> {{ beerStore.selectedBeer.ibu }}</p>

        <!-- Food Pairing -->
        <div class="mt-4">
          <p class="text-lg font-semibold">Food Pairing:</p>
          <ul class="list-unstyled">
            <li v-for="foodItem in beerStore.food_pairing" :key="foodItem">
              {{ foodItem }}</li>
          </ul>
        </div>
      </div>

      <router-link to="/beers" class="text-blue-500 mt-4">Back to Beer List</router-link>

    </div>
    <Notification />
    <Loading />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useBeerStore } from '@/stores/useBeerStore';
import { useRoute } from 'vue-router';

import Notification from '@/components/utils/Notification.vue';
import Loading from '@/components/utils/Loading.vue';

import { useNotification } from '@/helpers/useNotification';
import { useLoading } from '@/helpers/useLoading';

const beerStore = useBeerStore();
const { setSuccessNotification, setErrorNotification, clearNotification } = useNotification();
const { isLoading, startLoading, stopLoading } = useLoading()
const route = useRoute();

onMounted(async () => {
  
  try {
    startLoading()
    if (!beerStore.selectedBeer) {
        if(route.params.id){
          const id = route.params.id;

         await beerStore.fetchBeerDetails(id);
           setSuccessNotification(" Record fetched Successfully")
        }else{
          setErrorNotification('Failed to fetch beer details', null);
        }
    }
  } catch (error) {
    setErrorNotification('Failed to fetch beer details',  error);
  }  finally {
    stopLoading() 
    clearNotification()   
  }
});

</script>

<style scoped>
/* Add your component-specific styles here */
</style>
