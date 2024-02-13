<template>
  <nav class="bg-gray-800 text-white p-4">
    <div class="flex items-center">
      <h1 class="text-2xl font-bold mr-4">Your Title</h1>
      <ul class="flex space-x-4">
        <li v-for="route in navigationRoutes" :key="route.path">
          <router-link 
            :to="route.path" 
            class="hover:text-gray-300 transition duration-300"
          >
            {{ route.name }}
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import { useRoute } from 'vue-router';

export default {
  setup() {
    const route = useRoute();
    const navigationRoutes = route.router && route.router.options && route.router.options.routes
      ? route.router.options.routes.filter(route => route.path !== '/:catchAll(.*)*')
      : [];
      
    return {
      navigationRoutes,
    };
  },
};
</script>

<style scoped>
/* Add specific styles for this component */
ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin-bottom: 10px;
}

/* Apply styles for top navigation */
nav {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
}

/* Style the links */
a {
  text-decoration: none;
  color: inherit;
}

/* Style the links on hover */
a:hover {
  text-decoration: underline;
}
</style>
