<!-- src/components/NavigationMenu.vue -->
<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <router-link class="navbar-brand" :to="{ path: '/' }">{{appName}}</router-link>
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
        <ul class="navbar-nav">
          <li v-for="route in routes" :key="route.path" class="nav-item">
            <router-link class="nav-link" :to="route.path">{{ route.name }}</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { computed, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const router = useRouter();

    const routes = ref([]);
    const appName = ref("Punk Beer")

    onMounted(() => {
      routes.value = router.getRoutes().filter(route => route.path !== '/');
    });

    return {
      routes: computed(() => routes.value),
      appName
    };
  },
};
</script>
