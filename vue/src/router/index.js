// src/router/index.js
import Vue from 'vue'
import Router from 'vue-router'
import AdminDashboard from '../components/AdminDashboard.vue'
import DoctorDashboard from '../components/DoctorDashboard.vue'
import PatientDashboard from '../components/PatientDashboard.vue'
import HomePage from '../components/HomePage.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HomePage',
      component: HomePage
    },
    {
      path: '/admin',
      name: 'AdminDashboard',
      component: AdminDashboard
    },
    {
      path: '/doctor',
      name: 'DoctorDashboard',
      component: DoctorDashboard
    },
    {
      path: '/patient',
      name: 'PatientDashboard',
      component: PatientDashboard
    }
  ]
})
