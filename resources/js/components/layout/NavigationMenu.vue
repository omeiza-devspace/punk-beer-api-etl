<!-- src/components/NavigationMenu.vue -->
<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <router-link class="navbar-brand" :to="{ path: '/' }">{{ appName }}</router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <RouteList :routes="filteredRoutes"/>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import RouteList from '@/components/layout/RouteList.vue';
import { useAuth } from '@/stores/useAuthStore';

const appName = ref("Punk Beer");
const router = useRouter();
const auth = useAuth();
const routes = computed(() => router.getRoutes());
const filteredRoutes = computed(() => {
  return auth.isAuthenticated
    ? routes.value.filter(route => route.meta.middleware === 'auth')
    : routes.value.filter(route => route.meta.middleware === 'guest');
});

onMounted(() => {
  // Additional setup if needed
});
</script>

<style scoped>
/* Add specific styles for this component */
/* You can customize Bootstrap styling here if needed */
</style>
