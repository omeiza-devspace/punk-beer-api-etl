<!-- ProductList.vue -->
<template>
  <div>
    <h1>Product List</h1>

    <Notification v-if="productStore.error" message="{{ productStore.error }}" type="error" />

    <ul v-if="!productStore.error">
      <li v-for="product in productStore.products" :key="product.id">
        {{ product.name }}
        <button @click="viewProductDetails(product.id)">View Details</button>
      </li>
    </ul>

    <div>
      <button @click="previousPage" :disabled="productStore.currentPage === 1">Previous Page</button>
      <span>{{ productStore.currentPage }}</span>
      <button @click="nextPage" :disabled="productStore.currentPage * productStore.itemsPerPage >= productStore.totalItems">Next Page</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useProductStore } from '@/stores/productStore';
import Notification from '@/components/utils/Notification.vue';

const productStore = useProductStore();

const products = ref([]);

const fetchProducts = async () => {
  await productStore.fetchPaginatedProducts();
  products.value = productStore.products;
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

onMounted(fetchProducts);
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
