import { createRouter, createWebHistory } from 'vue-router'
import Customers from '../views/Customers.vue'
import Dashboard from '../views/Dashboard.vue'
import ManageCustomers from '../views/ManageCustomers.vue'
import CustomerDetails from '../views/CustomerDetails.vue'
import CreateRenew from '../views/CreateRenew.vue'
import  CreateCustomer from '../views/CreateCustomer.vue'
import  EditCustomer from '../views/EditCustomer.vue'
import  EditEmployee from '../views/EditEmployee.vue'
import  CreateEmployee from '../views/CreateEmployee.vue'
import  ManageEmployees from '../views/ManageEmployees.vue'

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
      path: '/create-customer',
      name: 'create-customer',
      component: CreateCustomer
    }, 
    {
      path: '/customer-details',
      name: 'customer-details',
      component: CustomerDetails
    }, 
    {
      path: '/manage-customers',
      name: 'manage-customers',
      component: ManageCustomers
    },
    {
      path: '/manage-employees',
      name: 'manage-employees',
      component: ManageEmployees
    },

    {
      path: '/create-renew',
      name: 'create-renew',
      component: CreateRenew
    },
    {
      path: '/create-employee',
      name: 'create-employee',
      component: CreateEmployee
    },
    {
      path: '/edit-customer',
      name: 'edit-customer',
      component: EditCustomer
    },
    {
      path: '/edit-employee',
      name: 'edit-employee',
      component: EditEmployee
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
