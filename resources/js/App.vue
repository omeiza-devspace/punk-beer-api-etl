<template>
    <div id="app" class="font-sans text-center text-gray-700">
      <NavigationMenu />
      <router-view />
      <Footer />
      <!-- <RouteList /> -->
    </div>
  </template>
  
  <script>
  import NavigationMenu from '@/components/layout/NavigationMenu.vue';
  import Footer from '@/components/layout/Footer.vue';
  
  export default {
    name: 'App',
    components: {
      NavigationMenu,
      Footer,
    },
  };
  </script>
  
  <style lang="postcss">
 
  
  #app {
    margin-top: 60px;
  }
  </style>
  