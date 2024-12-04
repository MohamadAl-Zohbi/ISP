import { createRouter, createWebHistory } from 'vue-router'
import Customers from '@/views/super/Customers.vue'
import Dashboard from '@/views/super/Dashboard.vue'
import ManageCustomers from '@/views/super/ManageCustomers.vue'
import CustomerDetails from '@/views/super/CustomerDetails.vue'
import CreateRenew from '@/views/super/CreateRenew.vue'
import  CreateCustomer from '@/views/super/CreateCustomer.vue'
import  EditCustomer from '@/views/super/EditCustomer.vue'
import  EditEmployee from '@/views/super/EditEmployee.vue'
import  CreateEmployee from '@/views/super/CreateEmployee.vue'
import  ManageEmployees from '@/views/super/ManageEmployees.vue'
import DailyServicesReport from '@/views/super/DailyServicesReport.vue'
import DailyRenewsReport from '@/views/super/DailyRenewsReport.vue'
import CreateService from '@/views/super/CreateService.vue'
import ManageServices from '@/views/super/ManageServices.vue'
import EditService from '@/views/super/EditService.vue'
import MonthlyServicesReport from '@/views/super/MonthlyServicesReport.vue'
import MonthlyRenewsReport from '@/views/super/MonthlyRenewsReport.vue'
import ManageUnpaidRenews from '@/views/super/ManageUnpaidRenews.vue'
import ManageUncheckedRenews from '@/views/super/ManageUncheckedRenews.vue'
import NoPermission from '@/views/super/NoPermission.vue'
import CreatePayment from '@/views/super/CreatePayment.vue'
import EditRenew from '@/views/super/EditRenew.vue'
import RenewDetails from '@/views/super/RenewDetails.vue'
import PrintPayment from '@/views/super/PrintPayment.vue'

const super_rank = 'super';
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: `/${super_rank}/`,
      name: `dashboard`,
      component: Dashboard
    },
    {
      path: `/${super_rank}/no-permission`,
      name: `no-permission`,
      component: NoPermission
    },
    {
      path: `/${super_rank}/customers`,
      name: `customers`,
      component: Customers
    }, 
    {
      path: `/${super_rank}/create-customer`,
      name: `create-customer`,
      component: CreateCustomer
    }, 
    {
      path: `/${super_rank}/customer-details`,
      name: `customer-details`,
      component: CustomerDetails
    }, 
    {
      path: `/${super_rank}/renew-details`,
      name: `renew-details`,
      component: RenewDetails
    }, 
    {
      path: `/${super_rank}/print-payment`,
      name: `print-payment`,
      component: PrintPayment
    }, 
    {
      path: `/${super_rank}/manage-customers`,
      name: `manage-customers`,
      component: ManageCustomers
    },
    {
      path: `/${super_rank}/manage-services`,
      name: `manage-services`,
      component: ManageServices
    },
    {
      path: `/${super_rank}/manage-employees`,
      name: `manage-employees`,
      component: ManageEmployees
    },

    {
      path: `/${super_rank}/create-renew`,
      name: `create-renew`,
      component: CreateRenew
    },
    {
      path: `/${super_rank}/create-service`,
      name: `create-service`,
      component: CreateService
    },
    {
      path: `/${super_rank}/create-employee`,
      name: `create-employee`,
      component: CreateEmployee
    },
    {
      path: `/${super_rank}/create-payment`,
      name: `create-payment`,
      component: CreatePayment
    },
    {
      path: `/${super_rank}/edit-customer`,
      name: `edit-customer`,
      component: EditCustomer
    },
    {
      path: `/${super_rank}/edit-employee`,
      name: `edit-employee`,
      component: EditEmployee
    },
    {
      path: `/${super_rank}/edit-service`,
      name: `edit-service`,
      component: EditService
    },
    {
      path: `/${super_rank}/edit-renew`,
      name: `edit-renew`,
      component: EditRenew
    },
    {
      path: `/${super_rank}/daily-services-report`,
      name: `daily-services-report`,
      component: DailyServicesReport
    },
    {
      path: `/${super_rank}/daily-renews-report`,
      name: `daily-renews-report`,
      component: DailyRenewsReport
    },
    {
      path: `/${super_rank}/monthly-services-report`,
      name: `monthly-services-report`,
      component: MonthlyServicesReport
    },
    {
      path: `/${super_rank}/monthly-renews-report`,
      name: `monthly-renews-report`,
      component: MonthlyRenewsReport
    },
    {
      path: `/${super_rank}/unpaid-renews`,
      name: `unpaid-renews`,
      component: ManageUnpaidRenews
    },
    {
      path: `/${super_rank}/unchecked-renews`,
      name: `unchecked-renews`,
      component: ManageUncheckedRenews
    },
    {
      path: `/login`,
      name: `login`,
      // route level code-splitting
      // this generates a separate chunk (login.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('@/views/super/LogIn.vue')
    }
  ]
})

export default router
