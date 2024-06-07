<template>
    <div class="flex min-h-screen flex-col justify-center px-4 py-6 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md bg-white rounded-lg shadow-md px-8 py-10 sm:px-10">
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 text-gray-900">Sign in to your account</h2>

            <form class="mt-8 space-y-6" @submit.prevent="loginUser">
                <div>
                    <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" v-model="email"
                            @input="clearErrors" required
                            class="block w-full px-4 py-2 rounded-md border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        <small class="text-danger" style="color: red" v-if="errors">{{ errors[0] }}</small>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-5 text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" v-model="password"
                            autocomplete="current-password" @input="clearErrors" required
                            class="block w-full px-4 py-2 rounded-md border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 focus:ring-2 shadow-sm transition duration-150 ease-in-out">
                        Sign in
                    </button>
                </div>
            </form>


        </div>
    </div>

</template>

<script>
import axiosClient from "../axios-config/axios-client";

export default {
    data() {
        return {
            email: '',
            password: '',
            errors: null
        };
    },
    methods: {
        async loginUser() {
            try {

                const response = await axiosClient.post('/login', {
                    email: this.email,
                    password: this.password
                });

                console.log(response)

            } catch (error) {
                console.log(error)
                this.errors = error.response.data.message;
            }
        },
        clearErrors() {

            this.errors = null;
        }

    }
};
</script>