import Login from '@/views/auth/Login.vue';
import Register from '@/views/auth/Register.vue';

import Dashboard from '@/views/basic/Dashboard.vue';
import DefaultPage from '@/views/basic/DefaultPage.vue';
import PageNotFound from '@/views/basic/PageNotFound.vue'; 

import BeerList from '@/views/beer/BeerList.vue';
import BeerDetails from '@/views/beer/BeerDetails.vue';

const routes = [
  { path: '/', 
    component: DefaultPage, 
    meta: { middleware: "default" },
    name: 'Home' 
  },
  { 
    path: '/register', 
    component: Register, 
    meta: { middleware: "guest" },
    name: 'Register' 
  },
  { 
    path: '/login', 
    component: Login, 
    meta: { middleware: "guest" },
    name: 'Login' 
  },
  {
    path: '/dashboard',
    component: Dashboard,
    meta: { middleware: "auth" },
    name: 'Dashboard',
  },
  {
    path: '/beers',
    component: BeerList,
    meta: { middleware: "auth" },
    name: 'Beer List',
  },
  {
    path: '/beers/:id',
    component: BeerDetails,
    meta: { middleware: "auth" },
    name: 'Beer Details',
  },
  { 
    path: '/:pathMatch(.*)*', 
    component: PageNotFound, 
    name: 'Not Found',  
    meta: { middleware: "default" 
  },
},
  
];


export default routes ;