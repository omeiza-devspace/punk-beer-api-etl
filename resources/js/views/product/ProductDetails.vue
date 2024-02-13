<template>
  <div class="container mx-auto mt-8">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-xl">

      <!-- Product Name, Tagline, and Description -->
      <div class="p-6">
        <h2 class="text-xl font-semibold mb-2">{{ productStore.selectedProduct.name }}</h2>
        <p class="text-gray-600">{{ productStore.selectedProduct.tagline }}</p>
        <p class="text-gray-700 mt-4">{{ productStore.selectedProduct.description }}</p>
      </div>

      <!-- Display Image -->
      <img :src="productStore.selectedProduct.image_url" alt="Product Image" class="w-full object-cover">

      <!-- Display Ingredients -->
      <div class="p-6">
        <h3 class="text-lg font-semibold mb-2">Ingredients:</h3>
        <ul class="list-disc pl-4">
          <li v-for="malt in productStore.selectedProduct.ingredients.malt" :key="malt.name">
            {{ malt.amount.value }} {{ malt.amount.unit }} of {{ malt.name }}
          </li>
          <li v-for="hop in productStore.selectedProduct.ingredients.hops" :key="hop.name">
            {{ hop.amount.value }} {{ hop.amount.unit }} of {{ hop.name }} ({{ hop.add }} - {{ hop.attribute }})
          </li>
          <li>Yeast: {{ productStore.selectedProduct.ingredients.yeast }}</li>
        </ul>
      </div>

      <!-- Display ABV, IBU, and Food Pairing -->
      <div class="p-6 bg-gray-100">
        <p class="text-lg font-semibold">Details:</p>
        <p><span class="font-semibold">ABV:</span> {{ productStore.selectedProduct.abv }}</p>
        <p><span class="font-semibold">IBU:</span> {{ productStore.selectedProduct.ibu }}</p>

        <!-- Food Pairing -->
        <div class="mt-4">
          <p class="text-lg font-semibold">Food Pairing:</p>
          <ul class="list-disc pl-4">
            <li v-for="pairing in productStore.selectedProduct.food_pairing" :key="pairing">
              {{ pairing }}
            </li>
          </ul>
        </div>
      </div>

      <!-- Add any other details you want to display -->

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useProductStore } from '@/stores/useProductStore';
import Notification from '@/components/utils/Notification.vue';

const productStore = useProductStore();

onMounted(async () => {
  if (!productStore.selectedProduct) {
    // Fetch product details when the component is mounted
    await productStore.fetchProductDetails(/* pass the product ID here */);
  }
});
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
