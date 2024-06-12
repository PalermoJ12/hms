<template>
  <div>

    <div v-if="isUserLoggedIn" class="bg-[#231942] p-4 text-white   ">
      <div class="w-full flex flex-row justify-between">
        <div class="p-2 text-2xl text-poppins"><span>
            <VaIcon name="monitor_heart" size="large" class="mr-2 mb-2" />
          </span>
          <span>HMS</span>
        </div>
        <div class="mt-2">
          <VaButtonDropdown :label="user" class="mr-2 mb-2">
            <div v-if="userAccess === 'patient' || userAccess === 'doctor'" class="p-2  cursor-pointer"
              @click="openProfile">My Profile</div>
            <div v-if="userAccess === 'patient'" class=" p-2 cursor-pointer" @click="() => {
              doShowModal = true;
            }">My
              Records </div>
            <div class="p-2  cursor-pointer" @click="logout">Logout</div>
          </VaButtonDropdown>
        </div>
      </div>
      <div v-if="userAccess === 'admin' || userAccess === 'doctor'" class="flex flex-row">
        <div
          class="flex flex-col gap-4 mt-[84px] fixed max-w-[250px] bg-[#3d405b] min-h-full top-0 left-0 right-0 bottom-0 shadow-lg  ">

          <div v-if="userAccess === 'admin' || userAccess === 'doctor'" @click="$router.push('/Dashboard')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8 mt-10">
            <span>
              <VaIcon name="dashboard" size="large" class="mr-2" />
            </span>
            <span class="ml-2">DASHBOARD</span>
          </div>
          <div v-if="userAccess === 'admin' || userAccess === 'doctor'" @click="$router.push('/Patients')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="format_list_bulleted" size="large" class="mr-2" />
            </span>
            <span class="ml-2">PATIENTS</span>
          </div>
          <div v-if="userAccess === 'admin'" @click="$router.push('/Doctors')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="group" size="large" class="mr-2" />
            </span>
            <span tle class="ml-2">DOCTORS</span>
          </div>
          <div @click="$router.push('/Appointments')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="calendar_month" size="large" class="mr-2" />
            </span>
            <span tle class="ml-2">APPOINTMENTS</span>
          </div>
          <div v-if="userAccess === 'admin' || userAccess === 'doctor'" @click="$router.push('/MedicalRecords')"
            class="hover:bg-slate-100 rounded-md p-2 hover:text-black cursor-pointer mx-8"> <span>
              <VaIcon name="auto_stories" size="large" class="mr-2" />
            </span>
            <span tle class="ml-2">RECORDS</span>
          </div>


        </div>
        <div class="fixed left-[250px] top-20 w-full  h-full">
          <router-view />
        </div>
      </div>

    </div>

    <div v-if="!isUserLoggedIn">
      <router-view />
    </div>
    <div v-if="userAccess === 'patient'" class="fixed left-[150px] top-20 w-full  h-full">
      <router-view />
    </div>
    <VaModal v-if="userAccess === 'patient'" ref="modal" v-model="viewPatientModal" ok-text="Ok">


      <div class="mt-4">

        <VaCardContent>
          <div class="flex flex-col w-100 mb-4">
            <div class="flex flex-row justify-between">
              <h1 class="va-h6 text-2xl"> {{ patientProfile.user.name }}</h1>
              <h1 class="va-h6 font-light mt-2"> Patient</h1>
            </div>
            <hr>
            <div>
              <div><span class="font-light">Gender</span> : {{ patientProfile.gender.toUpperCase() }}</div>
              <div><span class="font-light">Birthdate</span> : {{ patientProfile.date_of_birth }}</div>
              <div><span class="font-light">Contact</span> : {{ patientProfile.phone }}</div>
              <div><span class="font-light">Address</span> : {{ patientProfile.address }}</div>
              <div><span class="font-light">Email</span> : {{ patientProfile.user.email }}</div>
            </div>
          </div>
        </VaCardContent>

      </div>

    </VaModal>

    <VaModal v-if="userAccess === 'doctor'" v-model="viewDoctorModal" ok-text="Ok">


      <div class="mt-4">

        <VaCardContent>
          <div class="flex flex-col w-100">
            <div class="flex flex-row justify-between">
              <h1 class="va-h6 text-2xl"> {{ doctorProfile.user.name }}</h1>
              <div class="text-sm  mt-4 mr-2"> {{ doctorProfile.specialization }}</div>
            </div>
            <hr>
            <div>
              <div> {{ doctorProfile.profile }}</div>


            </div>
          </div>
        </VaCardContent>

      </div>

    </VaModal>



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
              </tr>
            </thead>

            <tbody>
              <tr v-for="(medicalRecord, index) in paginatedRecordsView" :key="index"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">{{ medicalRecord.record }}</td>
                <td class="px-6 py-4">{{
                  medicalRecord.updated_at.split("T")[0].split("-").reverse().join("/") }}</td>
                <td class="pl-2 py-4">{{ medicalRecord.doctor.user.name }}</td>

              </tr>
            </tbody>
          </table>
        </div>
        <div class="flex justify-start mt-4 ml-4">
          <VaPagination v-model="currentPageView" :pages="totalPagesView" />
        </div>
      </div>
    </VaModal>

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
      doShowModal: false,
      showLogoutModal: false,
      viewPatientModal: false,
      viewDoctorModal: false,
      isUserLoggedIn: this.$store.state.userLogged,
      userAccess: this.$store.state.user_access,
      user: this.$store.state.user,
      userId: this.$store.state.id,
      currentPageView: 1,
      perPageView: 3,
    };
  },

  beforeMount() {

    if (!this.isUserLoggedIn) {
      this.$router.push('/');
    }

    if (this.userAccess === 'patient') {
      this.$store.dispatch('getPatientProfile');
      this.$store.dispatch('getPatientOwnRecords');
    }

    if (this.userAccess === 'doctor') {
      this.$store.dispatch('getDoctorOwnProfile');
    }
  },

  methods: {
    openProfile() {

      this.userAccess === 'patient' ? this.viewPatientModal = true : this.viewDoctorModal = true;
    },

    logout() {

      this.showLogoutModal = false;

      this.$router.push('/logout');
      setTimeout(() => {
        this.$router.push('/');
      }, 1000)
    }
  },
  computed: {
    patientProfile() {
      return this.$store.getters.patientProfile;
    },

    totalPagesView() {
      return Math.ceil(this.patientOwnRecords.length / this.perPageView);
    },
    paginatedRecordsView() {

      const startIndex = (this.currentPageView - 1) * this.perPageView;

      return this.patientOwnRecords.slice(startIndex, startIndex + this.perPageView);
    },

    patientOwnRecords() {
      console.log("===>", this.$store.getters.patientOwnRecords);
      return this.$store.getters.patientRecords;
    },
    doctorProfile() {
      return this.$store.getters.doctorProfile;
    }
  }
};
</script>
