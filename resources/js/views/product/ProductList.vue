<template>
  <div>
    <h1 class="text-2xl font-weight-bold mb-4">Product List</h1>

    <Notification v-if="productStore.error" :message="productStore.error" type="error" />

    <ul v-if="!productStore.error" class="list-unstyled">
      <li v-for="product in productStore.products" :key="product.id" class="mb-4 p-4 border rounded">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h2 class="text-lg font-weight-bold">{{ product.name }}</h2>
            <p class="text-muted">{{ product.tagline }}</p>
          </div>
          <button @click="viewProductDetails(product.id)" class="btn btn-primary">View Details</button>
        </div>
      </li>
    </ul>

    <div class="d-flex align-items-center space-x-4">
      <button @click="previousPage" :disabled="productStore.currentPage === 1" class="btn btn-secondary">Previous Page</button>
      <span class="text-xl font-weight-bold">{{ productStore.currentPage }}</span>
      <button @click="nextPage" :disabled="productStore.currentPage * productStore.itemsPerPage >= productStore.totalItems" class="btn btn-secondary">Next Page</button>
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
