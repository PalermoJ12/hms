import { createRouter, createWebHistory } from "vue-router";
import AppointmentsPage from "@/components/AppointmentsPage.vue";
import DashboardPage from "@/components/DashboardPage.vue";
import LoginPage from "@/components/LoginPage.vue";
import MedicalRecords from "@/components/MedicalRecords.vue";
import PatientsPage from "@/components/PatientsPage.vue";
import ManageUser from "@/components/ManageUser.vue";
import DoctorPage from "@/components/DoctorPage.vue";

const routes = [
  {
    path: "/Dashboard",
    component: DashboardPage,
    name: "DashboardPage",
  },
  {
    path: "/Patients",
    component: PatientsPage,
    name: "PatientsPage",
  },
  {
    path: "/doctors",
    component: DoctorPage,
    name: "doctor",
  },
  {
    path: "/MedicalRecords",
    component: MedicalRecords,
    name: "MedicalRecords",
  },
  {
    path: "/Appointments",
    component: AppointmentsPage,
    name: "AppointmentsPage",
  },
  {
    path: "/ManageUsers",
    component: ManageUser,
    name: "ManageUsers",
  },
  {
    path: "/",
    component: LoginPage,
    name: "LoginPage",
  },
  {
    path: "/logout",
    name: "logout",
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
