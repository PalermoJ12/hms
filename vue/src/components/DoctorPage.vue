<template>
    <div class="container mx-auto p-4">
        
        <!-- Form to add a new doctor -->
        <form @submit.prevent="addDoctor" class="mt-8 max-w-md mx-auto p-4 border border-gray-200 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-center text-black ">Add New Doctor</h2>
            <input type="text" v-model="newDoctor.name" placeholder="Name" required class="border border-gray-300 px-4 py-2 rounded-md mb-2 w-full text-black">
            <input type="text" v-model="newDoctor.specialization" placeholder="Specialization" required class="border border-gray-300 px-4 py-2 rounded-md mb-2 w-full text-black">
            <input type="text" v-model="newDoctor.phone" placeholder="Phone" required class="border border-gray-300 px-4 py-2 rounded-md mb-2 w-full text-black">
            <input type="email" v-model="newDoctor.email" placeholder="Email" required class="border border-gray-300 px-4 py-2 rounded-md mb-2 w-full text-black">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md w-full mt-2 hover:bg-blue-600 transition">Add Doctor</button>
        </form>
        <br>
        <!-- Display list of doctors -->
        <h1 class="text-3xl font-bold mb-6 text-center text-black">Doctors</h1>
        <div v-if="doctors.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="doctor in doctors" :key="doctor.id" class="p-4 border border-gray-200 rounded-lg shadow-md bg-gray-800">
                <p class="text-xl font-semibold text-white">DOCTOR {{ doctor.name }}</p>
                <p class="text-gray-300">{{ doctor.specialization }}</p>
                <p class="text-gray-300">{{ doctor.phone }}</p>
                <p class="text-gray-300">{{ doctor.email }}</p>
                <button @click="editDoctor(doctor)" class="bg-yellow-500 text-white px-4 py-2 rounded-md mt-2 hover:bg-yellow-600 transition">Edit</button>
                <button @click="deleteDoctor(doctor.id)" class="bg-red-500 text-white px-4 py-2 rounded-md mt-2 hover:bg-red-600 transition">Delete</button>
            </div>
        </div>
        <div v-else class="text-center text-gray-500">No doctors found.</div>

        <!-- Form to edit a doctor's profile -->
        <form v-if="editMode" @submit.prevent="updateDoctor" class="mt-8 max-w-md mx-auto p-4 border border-gray-200 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-center text-black">Edit Doctor</h2>
            <input type="text" v-model="currentDoctor.name" placeholder="Name" required class="border border-gray-300 px-4 py-2 rounded-md mb-2 w-full text-black">
            <input type="text" v-model="currentDoctor.specialization" placeholder="Specialization" required class="border border-gray-300 px-4 py-2 rounded-md mb-2 w-full text-black">
            <input type="text" v-model="currentDoctor.phone" placeholder="Phone" required class="border border-gray-300 px-4 py-2 rounded-md mb-2 w-full text-black">
            <input type="email" v-model="currentDoctor.email" placeholder="Email" required class="border border-gray-300 px-4 py-2 rounded-md mb-2 w-full text-black">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md w-full mt-2 hover:bg-green-600 transition">Update Doctor</button>
            <button @click="cancelEdit" class="bg-gray-500 text-white px-4 py-2 rounded-md w-full mt-2 hover:bg-gray-600 transition">Cancel</button>
        </form>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            doctors: [],
            newDoctor: {
                name: '',
                specialization: '',
                phone: '',
                email: ''
            },
            currentDoctor: null,
            editMode: false
        };
    },
    mounted() {
        this.fetchDoctors();
    },
    methods: {
        fetchDoctors() {
            axios.get('http://127.0.0.1:8000/api/doctors')
                .then(response => {
                    this.doctors = response.data;
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                });
        },
        addDoctor() {
            axios.post('http://127.0.0.1:8000/api/add-doctors', this.newDoctor)
                .then(response => {
                    this.doctors.push(response.data);
                    this.newDoctor = {
                        name: '',
                        specialization: '',
                        phone: '',
                        email: ''
                    };
                })
                .catch(error => {
                    console.error('Error adding doctor:', error);
                });
        },
        editDoctor(doctor) {
            this.currentDoctor = { ...doctor };
            this.editMode = true;
        },
        updateDoctor() {
            axios.put(`http://127.0.0.1:8000/api/update-doctor/${this.currentDoctor.id}`, this.currentDoctor)
                .then(response => {
                    const index = this.doctors.findIndex(d => d.id === this.currentDoctor.id);
                    this.doctors.splice(index, 1, response.data);
                    this.currentDoctor = null;
                    this.editMode = false;
                })
                .catch(error => {
                    console.error('Error updating doctor:', error);
                });
        },
        cancelEdit() {
            this.currentDoctor = null;
            this.editMode = false;
        },
        deleteDoctor(id) {
            axios.delete(`http://127.0.0.1:8000/api/delete-doctor/${id}`)
                .then(() => {
                    this.doctors = this.doctors.filter(doctor => doctor.id !== id);
                })
                .catch(error => {
                    console.error('Error deleting doctor:', error);
                });
        }
    }
};
</script>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
}

input::placeholder {
    color: #a0aec0;
}

button:hover {
    cursor: pointer;
}
</style>
