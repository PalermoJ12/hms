<template>
    <!-- Main Component -->
    <div class="flex flex-col">
      <div class="text-2xl p-6 text-black va-title">APPOINTMENTS</div>
      <div class="flex justify-start w-full">
        <VaCard class="w-[1150px] mx-20 min-h-[500px] mt-5">
          <VaCardTitle class="flex flex-row w-100 justify-between ">
            <div>Information</div>
            <div>
              <button>
                <VaIcon name="add_circle" size="large" class="hover:text-green-500" @click="handleModalAdd" />
              </button>
            </div>
          </VaCardTitle>
          <VaCardContent>
            <div class="relative overflow-x-auto">
              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="px-6 py-3">Reference No.</th>
                    <th scope="col" class="px-6 py-3">Doctor Name</th>
                    <th scope="col" class="px-6 py-3">Patient Name</th>                 
                    <th scope="col" class="px-6 py-3">Appointment Date</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in items" :key="item.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ item.refNum }}</td>
                    <td class="px-6 py-4">{{ item.doctorName }}</td>
                    <td class="px-6 py-4">{{ item.patientName }}</td>                
                    <td class="px-6 py-4">{{ item.appDate }}</td>
                    <td class="px-6 py-4 space-x-4 ">
                      <button @click="handleAction(item, 'view')">
                        <VaIcon name="visibility" size="medium" class="hover:text-green-500" />
                      </button>
                      <button @click="handleAction(item, 'edit')">
                        <VaIcon name="edit" size="medium" class="hover:text-green-500" />
                      </button>
                      <button @click="handleAction(item, 'delete')">
                        <VaIcon name="delete" size="medium" class="hover:text-green-500" />
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </VaCardContent>
        </VaCard>
      </div>
  
      <!-- Add User Modal -->
      <VaModal v-model="showModal" ok-text="Submit" close-button @ok="handleSubmit">
        <h3 class="va-h6">NEW USER FORM</h3>
        <hr>
        <VaForm ref="myForm" stateful class="mb-2 flex flex-col gap-2 mt-8" preset="danger">
          <VaInput v-model="refNum" name="refNum" label="Reference No." readonly />
          <VaInput v-model="doctorName" name="doctorName" label="Doctor Name" />
          <VaInput v-model="patientName" name="patientName" label="Patient Name" />
          <VaInput v-model="appDate" name="appDate" label="Appointment Date" type="date"/>
        </VaForm>
      </VaModal>
  
      <!-- View User Modal -->
      <VaModal v-model="showViewModal" close-button>
        <h3 class="va-h6">User Details</h3>
        <hr>
        <div>
          <p><strong>Reference No.:</strong> {{ selectedItem.refNum }}</p>
          <p><strong>Doctor Name:</strong> {{ selectedItem.doctorName }}</p>
          <p><strong>Patient Name:</strong> {{ selectedItem.patientName }}</p>
          <p><strong>Appointment Date:</strong> {{ selectedItem.appDate }}</p>
        </div>
      </VaModal>
  
      <!-- Edit User Modal -->
      <VaModal v-model="showEditModal" ok-text="Update" close-button @ok="handleUpdate">
        <h3 class="va-h6">Edit User</h3>
        <hr>
        <VaForm ref="editForm" stateful class="mb-2 flex flex-col gap-2 mt-8" preset="danger">
          <VaInput v-model="editUser.refNum" name="refNum" label="Reference No." />
          <VaInput v-model="editUser.doctorName" name="doctorName" label="Doctor Name" />
          <VaInput v-model="editUser.patientName" name="patientName" label="Patient Name" />
          <VaInput v-model="editUser.appDate" name="appDate" label="Appointment Date" />
        </VaForm>
      </VaModal>
  
      <!-- Delete Confirmation Modal -->
      <VaModal v-model="showDeleteConfirmationModal" ok-text="Delete" cancel-text="Cancel" close-button @ok="confirmDelete">
        <h3 class="va-h6">Confirm Delete</h3>
        <hr>
        <p>Are you sure you want to delete this user?</p>
      </VaModal>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        items: [
          { id: 1, refNum: "12345", doctorName: "Dr.Cruz", patientName: "Jose", appDate: "2024-06-11" },
        ],
        showModal: false,
        showEditModal: false,
        showDeleteConfirmationModal: false,
        showViewModal: false,
        refNum: "",
        doctorName: "",
        patientName: "",
        appDate: "",
        userToDeleteId: null,
        editUser: {
          id: null,
          refNum: "",
          doctorName: "",
          patientName: "",
          appDate: "",
        },
        selectedItem: null
      };
    },
    methods: {
      handleModalAdd() {
        this.showModal = !this.showModal;
        // Generate a random 5-digit number for refNum
        this.refNum = Math.floor(10000 + Math.random() * 90000).toString();
      },
      handleAction(item, action) {
        if (action === 'delete') {
          this.userToDeleteId = item.id;
          this.showDeleteConfirmationModal = true;
        } else if (action === 'edit') {
          this.editUser = { ...item };
          this.showEditModal = true;
        } else if (action === 'view') {
          this.selectedItem = item;
          this.showViewModal = true;
        } else {
          console.log(action, item);
        }
      },
      handleSubmit() {
        const newUser = {
          id: this.items.length + 1,
          refNum: this.refNum,
          doctorName: this.doctorName,
          patientName: this.patientName,
          appDate: this.appDate,
        };
  
        this.items.push(newUser);
        this.showModal = false;
        this.resetForm();
      },
      handleUpdate() {
        // Perform update logic here
        // For demonstration purposes, let's just log the updated user
        console.log("Updated user:", this.editUser);
        this.showEditModal = false;
        this.resetEditForm();
      },
      deleteUser(id) {
        this.items = this.items.filter(item => item.id !== id);
      },
      confirmDelete() {
        this.deleteUser(this.userToDeleteId);
        this.userToDeleteId = null;
        this.showDeleteConfirmationModal = false;
      },
      resetForm() {
        this.refNum = "";
        this.doctorName = "";
        this.patientName = "";
        this.appDate = "";
      },
      resetEditForm() {
        this.editUser = {
          id: null,
          refNum: "",
          doctorName: "",
          patientName: "",
          appDate: "",
        };
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>
  