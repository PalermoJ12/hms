<template>
    <!-- Main Component -->
    <div class="flex flex-col">
      <div class="text-2xl p-6 text-black va-title">PATIENT</div>
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
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Username</th>
                    <th scope="col" class="px-6 py-3">userType</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Phone</th>
                    <th scope="col" class="px-6 py-3">Medical Record</th>
                    <th scope="col" class="px-6 py-3">Booked Appointment Date</th>
                    <th scope="col" class="px-6 py-3">Appointment Status</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in items" :key="item.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ item.name }}</td>
                    <td class="px-6 py-4">{{ item.username }}</td>
                    <td class="px-6 py-4">{{ item.userType }}</td>
                    <td class="px-6 py-4">{{ item.email }}</td>
                    <td class="px-6 py-4">{{ item.phone }}</td>
                    <td class="px-6 py-4">
                        <button @click="handleAction(item, 'view')">
                            <VaIcon name="visibility" size="medium" class="hover:text-green-500" />
                        </button>
                    </td>
                    <td class="px-6 py-4">{{ item.appDate }}</td>
                    <td class="px-6 py-4">{{ item.appStatus }}</td>
                    <td class="px-6 py-4 space-x-4 ">                    
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
          <VaInput v-model="name" name="name" label="Name" />
          <VaInput v-model="username" name="username" label="Username" />
          <VaInput v-model="userType" name="userType" label="UserType" />
          <VaInput v-model="email" name="email" label="Email" />
          <VaInput v-model="phone" name="phone" label="Phone" />
          <VaInput v-model="MedicalInfo" name="MedicalInfo" label="MedicalInfo" />
          <VaInput v-model="MedicalInfo" name="appDate" label="appDate" type="date" />
          <VaInput v-model="MedicalInfo" name="MedicalInfo" label="MedicalInfo" />
        </VaForm>
      </VaModal>
  
      <!-- View User Modal -->
      <VaModal v-model="showViewModal" close-button>
        <h3 class="va-h6">User Details</h3>
        <hr>
        <div>
          <p><strong>Name:</strong> {{ selectedItem.name }}</p>
          <p><strong>Medical Record:</strong> {{ selectedItem.MedicalInfo }}</p>        
        </div>
      </VaModal>
  
      <!-- Edit User Modal -->
      <VaModal v-model="showEditModal" ok-text="Update" close-button @ok="handleUpdate">
        <h3 class="va-h6">Edit User</h3>
        <hr>
        <VaForm ref="editForm" stateful class="mb-2 flex flex-col gap-2 mt-8" preset="danger">
          <VaInput v-model="editUser.name" name="name" label="Name" />
          <VaInput v-model="editUser.username" name="username" label="Username" />
          <VaInput v-model="editUser.userType" name="userType" label="UserType" />
          <VaInput v-model="editUser.email" name="email" label="Email" />
          <VaInput v-model="editUser.phone" name="phone" label="Phone" />
          <VaInput v-model="editUser.MedicalInfo" name="MedicalInfo" label="MedicalInfo" />
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
        { id: 1, name: "Juan Dela Cruz", username: "JDL", userType: "Patient", email: "jdl@gmail.com", phone: "09123456789", MedicalInfo: "lagnat", appDate : "2024-06-11", appStatus: "pending"},
        ],
        showModal: false,
        showEditModal: false,
        showDeleteConfirmationModal: false,
        showViewModal: false,
        name: "",
        username: "",
        userType: "",
        email: "",
        phone: "",
        MedicalInfo: "",
        appDate: "",
        appStatus: "",
        options: ["admin", "user"],
        userToDeleteId: null,
        editUser: {
          id: null,
          name: "",
          username: "",
          userType: "",
          email: "",
          phone: "",
          MedicalInfo: "",
        },
        selectedItem: null
      };
    },
    methods: {
      handleModalAdd() {
        this.showModal = !this.showModal;
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
        if (this.password !== this.password_confirmation) {
          alert("Passwords do not match!");
          return;
        }
  
        const newUser = {
          id: this.items.length + 1,
          name: this.name,
          username: this.username,
          userType: this.userType,
          email: this.email,
          phone: this.phone,
          MedicalInfo: this.MedicalInfo,
          appDate: this.appDate,
          appStatus: this.appStatus,
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
        this.name = "";
        this.username = "";
        this.userType = "";
        this.email = "";
        this.phone = "";
        this.MedicalInfo = "";
        this.appDate = "";
        this.appStatus = "";
      },
      resetEditForm() {
        this.editUser = {
          id: null,
          name: "",
          username: "",
          userType: "",
          email: "",
          phone: "",
          MedicalInfo: "",
          appDate: "",
          appStatus: "",
        };
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>
  