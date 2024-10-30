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
import DailyServicesReport from '@/views/DailyServicesReport.vue'
import DailyRenewsReport from '@/views/DailyRenewsReport.vue'
import CreateService from '@/views/CreateService.vue'
import ManageServices from '@/views/ManageServices.vue'
import EditService from '@/views/EditService.vue'
import MonthlyServicesReport from '@/views/MonthlyServicesReport.vue'
import MonthlyRenewsReport from '@/views/MonthlyRenewsReport.vue'
import ManageUnpaidRenews from '@/views/ManageUnpaidRenews.vue'
import ManageUncheckedRenews from '@/views/ManageUncheckedRenews.vue'
import NoPermission from '@/views/NoPermission.vue'
import CreatePayment from '@/views/CreatePayment.vue'
import EditRenew from '@/views/EditRenew.vue'
import RenewDetails from '@/views/RenewDetails.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard
    },
    {
      path: '/no-permission',
      name: 'no-permission',
      component: NoPermission
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
      path: '/renew-details',
      name: 'renew-details',
      component: RenewDetails
    }, 
    {
      path: '/manage-customers',
      name: 'manage-customers',
      component: ManageCustomers
    },
    {
      path: '/manage-services',
      name: 'manage-services',
      component: ManageServices
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
      path: '/create-service',
      name: 'create-service',
      component: CreateService
    },
    {
      path: '/create-employee',
      name: 'create-employee',
      component: CreateEmployee
    },
    {
      path: '/create-payment',
      name: 'create-payment',
      component: CreatePayment
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
      path: '/edit-service',
      name: 'edit-service',
      component: EditService
    },
    {
      path: '/edit-renew',
      name: 'edit-renew',
      component: EditRenew
    },
    {
      path: '/daily-services-report',
      name: 'daily-services-report',
      component: DailyServicesReport
    },
    {
      path: '/daily-renews-report',
      name: 'daily-renews-report',
      component: DailyRenewsReport
    },
    {
      path: '/monthly-services-report',
      name: 'monthly-services-report',
      component: MonthlyServicesReport
    },
    {
      path: '/monthly-renews-report',
      name: 'monthly-renews-report',
      component: MonthlyRenewsReport
    },
    {
      path: '/unpaid-renews',
      name: 'unpaid-renews',
      component: ManageUnpaidRenews
    },
    {
      path: '/unchecked-renews',
      name: 'unchecked-renews',
      component: ManageUncheckedRenews
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
