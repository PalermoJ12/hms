<template>
  <div>

    <div v-if="isUserLoggedIn" class="bg-slate-700 p-4 text-white   ">
      <div class="w-full flex flex-row justify-between">
        <div class="p-2 text-2xl text-poppins"><span>
            <VaIcon name="monitor_heart" size="large" class="mr-2 mb-2" />
          </span>
          <span>HMS</span>
        </div>
        <va-card-title @click="showLogoutModal = true"
          class="hover:bg-slate-100 rounded-lg  hover:text-black cursor-pointer ">Logout</va-card-title>
      </div>
      <div class="flex flex-row">
        <div
          class="flex flex-col gap-4 mt-[84px] fixed max-w-[250px] bg-slate-500 min-h-full top-0 left-0 right-0 bottom-0 shadow-lg  ">

          <div @click="$router.push('/Dashboard')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8 mt-10">
            <span>
              <VaIcon name="dashboard" size="large" class="mr-2" />
            </span>
            <span tle class="ml-2">DASHBOARD</span>
          </div>
          <div @click="$router.push('/Patients')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="format_list_bulleted" size="large" class="mr-2" />
            </span>
            <span tle class="ml-2">PATIENT</span>
          </div>
          <div @click="$router.push('/doctors')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="format_list_bulleted" size="large" class="mr-2" />
            </span>

            <span tle class="ml-2">DOCTOR</span>
          </div>
          <div @click="$router.push('/Appointments')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="calendar_month" size="large" class="mr-2" />
            </span>
            <span tle class="ml-2">APPOINTMENTS</span>
          </div>
          <div @click="$router.push('/MedicalRecords')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="auto_stories" size="large" class="mr-2" />
            </span>
            <span tle class="ml-2">RECORDS</span>
          </div>
          <div @click="$router.push('/ManageUsers')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="group" size="large" class="mr-2" />
            </span>
            <span tle class="ml-2">MANAGE USERS</span>
          </div>

        </div>
        <div class="fixed left-[250px] top-20 w-full  h-full">
          <router-view />
        </div>
      </div>

    </div>





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
