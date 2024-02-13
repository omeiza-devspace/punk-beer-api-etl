import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/views/auth/Login.vue';
import Register from '@/views/auth/Register.vue';

import Dashboard from '@/views/basic/Dashboard.vue';
import DefaultPage from '@/views/basic/DefaultPage.vue';
import PageNotFound from '@/views/basic/PageNotFound.vue'; 

import ProductList from '@/views/product/ProductList.vue';
import ProductDetails from '@/views/product/ProductDetails.vue';

// import RouteList from '@/components/layout/RouteList.vue'; 
import NavigationMenu from '@/components/layout/NavigationMenu.vue'; 
import Footer from '@/components/layout/Footer.vue'; 

const routes = [
  {
    path: '/',
    components: {
      default: DefaultPage,
      navigation: NavigationMenu,
      footer: Footer,
    },
    children: [
    //   {
    //     path: '',
    //     component: RouteList,
    //   },
    ],
  },
  {
    path: '/user-login',
    components: {
      default: Login,
      navigation: NavigationMenu,
      footer: Footer,
    },
  },
  {
    path: '/user-register',
    components: {
      default: Register,
      navigation: NavigationMenu,
      footer: Footer,
    },
  },
  {
    path: '/user-dashboard',
    components: {
      default: Dashboard,
      navigation: NavigationMenu,
      footer: Footer,
    },

    meta: { requiresAuth: true },
  },

  {
    path: '/user-products',
    component: ProductList,
    name: 'productList',
  },
  {
    path: '/user-products/:id',
    component: ProductDetails,
    name: 'productDetails',
  },
  
  {
    path: '/:catchAll(.*)*',
    components:{
        default: PageNotFound,
        footer: Footer,
    },
 },

];

export default routes;
