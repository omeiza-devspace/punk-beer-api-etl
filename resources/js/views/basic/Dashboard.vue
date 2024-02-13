<template>
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Welcome to the Dashboard</h1>
    <p class="mb-4">This is the dashboard for authenticated users. Add your content here.</p>

    <div class="metric mt-8">
      <h2 class="text-xl font-semibold">Example Metric</h2>
      <p class="mt-2">Counter: {{ counter }}</p>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue';

export default {
  name: 'Dashboard',
  setup() {
    const counter = ref(0);

    const incrementCounter = () => {
      counter.value += 1;
    };

    // Example: Increment the counter every second
    const intervalId = setInterval(incrementCounter, 1000);

    onBeforeUnmount(() => {
      // Cleanup interval on component unmount
      clearInterval(intervalId);
    });

    return {
      counter,
    };
  },
};
</script>

<style scoped>
/* Add specific styles for this component */
.container {
  text-align: center;
  margin-top: 20px;
}

.metric {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
}
</style>
