<template>
    <div v-if="isVisible" :class="['notification', type]">
      {{ message }}
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  
  export default {
    props: {
      message: String,
      type: {
        type: String,
        default: 'info',
      },
    },
    setup(props) {
      const isVisible = ref(false);
  
      onMounted(() => {
        isVisible.value = true;
        setTimeout(() => {
          isVisible.value = false;
        }, 3000); // Hide the notification after 3 seconds
      });
  
      return {
        isVisible,
      };
    },
  };
  </script>
  
  <style scoped>
  .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px;
    border-radius: 5px;
    color: #fff;
    font-weight: bold;
  }
  
  .info {
    background-color: #3498db;
  }
  
  .success {
    background-color: #2ecc71;
  }
  
  .error {
    background-color: #e74c3c;
  }
  </style>
  