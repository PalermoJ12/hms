<template>
    <div class="flex flex-col">
        <div class="text-2xl p-6 text-black">APPOINTMENTS</div>
        <VaCard v-if="user_access === 'patient'" class="w-[1150px] mx-20 min-h-[500px] mt-5 ">
            <div class="relative">

                <div v-if="user_access === 'patient'" class="fixed right-40 top-32 ">

                    <VaButton @click="handleShowAppointmentModal" icon-right="arrow_forward" icon-color="#ffffff50">
                        View Appointments
                    </VaButton>
                </div>
            </div>

            <div class="flex flex-row">
                <VaCardContent class="grid gap-6 mb-6 grid-cols-1 w-1/4">
                    <div>
                        <label for="appointment-date" class="block text-sm font-medium text-gray-700 mb-2">Select
                            Date:</label>
                        <VaDatePicker mode="single" v-model="selectedDate" @update:modelValue="handleDateChange"
                            :highlightToday="true" />
                    </div>

                    <div class="mb-4 w-1/2">
                        <label for="appointment-time" class="block text-sm font-medium text-gray-700">{{ selectedTime ?
                            "Selected Time" : "Select Time: " }}</label>
                        <input type="time" id="appointment-time" v-model="selectedTime" @change="fetchAvailableDoctors"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                </VaCardContent>
                <div v-if="availableDoctors.length > 0" class="p-6 w-3/4 ">
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Available Doctors</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li v-for="doctor in availableDoctors" :key="doctor.id"
                            class="flex items-center justify-between">
                            <span>{{ doctor.user.name }} - {{ doctor.specialization }}</span>
                            <button @click="bookAppointment(doctor.id)"
                                class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Book
                            </button>
                        </li>
                    </ul>
                    <div v-if="error" class="mt-20 text-red-600 flex justify-center items-center">
                        <p>{{ error }}</p>
                    </div>
                </div>
                <div v-else class="p-6 w-3/4 flex justify-center items-center">
                    <p>No available doctors for the selected date and time.</p>
                </div>
            </div>
        </VaCard>
        <VaCard v-if="user_access === 'doctor'" class="w-[1150px] mx-20 min-h-[500px] mt-5">
            <VaCardContent class="grid gap-6 mb-6 grid-cols-1 w-full">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Patient Name</th>
                                <th scope="col" class="px-6 py-3">Appointment Date</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(appointment, index) in doctorsAppointmentPaginatedRecords" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-extrabold">{{ appointment.patient.user.name }}</td>
                                <td class="px-6 py-4">{{ appointment.appointment_date }}</td>
                                <td class="px-6 py-4">
                                    <VaBadge :text="`${appointment.status}`"
                                        :color="appointment.status === 'completed' ? 'success' : appointment.status === 'booked' ? 'secondary' : 'danger'"
                                        class="mr-2" />
                                </td>
                                <td v-if="appointment.status === 'booked'" class="px-6 py-4 space-x-4">
                                    <button @click="handleDone(appointment)">
                                        <VaIcon name="check" size="large" class="hover:text-green-600" />
                                    </button>

                                    <button @click="() => {
                                        showConfirmCancelledModal = !showConfirmCancelledModal
                                        cancelId = appointment.id
                                    }">
                                        <VaIcon name="cancel" size="medium" class="hover:text-red-600" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </VaCardContent>
            <div class="flex justify-end mt-4 mr-4 ">
                <VaPagination v-model="doctorsAppointmentCurrentPage" :pages="doctorsAppointmentTotalPages" />
            </div>
        </VaCard>

        <VaCard v-if="user_access === 'admin'" class="w-[1150px] mx-20 min-h-[500px] mt-5">
            <VaCardContent class="grid gap-6 mb-6 grid-cols-1 w-full">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Patient Name</th>
                                <th scope="col" class="px-6 py-3">Doctor Booked</th>
                                <th scope="col" class="px-6 py-3">Appointment Date</th>
                                <th scope="col" class="px-6 py-3">Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(appointment, index) in allPaginatedRecords" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-extrabold">{{ appointment.patient.user.name }}</td>
                                <td class="px-6 py-4 font-extrabold">{{ appointment.doctor.user.name }}</td>
                                <td class="px-6 py-4">{{ appointment.appointment_date }}</td>
                                <td class="px-6 py-4">
                                    <VaBadge :text="`${appointment.status}`"
                                        :color="appointment.status === 'completed' ? 'success' : appointment.status === 'booked' ? 'secondary' : 'danger'"
                                        class="mr-2" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </VaCardContent>
            <div class="flex justify-end mt-4 mr-4 ">
                <VaPagination v-model="allCurrentPage" :pages="allTotalPages" />
            </div>
        </VaCard>
    </div>

    <VaModal ref="modal" v-model="showAppointmentModal" ok-text="Ok">
        <h4 class="va-h5 flex flex-row justify-between">
            {{ current_user }}
            <span class="text-gray-400 text-sm mr-2">Patient</span>
        </h4>
        <hr>
        <div class="mt-4">

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">Doctor</th>
                            <th scope="col" class="px-6 py-3">Specialization</th>
                            <th scope="col" class="px-6 py-3">Date </th>
                            <th scope="col" class="px-6 py-3">Status </th>
                            <th v-if="user_access === 'patient'" scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(patient, index) in patientOwnRecordPaginatedRecords" :key="index"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                            <td class="px-6 py-4">{{ patient.doctor.user.name }}</td>
                            <td class="px-6 py-4">{{ patient.doctor.specialization }}</td>
                            <td class="px-6 py-4">{{ patient.appointment_date.split('T')[0] }}</td>
                            <td class="px-6 py-4">
                                <VaBadge :text="`${patient.status}`"
                                    :color="patient.status === 'completed' ? 'success' : patient.status === 'booked' ? 'secondary' : 'danger'"
                                    class="mr-2" />
                            </td>
                            <td v-if="user_access === 'patient' && patient.status === 'booked'"
                                class="px-6 py-4 space-x-4">
                                <button @click="() => {
                                    showConfirmCancelledModal = !showConfirmCancelledModal
                                    cancelId = patient.id
                                }">
                                    <VaIcon name="cancel" size="medium" class="hover:text-red-500" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-start mt-4 ml-4">
                <VaPagination v-model="patientOwnRecordCurrentPage" :pages="patientOwnRecordTotalPages" />
            </div>
        </div>
    </VaModal>




    <VaModal v-model="showConfirmCancelledModal" ok-text="Confirm" @ok="cancelAppointment" size="small">
        <h3 class="va-h6">
            Confirm
        </h3>
        <p>
            Are you sure you want to cancel this appointment?
        </p>
    </VaModal>

    <VaModal ref="modal" v-model="doShowModalUpdate" ok-text="Submit" @ok="handleCreateFindings">
        <h4 class="va-h5 flex flex-row justify-between">
            Patient Findings Form
        </h4>
        <hr>
        <VaForm ref="myForm" stateful class="mb-2 flex flex-col gap-4 mt-8" preset="danger">
            <VaTextarea v-model="updateData.record" name="Records" label="Records" />
        </VaForm>
    </VaModal>
