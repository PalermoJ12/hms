<template>
    <div class="flex flex-col">
        <div class="text-2xl p-6 text-black va-title">Manage User</div>
        <div class="flex justify-start w-full">
            <VaCard class="w-[1150px] mx-20 min-h-[500px] mt-5">
                <VaCardTitle class="flex flex-row w-100 justify-between ">
                    <div>Information</div>
                    <div>
                        <button>
                            <VaIcon name="add_circle" size="large" class="hover:text-green-500"
                                @click="handleModalAdd" />
                        </button>
                    </div>

                </VaCardTitle>
                <VaCardContent>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Username
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Phone
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in items" :key="item.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ item.name }}</td>
                                    <td class="px-6 py-4">{{ item.username }}</td>
                                    <td class="px-6 py-4">{{ item.email }}</td>
                                    <td class="px-6 py-4">{{ item.phone }}</td>
                                    <td class="px-6 py-4 space-x-4 ">
                                        <button @click="handleAction(item)">
                                            <VaIcon name="visibility" size="medium" class="hover:text-green-500" />
                                        </button>
                                        <button @click="handleAction(item)">
                                            <VaIcon name="edit" size="medium" class="hover:text-green-500" />
                                        </button>
                                        <button @click="handleAction    (item)">
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
    </div>
    <VaModal v-model="showModal" ok-text="Submit" close-button class="">
        <h3 class="va-h6">
            NEW USER FORM
        </h3>
        <hr>
        <VaForm ref="myForm" stateful class="mb-2 flex flex-col gap-2 mt-8" preset="danger">
            <VaInput v-model="email" name="email" label="email" />
            <VaInput v-model="password" name="password" label="Password" />
            <VaInput v-model="password_confirmation" name="Confirm Password" label="Confirm Password" />
            <VaSelect v-model="value" class="mt-3" label="Role" :options="options" clearable />
        </VaForm>

    </VaModal>
</template>

<script>
export default {

    data() {

        return {
            items: [
                { id: 1, name: "Leanne Graham", username: "Bret", email: "Sincere@april.biz", phone: "1-770-736-8031 x56442", website: "hildegard.org", },
                { id: 2, name: "Ervin Howell", username: "Antonette", email: "Shanna@melissa.tv", phone: "010-692-6593 x09125", website: "anastasia.net" },
                { id: 3, name: "Clementine Bauch", username: "Samantha", email: "Nathan@yesenia.net", phone: "1-463-123-4447", website: "ramiro.info" },
                { id: 4, name: "Patricia Lebsack", username: "Karianne", email: "Julianne.OConner@kory.org", phone: "493-170-9623 x156", website: "kale.biz" },
                { id: 5, name: "Chelsey Dietrich", username: "Kamren", email: "Lucio_Hettinger@annie.ca", phone: "(254)954-1289", website: "demarco.info" },
            ],
            showModal: false,
            email: "",
            password: "",
            password_confirmation: "",
            value: "",
            options: ["admin", "user"],
        };
    },
    methods: {
        handleModalAdd() {
            console.log(this.showModal);
            this.showModal = !this.showModal;
        },
        handleAction(item) {
            console.log(item);
        }
    }
};
</script>

<style scoped>
/* Add your styles here */
</style>
