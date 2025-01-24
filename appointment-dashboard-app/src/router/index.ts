import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import EditAppointmentView from '../views/EditAppointmentView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path:'/appointment/edit/:id',
      name:'editAppointment',
      component: EditAppointmentView
    },
    {
      path:'/appointment/create',
      name:'createAppointment',
      component: EditAppointmentView
    }
  ],
})

export default router
