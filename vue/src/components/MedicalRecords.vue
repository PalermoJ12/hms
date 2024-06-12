<template>
    <div class="flex flex-col">
        <div class="text-2xl p-6 text-black va-title">RECORDS</div>
        <div class="flex justify-start w-full">
            <VaCard class="w-[1150px] mx-20 min-h-[500px] mt-5">
                <VaCardTitle class="flex flex-row w-100 justify-between">
                    <div>Patient Information</div>
                    <div>

                    </div>
                </VaCardTitle>
                <VaCardContent>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <!-- Table header -->
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Gender</th>
                                    <th scope="col" class="px-6 py-3">Date of Birth</th>
                                    <th scope="col" class="px-6 py-3">Phone</th>
                                    <th scope="col" class="px-6 py-3">More</th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody>
                                <tr v-for="(record, index) in paginatedRecords" :key="index"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ record.user.name }}</td>
                                    <td class="px-6 py-4">{{ record.gender }}</td>
                                    <td class="px-6 py-4">{{ record.date_of_birth }}</td>
                                    <td class="px-6 py-4">{{ record.phone }}</td>
                                    <td class="px-6 py-4 space-x-4">
                                        <button @click="handleShowViewModal(record)">
                                            <VaIcon name="read_more" size="large" class="hover:text-blue-700" />
                                        </button>


                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end mt-4 mr-4">
                        <VaPagination v-model="currentPage" :pages="totalPages" />
                    </div>
                </VaCardContent>
            </VaCard>
        </div>


    </div>

    <VaModal ref="modal" v-model="doShowModal">
        <h4 class="va-h5 flex flex-row justify-between">
            Patient Information
        </h4>
        <hr>
        <div class="mt-4">

            <div class="relative overflow-x-aut o">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">Records</th>
                            <th scope="col" class="px-6 py-3">Date Modified</th>
                            <th scope="col" class="px-6 py-3">Doctor </th>
                            <th v-if="userAccess === 'doctor'" scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(medicalRecord, index) in paginatedRecordsView" :key="index"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ medicalRecord.record }}</td>
                            <td class="px-6 py-4">{{
                                medicalRecord.updated_at.split("T")[0].split("-").reverse().join("/") }}</td>
                            <td class="pl-2 py-4">{{ medicalRecord.doctor.user.name }}</td>
                            <td v-if="userAccess === 'doctor'" class="px-6 py-4 space-x-4">
                                <button @click="handleUpdateData(medicalRecord)">
                                    <VaIcon name="edit" size="medium" class="hover:text-green-500" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-start mt-4 ml-4">
                <VaPagination v-model="currentPageView" :pages="totalPagesView" />
            </div>
        </div>
    </VaModal>

    <VaModal ref="modal" v-model="doShowModalUpdate" ok-text="Submit" @ok="handleUpdateSubmit">
        <h4 class="va-h5 flex flex-row justify-between">
            Patient Information Form
        </h4>
        <hr>

        <VaForm ref="myForm" stateful class="mb-2 flex flex-col gap-4 mt-8" preset="danger">

            <VaTextarea v-model="updateData.record" name="Records" label="Records" />

        </VaForm>
    </VaModal>
</template>

<script>
import axiosClient from "../axios-config/axios-client";
import { useToast } from 'vuestic-ui'
const { notify } = useToast();
export default {


    beforeMount() {
        if (this.userAccess === 'admin') {
            this.$store.dispatch("getPatientRecords");
        } else if (this.userAccess === 'doctor') {
            this.$store.dispatch("getDoctorsPatient");
        }


        this.$store.dispatch("getDoctors");
    },
    data() {
        return {
            doShowModalUpdate: false,
            doShowModal: false,
            selectedRecord: [],
            currentPage: 1,
            perPage: 5,
            currentPageView: 1,
            perPageView: 3,
            updateData: {},
            userAccess: this.$store.state.user_access
        };
    },
    computed: {
        records() {
            if (this.userAccess === 'admin') {
                return this.$store.getters.getPatients;
            } else {
                return this.$store.getters.doctorsPatient;
            }

        },
        doctors() {
            console.log(this.$store.state.doctors)
            return this.$store.state.doctors;

        },
        totalPages() {
            return Math.ceil(this.records.length / this.perPage);
        },
        paginatedRecords() {
            const startIndex = (this.currentPage - 1) * this.perPage;
            return this.records.slice(startIndex, startIndex + this.perPage);
        },
        totalPagesView() {
            return Math.ceil(this.selectedRecord.length / this.perPageView);
        },
        paginatedRecordsView() {

            const startIndex = (this.currentPageView - 1) * this.perPageView;
            return this.selectedRecord.slice(startIndex, startIndex + this.perPageView);
        }
    },
    methods: {

        handleUpdateData(data) {
            this.doShowModal = !this.doShowModal;
            this.updateData = data;
            this.doShowModalUpdate = !this.doShowModalUpdate;
        },
        handleShowViewModal(record) {
            this.doShowModal = !this.doShowModal;
            this.selectedRecord = record.medical_records;
        },

        async handleUpdateSubmit() {

            await axiosClient.put(`/medical-records/${this.updateData.id}`, this.updateData)
                .then(() => {

                    this.$store.dispatch("getPatientRecords");
                    notify('Successfully updated');
                })
                .catch((err) => console.log(err));
        }

    }
};
</script>

<style scoped>
/* Add your styles here */
</style>