import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

const API_URL = '/api/appointments';

export default new Vuex.Store({
  state: {
    appointments: []
  },
  mutations: {
    SET_APPOINTMENTS(state, appointments) {
      state.appointments = appointments;
    },
    ADD_APPOINTMENT(state, appointment) {
      state.appointments.push(appointment);
    },
    UPDATE_APPOINTMENT(state, updatedAppointment) {
      const index = state.appointments.findIndex(a => a.id === updatedAppointment.id);
      if (index !== -1) {
        state.appointments.splice(index, 1, updatedAppointment);
      }
    },
    DELETE_APPOINTMENT(state, id) {
      state.appointments = state.appointments.filter(a => a.id !== id);
    }
  },
  actions: {
    async fetchAppointments({ commit }) {
      try {
        const response = await axios.get(API_URL);
        commit('SET_APPOINTMENTS', response.data);
      } catch (error) {
        console.error('Error fetching appointments:', error);
      }
    },
    async createNewAppointment({ commit }, newAppointment) {
      try {
        const response = await axios.post(API_URL, newAppointment);
        commit('ADD_APPOINTMENT', response.data);
      } catch (error) {
        console.error('Error creating appointment:', error);
      }
    },
    async updateAppointment({ commit }, { id, updatedData }) {
      try {
        await axios.put(`${API_URL}/${id}`, updatedData);
        commit('UPDATE_APPOINTMENT', updatedData);
      } catch (error) {
        console.error(`Error updating appointment with ID ${id}:`, error);
      }
    },
    async deleteAppointment({ commit }, id) {
      try {
        await axios.delete(`${API_URL}/${id}`);
        commit('DELETE_APPOINTMENT', id);
      } catch (error) {
        console.error(`Error deleting appointment with ID ${id}:`, error);
      }
    }
  }
});
