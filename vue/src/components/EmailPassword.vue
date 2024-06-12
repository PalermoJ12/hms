<template>
    <section class="bg-white">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow-xl md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create an account
                    </h1>
                    <form class="space-y-4 md:space-y-6" @submit.prevent="registerUser">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                            <input type="email" name="email" id="email"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                v-model="email" placeholder="name@gmail.com" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                v-model="password" required>
                        </div>
                        <div>
                            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                                password</label>
                            <input type="password" name="confirm-password" id="confirm-password" placeholder="••••••••"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                v-model="confirm" required>
                        </div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 focus:ring-2 shadow-sm transition duration-150 ease-in-out">
                            Create an account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axiosClient from "../axios-config/axios-client";
export default {
    data() {
        return {
            email: '',
            password: '',
            confirm: '',
            errors: {},
        };
    },
    methods: {
        async registerUser() {
            const request = {
                ...this.newUser,
                email: this.email,
                password: this.password,
                password_confirmation: this.confirm,
                role: "patient  "
            };
            console.log(request)
            try {
                const response = await axiosClient.post('/register', request);
                if (response.status === 201) {
                    console.log(response);
                    this.email = '';
                    this.password = '';
                    this.confirm = '';
                    alert('Registration successful');
                    setTimeout(() => {
                        this.$router.push('/');
                    }, 500);
                }
            } catch (error) {
                this.errors = error.response.data.errors;
                console.log(error.response.data.errors);
            }
        }
    },
    computed: {
        newUser() {
            return this.$store.getters.newUser;
        }
    }
};
</script>
