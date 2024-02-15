<template>
    <div>
      <ul class="navbar-nav">
          <li v-for="route in routes" :key="route.path" class="nav-item">
            <router-link class="nav-link" :to="route.path">
              {{ route.name }}
            </router-link>
          </li>
        </ul>
    </div>
  </template>
  
  <script setup>

  defineProps( {
    routes: {
      type: Array,
      required: true
    }
  })
    
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
  </style>
  