</template>
<script>
import axiosClient from '@/axios-config/axios-client';
import { useToast } from 'vuestic-ui'
const { notify } = useToast();


export default {
    data() {
        return {
            user_access: this.$store.state.user_access,
            current_user: this.$store.state.user,
            selectedDate: new Date(),
            selectedTime: '',
            availableDoctors: [],
            error: null,
            today: new Date().toISOString().split('T')[0],
            showAppointmentModal: false,
            showConfirmCancelledModal: false,
            cancelId: 0,
            ownPatientAppointments: [],
            doctorsAppointment: [],
            allAppointments: [],
            patientOwnRecordCurrentPage: 1,
            patientOwnRecordPerPage: 5,
            doctorsAppointmentCurrentPage: 1,
            doctorsAppointmentPerPage: 5,
            allCurrentPage: 1,
            allPerPage: 5,
            doShowModalUpdate: false,
            updateData: {},
        };
    },
    mounted() {
        if (this.user_access === 'doctor') {
            this.fetchDoctorsAppointment();
        }

        if (this.user_access === 'admin') {
            this.fetchAllAppointments();
        }
    },
    methods: {
        handleDateChange() {
            this.selectedTime = '';

        },
        async fetchAllAppointments() {
            try {
                const response = await axiosClient.get('/appointments');
                this.allAppointments = response.data.appointments;
                console.log(response.data.appointments);
                this.error = null;
            } catch (error) {
                console.error(error);
                this.error = 'Failed to fetch appointments';
            }
        },
        async fetchDoctorsAppointment() {
            try {
                const response = await axiosClient.get('/doctors/getAppointments');
                this.doctorsAppointment = response.data.doctor_appointments;
                this.doctorsAppointment = this.doctorsAppointment.sort((a, b) => new Date(a.appointment_date) - new Date(b.appointment_date));
                this.sortAppointments();
                this.error = null;
            } catch (error) {
                console.error(error);
                this.error = 'Failed to fetch appointments';
            }
        },
        sortAppointments() {
            this.doctorsAppointment = this.doctorsAppointment.sort((a, b) => {
                if (a.status === 'booked' && b.status !== 'booked') return -1;
                if (a.status !== 'booked' && b.status === 'booked') return 1;
                return new Date(a.appointment_date) - new Date(b.appointment_date);
            });
        },
        async fetchAvailableDoctors() {
            const formattedDate = this.selectedDate.toISOString().split('T')[0];

            if (!this.selectedDate || !this.selectedTime) return;

            try {
                const response = await axiosClient.get(`/appointments/available`, {
                    params: {
                        date: formattedDate,
                        time: this.selectedTime,
                    }
                });
                this.availableDoctors = response.data.available_doctors;
                console.log(response.data.available_doctors);
                this.error = null;
            } catch (error) {
                console.error(error);
                this.error = 'Failed to fetch available doctors';
            }
        },
        handleDone(data) {
            this.updateData = data;
            console.log("===>", data);
            this.doShowModalUpdate = !this.doShowModalUpdate;
        },
        handleCreateFindings() {
            console.log("id===>", this.updateData.patients_id,);
            axiosClient.post(`/medical-records`, {
                id: this.updateData.id,
                patients_id: this.updateData.patients_id,
                record: this.updateData.record,
            }).then(() => {
                notify('Successfully created findings');
                this.fetchDoctorsAppointment();
            }).catch((err) => {
                console.log(err);
            })


        },
        async bookAppointment(doctorId) {
            try {
                const formattedDateTime = `${this.formatDate(this.selectedDate)} ${this.formatTime(this.selectedTime)}`;
                await axiosClient.post('/appointments/book', {
                    doctor_id: doctorId,
                    appointment_date: formattedDateTime,
                });
                notify('Appointment booked successfully');
                this.selectedTime = '';
                this.availableDoctors = [];
            } catch (error) {
                console.error(error);
                this.error = error.response?.data?.error || 'Failed to book appointment';
            }
        },
        async getPatientOwnAppointments() {
            try {
                const response = await axiosClient.get('/appointments/getOwn');
                console.log(response.data.patient_appointments)
                this.ownPatientAppointments = response.data.patient_appointments;
            } catch (error) {
                console.error(error);
            }
        },
        async cancelAppointment() {

            try {
                const response = await axiosClient.put(`/appointments/${this.cancelId}`);
                console.log(response);
                notify('Appointment cancelled successfully');
                if (this.user_access === 'patient') {
                    this.getPatientOwnAppointments();
                } else if (this.user_access === 'doctor') {
                    this.fetchDoctorsAppointment();
                }
            } catch (error) {
                console.error(error);
            }
        },
        formatDate(date) {
            const d = new Date(date);
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
        formatTime(time) {
            return time ? `${time}:00` : '';
        },

        handleShowAppointmentModal() {
            this.getPatientOwnAppointments();
            this.showAppointmentModal = !this.showAppointmentModal;
        },



    },
    computed: {
        doctorsAppointmentTotalPages() {
            return Math.ceil(this.doctorsAppointment.length / this.doctorsAppointmentPerPage);
        },
        doctorsAppointmentPaginatedRecords() {
            const startIndex = (this.doctorsAppointmentCurrentPage - 1) * this.doctorsAppointmentPerPage;
            return this.doctorsAppointment.slice(startIndex, startIndex + this.doctorsAppointmentPerPage);
        },
        patientOwnRecordTotalPages() {
            return Math.ceil(this.ownPatientAppointments.length / this.patientOwnRecordPerPage);
        },
        patientOwnRecordPaginatedRecords() {
            const startIndex = (this.patientOwnRecordCurrentPage - 1) * this.patientOwnRecordPerPage;
            return this.ownPatientAppointments.slice(startIndex, startIndex + this.patientOwnRecordPerPage);
        },
        allTotalPages() {
            return Math.ceil(this.allAppointments.length / this.allPerPage);
        },
        allPaginatedRecords() {
            const startIndex = (this.allCurrentPage - 1) * this.allPerPage;
            return this.allAppointments.slice(startIndex, startIndex + this.allPerPage);
        },
    },
};
</script>
