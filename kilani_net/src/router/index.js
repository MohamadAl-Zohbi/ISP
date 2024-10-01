import { createRouter, createWebHistory } from 'vue-router'
import Customers from '../views/Customers.vue'
import Dashboard from '../views/Dashboard.vue'
import Search from '../views/Search.vue'
import CustomerDetails from '../views/CustomerDetails.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard
    },
    {
      path: '/customers',
      name: 'customers',
      component: Customers
    }, 
    {
      path: '/customer-details',
      name: 'customer-details',
      component: CustomerDetails
    }, 
    {
      path: '/search',
      name: 'search',
      component: Search
    },
    {
      path: '/login',
      name: 'login',
      // route level code-splitting
      // this generates a separate chunk (login.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/LogIn.vue')
    }
  ]
})

export default router
