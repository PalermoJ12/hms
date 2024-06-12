<template>
    <section class="bg-white">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow-xl md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create an account
                    </h1>
                    <form class="space-y-4 md:space-y-6" @submit.prevent="nextStep">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                v-model="name" placeholder="Full Name" required>
                        </div>
                        <div class="gap-4">
                            <div>
                                <label for="dob" class="block mb-2 text-sm font-medium text-gray-900">Date Of
                                    Birth</label>
                                <input type="date" name="dob" id="dob"
                                    class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    v-model="dob" placeholder="Date Of Birth" required>
                            </div>
                            <div class="w-full mt-4">
                                <label for="gender" class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
                                <VaSelect v-model="gender" :options="options.map(item => item.gender)" class="" />
                            </div>
                        </div>
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                            <input type="text" name="address" id="address"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                v-model="address" placeholder="Address" required>
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone Number</label>
                            <input type="number" name="phone" id="phone"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                v-model="phone" placeholder="Phone Number" required>
                        </div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 focus:ring-2 shadow-sm transition duration-150 ease-in-out">
                            Next
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            dob: '',
            gender: '',
            address: '',
            phone: '',
            options: [
                { id: 1, gender: "male" },
                { id: 2, gender: "female" }
            ],
        };
    },
    methods: {
        nextStep() {
            const request = {
                name: this.name,
                dob: this.dob,
                gender: this.gender,
                address: this.address,
                phone: this.phone.toString()
            };

            this.$store.commit('setNewUser', request);
            this.$router.push({
                name: 'EmailPassword',

            });
        }
    }
};
</script>
