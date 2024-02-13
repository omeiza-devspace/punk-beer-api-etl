<template>
    <div>
      <h2>Routes List</h2>
      <ul>
        <li v-for="route in routes" :key="route.path">
          {{ route.path }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import { routes } from '@/router/routes'; 
  
  export default {
    name: 'RouteList',
    setup() {
      return {
        routes,
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
  </style>
  