<template>
  <div class="doctor-dashboard">
    <h2>Doctor Dashboard</h2>

    <div class="dashboard-container">
      <section v-if="!selectedPatient" class="scheduled-appointments">
        <h3>Scheduled Appointments</h3>
        <ul class="appointment-list">
          <li v-for="appointment in appointments" :key="appointment.id" class="appointment-item">
            <div class="appointment-details">
              <span class="appointment-date">{{ appointment.date }} at {{ appointment.time }}</span>
              <span class="appointment-patient">Patient: {{ appointment.patient }}</span>
              <span class="appointment-status">Status: {{ appointment.status }}</span>
            </div>
            <div class="appointment-actions">
              <button @click="viewPatientMedicalRecord(appointment.patient)" class="btn-primary">
                <i class="fas fa-notes-medical"></i> View Medical Record
              </button>
              <button @click="markAsCompleted(appointment.id)" class="btn-secondary" :disabled="appointment.status === 'Completed'">
                <i class="fas fa-check"></i> Mark as Completed
              </button>
            </div>
          </li>
        </ul>
      </section>

      <section v-if="selectedPatient" class="patient-medical-record">
        <h3>Medical Record for {{ selectedPatient }}</h3>
        <div class="personal-data-sheet">
          <div class="section general-info">
            <h4>General Information</h4>
            <p><strong>Name:</strong> {{ selectedPatient }}</p>
            <p><strong>Age:</strong> 35</p>
            <p><strong>Gender:</strong> Male</p>
            <p><strong>Contact:</strong> (555) 123-4567</p>
          </div>
          <div class="section medical-history">
            <h4>Medical History</h4>
            <textarea v-model="medicalRecord.history" placeholder="Enter patient history"></textarea>
          </div>
          <div class="section medications">
            <h4>Medications</h4>
            <textarea v-model="medicalRecord.medications" placeholder="Enter medications"></textarea>
          </div>
          <div class="section allergies">
            <h4>Allergies</h4>
            <textarea v-model="medicalRecord.allergies" placeholder="Enter allergies"></textarea>
          </div>
          <div class="section doctors-notes">
            <h4>Doctor's Notes</h4>
            <textarea v-model="medicalRecord.notes" placeholder="Enter notes"></textarea>
          </div>
          <div class="action-buttons">
            <button @click="saveMedicalRecord" class="btn-danger">
              <i class="fas fa-save"></i> Save
            </button>
            <button @click="closeMedicalRecord" class="btn-danger">
              <i class="fas fa-times"></i> Close
            </button>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DoctorDashboard',
  data() {
    return {
      appointments: [
        // Sample data
        { id: 1, date: '2024-06-20', time: '10:00', patient: 'John Doe', status: 'Pending' },
        { id: 2, date: '2024-06-22', time: '14:00', patient: 'Jane Smith', status: 'Pending' }
      ],
      selectedPatient: '',
      medicalRecord: {
        history: '',
        medications: '',
        allergies: '',
        notes: ''
      }
    };
  },
  methods: {
    viewPatientMedicalRecord(patient) {
      // Mock function to retrieve medical record for selected patient
      // In a real application, this would fetch data from a backend service
      this.selectedPatient = patient;
      this.medicalRecord = {
        history: 'Sample patient history...',
        medications: 'Sample medications...',
        allergies: 'Sample allergies...',
        notes: 'Sample doctor notes...'
      };
    },
    saveMedicalRecord() {
      // Mock function to save/update patient medical record
      // In a real application, this would send data to a backend service
      console.log('Medical record saved:', this.medicalRecord);
      alert('Medical record saved successfully!');
    },
    markAsCompleted(appointmentId) {
      // Update the appointment status to "Completed"
      const appointment = this.appointments.find(app => app.id === appointmentId);
      if (appointment) {
        appointment.status = 'Completed';
        console.log(`Appointment with ID ${appointmentId} marked as completed.`);
      }
    },
    closeMedicalRecord() {
      this.selectedPatient = '';
      this.medicalRecord = {
        history: '',
        medications: '',
        allergies: '',
        notes: ''
      };
    }
  }
}
</script>

<style scoped>
.doctor-dashboard {
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

.dashboard-container {
  display: flex;
  justify-content: space-between;
  gap: 2rem;
}

.scheduled-appointments, .patient-medical-record {
  flex: 1;
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.scheduled-appointments h3, .patient-medical-record h3 {
  margin-bottom: 1rem;
  color: #2c3e50;
}

.appointment-list {
  list-style: none;
  padding: 0;
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

.appointment-details {
  display: flex;
  flex-direction: column;
}

.appointment-date, .appointment-patient, .appointment-status {
  margin: 0.2rem 0;
}

.appointment-actions {
  display: flex;
  gap: 0.5rem;
}

.btn-primary {
  padding: 0.5rem 1rem;
  color: #fff;
  background-color: #4CAF50;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-primary:hover {
  background-color: #45a049;
}

.btn-secondary {
  padding: 0.5rem 1rem;
  color: #fff;
  background-color: #2196F3;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-secondary:hover {
  background-color: #1976D2;
}

.personal-data-sheet {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.section {
  padding: 1rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f4f4f4;
}

.section h4 {
  margin-bottom: 1rem;
  color: #2c3e50;
}

.general-info p {
  margin: 0.5rem 0;
  text-align: left;
}

textarea {
  width: 100%;
  height: 60px;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  resize: none;
  background-color: #fff;
}

.btn-danger {
  padding: 0.5rem 1rem;
  color: #fff;
  background-color: #1976D2;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 10px;
}

.btn-danger:hover {
  background-color: #c0392b;
}
</style>
