<!-- components/utils/Loading.vue -->
<template>
  <div v-if="loading" class="loading-overlay">
    <div class="loading-spinner"></div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useLoading } from '@/helpers/useLoading';

const loading = ref(useLoading().isLoading);

// Watch for changes in the loading state
watch(() => useLoading().isLoading, (newLoading) => {
  loading.value = newLoading;
});
</script>

<style scoped>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.loading-spinner {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
