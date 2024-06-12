import { createRouter, createWebHistory } from "vue-router";
import axiosClient from "@/axios-config/axios-client";
import AppointmentsPage from "@/components/AppointmentsPage.vue";
import DashboardPage from "@/components/DashboardPage.vue";
import LoginPage from "@/components/LoginPage.vue";
import MedicalRecords from "@/components/MedicalRecords.vue";
import PatientsPage from "@/components/PatientsPage.vue";
import DoctorsPage from "@/components/DoctorsPage.vue";
import RegisterUserDetails from "@/components/RegisterUserDetails.vue";
import EmailPassword from "@/components/EmailPassword.vue";

const routes = [
  {
    path: "/Dashboard",
    component: DashboardPage,
    name: "DashboardPage",
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem("token")) {
        if (localStorage.getItem("user_access") === "patient") {
          next("/Appointments");
        } else if (
          localStorage.getItem("user_access") === "doctor" ||
          localStorage.getItem("user_access") === "admin"
        ) {
          next();
        }
      } else {
        next("/");
      }
    },
  },
  {
    path: "/Patients",
    component: PatientsPage,
    name: "PatientsPage",
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem("token")) {
        if (
          localStorage.getItem("user_access") === "admin" ||
          localStorage.getItem("user_access") === "doctor"
        ) {
          next();
        } else {
          next("/Dashboard");
        }
      } else {
        next("/");
      }
    },
  },
  {
    path: "/MedicalRecords",
    component: MedicalRecords,
    name: "MedicalRecords",
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem("token")) {
        if (
          localStorage.getItem("user_access") === "admin" ||
          localStorage.getItem("user_access") === "doctor"
        ) {
          next();
        } else {
          next("/Dashboard");
        }
      } else {
        next("/");
      }
    },
  },
  {
    path: "/Appointments",
    component: AppointmentsPage,
    name: "AppointmentsPage",
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem("token")) {
        next();
      } else {
        next("/");
      }
    },
  },
  {
    path: "/Doctors",
    component: DoctorsPage,
    name: "Doctors",
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem("token")) {
        if (localStorage.getItem("user_access") === "admin") {
          next();
        } else {
          next("/Dashboard");
        }
      } else {
        next("/");
      }
    },
  },
  {
    path: "/register",
    name: "UserDetails",
    component: RegisterUserDetails,
    beforeEnter: (to, from, next) => {
      if (!localStorage.getItem("token")) {
        next();
      } else {
        next("/Dashboard");
      }
    },
  },
  {
    path: "/register/email-password",
    name: "EmailPassword",
    component: EmailPassword,
    beforeEnter: (to, from, next) => {
      if (!localStorage.getItem("token")) {
        next();
      } else {
        next("/Dashboard");
      }
    },
  },

  {
    path: "/",
    component: LoginPage,
    name: "LoginPage",
    beforeEnter: (to, from, next) => {
      if (!localStorage.getItem("token")) {
        next();
      } else {
        next("/Dashboard");
      }
    },
  },
  {
    path: "/logout",
    name: "logout",
    beforeEnter: async (to, from, next) => {
      await axiosClient
        .post("/logout")
        .then(() => {
          console.log("logout");
          localStorage.removeItem("id");
          localStorage.removeItem("token");
          localStorage.removeItem("current_user");
          localStorage.removeItem("user_access");
          window.location.reload();
          next("/");
        })
        .catch((err) => console.log(err));
    },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
