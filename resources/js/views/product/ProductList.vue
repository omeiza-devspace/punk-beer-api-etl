<template>
  <div>
    <h1 class="text-2xl font-semibold mb-4">Product List</h1>

    <Notification v-if="productStore.error" :message="productStore.error" type="error" />

    <ul v-if="!productStore.error">
      <li v-for="product in productStore.products" :key="product.id" class="mb-4 p-4 border rounded">
        <div class="flex justify-between items-center">
          <div>
            <h2 class="text-lg font-semibold">{{ product.name }}</h2>
            <p class="text-gray-600">{{ product.tagline }}</p>
          </div>
          <button @click="viewProductDetails(product.id)" class="bg-blue-500 text-white px-3 py-1 rounded">View Details</button>
        </div>
      </li>
    </ul>

    <div class="flex items-center space-x-4">
      <button @click="previousPage" :disabled="productStore.currentPage === 1" class="px-4 py-2 bg-gray-300 rounded">Previous Page</button>
      <span class="text-xl font-semibold">{{ productStore.currentPage }}</span>
      <button @click="nextPage" :disabled="productStore.currentPage * productStore.itemsPerPage >= productStore.totalItems" class="px-4 py-2 bg-gray-300 rounded">Next Page</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useProductStore } from '@/stores/useProductStore';
import Notification from '@/components/utils/Notification.vue';

const productStore = useProductStore();

onMounted(fetchProducts);

const fetchProducts = async () => {
  await productStore.fetchPaginatedProducts();
};

const viewProductDetails = async (productId) => {
  await productStore.searchProductById(productId);
  // Implement logic to navigate to the product details page
};

const nextPage = async () => {
  await productStore.goToPage(productStore.currentPage + 1);
  fetchProducts();
};

const previousPage = async () => {
  await productStore.goToPage(productStore.currentPage - 1);
  fetchProducts();
};
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
