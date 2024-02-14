import Login from '@/views/auth/Login.vue';
import Register from '@/views/auth/Register.vue';

import Dashboard from '@/views/basic/Dashboard.vue';
import DefaultPage from '@/views/basic/DefaultPage.vue';
import PageNotFound from '@/views/basic/PageNotFound.vue'; 

import ProductList from '@/views/product/ProductList.vue';
import ProductDetails from '@/views/product/ProductDetails.vue';

const routes = [
  { path: '/', component: DefaultPage, name: 'Home' },
  { path: '/register', component: Register, name: 'Register' },
  { path: '/login', component: Login, name: 'Login' },
  {
    path: '/dashboard',
    component: Dashboard,
    meta: { requiresAuth: true },
    name: 'Dashboard',
  },
  {
    path: '/product-list',
    component: ProductList,
    meta: { requiresAuth: true },
    name: 'Product List',
  },
  {
    path: '/product-detail/:id',
    component: ProductDetails,
    meta: { requiresAuth: true },
    name: 'Product Details',
  },
  { path: '/:pathMatch(.*)*', component: PageNotFound, name: 'Not Found' },
  
];


export default routes ;