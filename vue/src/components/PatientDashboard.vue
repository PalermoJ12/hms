<template>
  <div class="patient-dashboard">
    <h2>Patient Dashboard</h2>
    
    <div class="dashboard-container">
      <section class="book-appointment">
        <h3>Appointment Form</h3>
        <form @submit.prevent="bookAppointment">
          <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" v-model="newAppointment.date" required>
          </div>
          <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" v-model="newAppointment.time" required>
          </div>
          <div class="form-group">
            <label for="doctor">Doctor:</label>
            <input type="text" v-model="newAppointment.doctor" placeholder="Enter Doctor's Name" required>
          </div>
          <button type="submit" class="btn-primary">Book Appointment</button>
        </form>
      </section>
      
      <section class="view-appointments">
        <h3>My Appointments</h3>
        <ul class="appointment-list">
          <li v-for="appointment in appointments" :key="appointment.id" class="appointment-item">
            <span>{{ appointment.date }} at {{ appointment.time }} with Dr. {{ appointment.doctor }}</span>
            <button @click="cancelAppointment(appointment.id)" class="btn-danger">Cancel</button>
          </li>
        </ul>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PatientDashboard',
  data() {
    return {
      newAppointment: {
        date: '',
        time: '',
        doctor: ''
      },
      appointments: [
        // Sample data
        { id: 1, date: '2024-06-20', time: '10:00', doctor: 'Smith' },
        { id: 2, date: '2024-06-22', time: '14:00', doctor: 'Johnson' }
      ]
    };
  },
  methods: {
    bookAppointment() {
      const newId = this.appointments.length + 1;
      this.appointments.push({ id: newId, ...this.newAppointment });
      this.newAppointment = { date: '', time: '', doctor: '' }; // Reset form
    },
    cancelAppointment(id) {
      this.appointments = this.appointments.filter(appointment => appointment.id !== id);
    }
  }
}
</script>

<style scoped>
.patient-dashboard {
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
}

.dashboard-container {
  display: flex;
  justify-content: space-between;
  gap: 2rem;
}

.book-appointment, .view-appointments {
  flex: 1;
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.book-appointment h3, .view-appointments h3 {
  margin-bottom: 1rem;
  color: #333;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  text-align: left;
}

.form-group input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.btn-primary {
  display: inline-block;
  padding: 0.5rem 1rem;
  color: #fff;
  background-color: #4CAF50;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-primary:hover {
  background-color: #45a049;
}

.view-appointments .appointment-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.appointment-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #ddd;
}

.appointment-item:last-child {
  border-bottom: none;
}

.btn-danger {
  padding: 0.5rem 1rem;
  color: #fff;
  background-color: #e74c3c;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-danger:hover {
  background-color: #c0392b;
}
</style>
