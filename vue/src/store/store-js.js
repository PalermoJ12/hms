import { createStore } from "vuex";
import axiosClient from "../axios-config/axios-client";

const store = createStore({
  state() {
    return {
      patientRecords: [],
      doctorsPatient: [],
      patientOwnRecords: [],
      patientMedicalRecords: [],
      doctors: [],
      doctorsProfile: [],
      newUser: {},
      id: localStorage.getItem("id"),
      userLogged: localStorage.getItem("token"),
      user: localStorage.getItem("current_user"),
      user_access: localStorage.getItem("user_access"),
    };
  },
  mutations: {
    setPatientRecords(state, records) {
      state.patientRecords = records;
    },
    setDoctors(state, doctor) {
      state.doctors = doctor;
    },
    setDoctorOwn(state, doctor) {
      state.doctorsProfile = doctor;
    },
    setPatientProfile(state, patient) {
      state.patientOwnRecords = patient;
    },
    setPatientOwnRecord(state, record) {
      state.patientMedicalRecords = record;
    },
    setDoctorsPatient(state, record) {
      state.doctorsPatient = record;
    },
    setNewUser(state, user) {
      state.newUser = user;
    },
  },
  actions: {
    async getPatientRecords({ commit }) {
      try {
        const res = await axiosClient.get("/patients");
        console.log(res);
        commit("setPatientRecords", res.data.patients);
      } catch (err) {
        console.error(err);
      }
    },

    async getDoctors({ commit }) {
      try {
        const res = await axiosClient.get("/doctors");

        commit("setDoctors", res.data.doctor);
      } catch (err) {
        console.error(err);
      }
    },
    async getDoctorOwnProfile({ commit }) {
      try {
        console.log(this.state.id);
        const res = await axiosClient.get(`/doctors/find/${this.state.id}`);
        console.log(res.data);
        commit("setDoctorOwn", res.data.doctor);
      } catch (err) {
        console.error(err);
      }
    },
    async getPatientProfile({ commit }) {
      try {
        console.log(this.state.id);
        const res = await axiosClient.get(`/patients/find/${this.state.id}`);
        console.log(res);
        commit("setPatientProfile", res.data.patient);
      } catch (err) {
        console.error(err);
      }
    },
    async getPatientOwnRecords({ commit }) {
      try {
        const res = await axiosClient.get(`/medical-records/ownRecords`);

        commit("setPatientOwnRecord", res.data.records);
      } catch (err) {
        console.error(err);
      }
    },

    async getDoctorsPatient({ commit }) {
      try {
        const res = await axiosClient.get(`/medical/doctor-patient`);
        console.log("====>", res.data);
        commit("setDoctorsPatient", res.data.records);
      } catch (err) {
        console.error(err);
      }
    },
  },
  getters: {
    allProducts: (state) => state.products,
    newUser: (state) => state.newUser,
    patientProfile: (state) => state.patientOwnRecords,
    getPatients: (state) => state.patientRecords,
    doctorProfile: (state) => state.doctorsProfile,
    patientRecords: (state) => state.patientMedicalRecords,
    doctorsPatient: (state) => state.doctorsPatient,
  },
});

export default store;
