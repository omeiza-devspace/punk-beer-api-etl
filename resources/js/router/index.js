import routes from './routes';
import {
    createRouter,
    createWebHistory,
  } from 'vue-router';


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes,
})

// router.beforeEach((to, from, next) => {
//   document.title = to.meta.title
//   if (to.meta.middleware == "guest") {
//       if (store.state.auth.authenticated) {
//           next({ name: "dashboard" })
//       }
//       next()
//   } else {
//       if (store.state.auth.authenticated) {
//           next()
//       } else {
//           next({ name: "login" })
//       }
//   }
// })

export default router

