<template>
    <div class="dashboard">
        <div class="header">
            <h1>OVERVIEW</h1>
        </div>

        <VaCard class="main-card">
            <div class="card-grid p-4">
                <!-- Doctors Card -->
                <VaCard v-if="user_access === 'admin'" class="info-card doctors-card">
                    <VaCardContent class="card-content">
                        <div class="text-section">
                            <div class="number">{{ doctors }}</div>
                            <div class="label">Doctors</div>
                        </div>
                        <div class="icon-section bg-red-500">
                            <VaIcon name="supervised_user_circle" size="large" class="icon" />
                        </div>
                    </VaCardContent>
                </VaCard>

                <!-- Patients Card -->
                <VaCard class="info-card patients-card">
                    <VaCardContent class="card-content">
                        <div class="text-section">
                            <div class="number">{{ patients }}</div>
                            <div class="label">Patients</div>
                        </div>
                        <div class="icon-section bg-green-500">
                            <VaIcon name="personal_injury" size="large" class="icon" />
                        </div>
                    </VaCardContent>
                </VaCard>

                <!-- Appointments Card -->
                <VaCard class="info-card appointments-card">
                    <VaCardContent class="card-content">
                        <div class="text-section">
                            <div class="number">{{ appointments }}</div>
                            <div class="label">Appointments</div>
                        </div>
                        <div class="icon-section bg-blue-500">
                            <VaIcon name="calendar_today" size="large" class="icon" />
                        </div>
                    </VaCardContent>
                </VaCard>

                <!-- Accounts Card -->
                <VaCard v-if="user_access === 'admin'" class="info-card accounts-card">
                    <VaCardContent class="card-content">
                        <div class="text-section">
                            <div class="number">{{ accounts }}</div>
                            <div class="label">Accounts</div>
                        </div>
                        <div class="icon-section bg-[#118ab2]">
                            <VaIcon name="account_circle" size="large" class="icon" />
                        </div>
                    </VaCardContent>
                </VaCard>

                <!-- Records Card -->
                <VaCard class="info-card records-card">
                    <VaCardContent class="card-content">
                        <div class="text-section">
                            <div class="number">{{ records }}</div>
                            <div class="label">Records</div>
                        </div>
                        <div class="icon-section bg-[#eddea4]">
                            <VaIcon name="folder" size="large" class="icon" />
                        </div>
                    </VaCardContent>
                </VaCard>
            </div>
        </VaCard>
    </div>
</template>


<script>

import axiosClient from '@/axios-config/axios-client';
export default {

    name: 'DashboardPage',

    data() {
        return {
            doctors: 0,
            patients: 0,
            appointments: 0,
            accounts: 0,
            records: 0,
            user_access: this.$store.state.user_access
        }
    },
    beforeMount() {
        this.getDashboard();
    },
    methods: {
        async getDashboard() {
            if (this.user_access === 'admin') {
                await axiosClient.get('/dashboard/admin').then((res) => {
                    this.doctors = res.data.doctors;
                    this.patients = res.data.patients;
                    this.appointments = res.data.appointments;
                    this.accounts = res.data.users;
                    this.records = res.data.medicalRecords;

                }).catch((err) => {
                    console.log(err)
                })
            } else {
                await axiosClient.get('/dashboard/doctor').then((res) => {
                    this.patients = res.data.patients;
                    this.appointments = res.data.appointments;
                    this.records = res.data.records;
                }
                ).catch((err) => {
                    console.log(err)
                })
            }
        }
    },
}
</script>

<style scoped>
.dashboard {
    display: flex;
    flex-direction: column;
    padding: 2rem;
    font-family: 'Arial, sans-serif';
}

.header h1 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 1rem;
}

.main-card {
    margin: 0 20px;
    max-width: 1200px;
    min-height: 550px;
    padding: 1rem;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.info-card {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    border-radius: 0.5rem;
    transition: transform 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
}

.card-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 1rem;
}

.text-section {
    text-align: left;
}

.number {
    font-size: 3rem;
    font-weight: bold;
    color: #333;
}

.label {
    font-size: 1.25rem;
    font-weight: 600;
    color: #666;
}

.icon-section {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
}

.icon {
    color: black;

}

.details-card {
    height: auto;
}

.details-card .text-section {
    text-align: left;
}

.title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.description {
    color: #666;
    font-size: 1rem;
}
</style>