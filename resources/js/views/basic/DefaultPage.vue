<template>
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Welcome to Punk Beer</h1>
    <p class="mb-4">This is the landing page for guests.</p>
    <router-link to="/user-login" class="text-blue-500 hover:underline mr-4">Login</router-link>
    <router-link to="/user-register" class="text-blue-500 hover:underline">Register</router-link>
  </div>
</template>

<script>
export default {
  name: 'DefaultPage',
};
</script>

<style scoped>
/* Add specific styles for this component */
.container {
  text-align: center;
  margin-top: 20px;
}
</style>
