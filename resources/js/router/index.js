import routes from './routes';
import { createRouter, createWebHistory } from 'vue-router';
import { useAuth } from '@/stores/useAuthStore';



const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes,
})


router.beforeEach((to, from, next) => {
  const auth = useAuth();
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    // Check if the route requires authentication
    if (auth.isAuthenticated) {
      // User is authenticated, proceed to the route
      next();
    } else {
      // User is not authenticated, redirect to login
      next('/login');
    }
  } else {
    // Route does not require authentication, proceed to the route
    next();
  }
});

export default router

