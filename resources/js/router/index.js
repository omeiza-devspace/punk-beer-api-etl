import routes from './routes';
import { createRouter, createWebHistory } from 'vue-router';
import { useAuth } from '@/stores/useAuthStore';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes,
})

const middleware = (to, from, next) => {
  const auth = useAuth();
  const middleware = to.meta.middleware !== false;

  if (middleware === 'guest' && !auth.isAuthenticated) {
    next({ name: 'login' });
  } else if (middleware === 'auth' && auth.isAuthenticated) {
    next({ name: 'dashboard' });
  } else {
    next();
  }
};

router.beforeEach(middleware);

export default router

