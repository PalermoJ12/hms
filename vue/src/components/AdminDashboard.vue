<template>
  <div class="admin-dashboard">
    <h2>Admin Dashboard</h2>

    <div class="filter-container">
      <div class="filter-section">
        <h3>Filter by Doctor</h3>
        <select v-model="selectedDoctor" @change="filterAppointments">
          <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.name">{{ doctor.name }}</option>
        </select>
      </div>

      <div class="filter-section">
        <h3>Filter by Patient</h3>
        <select v-model="selectedPatient" @change="filterAppointments">
          <option v-for="patient in patients" :key="patient.id" :value="patient.name">{{ patient.name }}</option>
        </select>
      </div>
    </div>

    <div class="appointments-container">
      <h3>Appointments</h3>
      <ul class="appointment-list">
        <li v-for="appointment in filteredAppointments" :key="appointment.id" class="appointment-item">
          <div class="appointment-details">
            <span class="appointment-date">{{ appointment.date }} at {{ appointment.time }}</span>
            <span class="appointment-doctor">Doctor: {{ appointment.doctor }}</span>
            <span class="appointment-patient">Patient: {{ appointment.patient }}</span>
            <span class="appointment-status">Status: {{ appointment.status }}</span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminDashboard',
  data() {
    return {
      appointments: [
        // Sample data
        { id: 1, date: '2024-06-20', time: '10:00', doctor: 'Dr. Smith', patient: 'John Doe', status: 'Pending' },
        { id: 2, date: '2024-06-22', time: '14:00', doctor: 'Dr. Brown', patient: 'Jane Smith', status: 'Completed' },
        // Add more sample data as needed
      ],
      doctors: [
        // Sample doctors
        { id: 1, name: 'Dr. Smith' },
        { id: 2, name: 'Dr. Brown' },
        // Add more sample doctors as needed
      ],
      patients: [
        // Sample patients
        { id: 1, name: 'John Doe' },
        { id: 2, name: 'Jane Smith' },
        // Add more sample patients as needed
      ],
      selectedDoctor: '',
      selectedPatient: '',
      filteredAppointments: []
    };
  },
  mounted() {
    this.filteredAppointments = this.appointments;
  },
  methods: {
    filterAppointments() {
      this.filteredAppointments = this.appointments.filter(appointment => {
        return (!this.selectedDoctor || appointment.doctor === this.selectedDoctor) &&
               (!this.selectedPatient || appointment.patient === this.selectedPatient);
      });
    }
  }
}
</script>

<style scoped>
.admin-dashboard {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  color: #2c3e50;
}

.filter-container {
  display: flex;
  justify-content: space-between;
  margin-bottom: 2rem;
}

.filter-section {
  flex: 1;
  margin-right: 1rem;
}

.filter-section h3 {
  margin-bottom: 1rem;
  color: #2c3e50;
}

select {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: #fff;
}

.appointments-container {
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.appointments-container h3 {
  margin-bottom: 1rem;
  color: #2c3e50;
}

.appointment-list {
  list-style: none;
  padding: 0;
}

.appointment-item {
  padding: 1rem;
  border-bottom: 1px solid #ddd;
}

.appointment-item:last-child {
  border-bottom: none;
}

.appointment-details {
  display: flex;
  flex-direction: column;
}

.appointment-date, .appointment-doctor, .appointment-patient, .appointment-status {
  margin: 0.2rem 0;
}
</style>
