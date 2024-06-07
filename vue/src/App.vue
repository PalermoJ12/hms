<template>
  <div>

    <div v-if="isUserLoggedIn" class="bg-slate-700 p-4 text-white   ">
      <div class="flex flex-row justify-between">
        <div class="p-2 text-2xl">
         HMS
        </div>

        <div class="flex flex-row gap-4 mt-1 item mx-4">

          <div @click="$router.push('/')" class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer">
            Dashboard
          </div>
          <div @click="$router.push('/Patients')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer">Patients</div>
          <div @click="$router.push('/Appointments')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer">Appointments</div>
          <div @click="$router.push('/MedicalRecords')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer">My Records</div>
          <div @click="showLogoutModal = true"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer">Logout</div>
        </div>
      </div>
    </div>


    <router-view />


    <div v-if="showLogoutModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg p-8 max-w-sm mx-auto">
        <h2 class="text-xl mb-4">Confirm Logout</h2>
        <p class="mb-6">Are you sure you want to log out?</p>
        <div class="flex justify-end gap-4">

          <button @click="showLogoutModal = false"
            class="bg-gray-300 hover:bg-gray-500 hover:text-white px-4 py-2 rounded-md">Cancel</button>
          <button @click="logout"
            class="bg-slate-600 hover:bg-slate-800 text-white px-4 py-2 rounded-md">Logout</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      showLogoutModal: false,
      isUserLoggedIn: this.$store.state.userLogged,
      roleAdmin: localStorage.getItem("role") == 1 ? true : false,
    };
  },

  mounted() {

    if (!this.isUserLoggedIn) {
      this.$router.push('/');
    }
  },

  methods: {
    logout() {

      this.showLogoutModal = false;


      this.$router.push('/logout');
      setTimeout(() => {
        this.$router.push('/');
      }, 1000)
    }
  }
};
</script>
