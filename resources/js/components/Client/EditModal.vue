<template>
    <!-- Main modal -->
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900" v-text="title">
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="edit-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form class="space-y-6" @submit.prevent="onSubmit">
                        <!-- Dados pessoais -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input v-model="form.name" type="text" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="John Doe" required />
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input v-model="form.email" type="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="john@example.com" required />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
                                <input v-model="form.phone" type="text" id="phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="1234567890" />
                            </div>
                            <div>
                                <label for="age" class="block mb-2 text-sm font-medium text-gray-900">Age</label>
                                <input v-model="form.age" type="number" id="age"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="30" />
                            </div>
                        </div>

                        <!-- Endereço -->
                        <h4 class="text-md font-semibold text-gray-700 mt-4">Address</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Street</label>
                                <input v-model="form.address.street" type="text" id="street"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="1234" />
                            </div>
                            <div>
                                <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Number</label>
                                <input v-model="form.address.number" type="text" id="number"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Optional" />
                            </div>
                            <div>
                                <label for="city" class="block mb-2 text-sm font-medium text-gray-900">City</label>
                                <input v-model="form.address.city" type="text" id="city"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="City" />
                            </div>
                            <div>
                                <label for="state" class="block mb-2 text-sm font-medium text-gray-900">State</label>
                                <input v-model="form.address.state" type="text" id="state"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="California" />
                            </div>
                            <div class="col-span-2">
                                <label for="neighborhood"
                                    class="block mb-2 text-sm font-medium text-gray-900">Neighborhood</label>
                                <input v-model="form.address.neighborhood" type="text" id="neighborhood"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Downtown" />
                            </div>
                        </div>

                        <!-- Foto -->
                        <h4 class="text-md font-semibold text-gray-700 mt-4">Picture</h4>
                        <div>
                            <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Upload
                                Picture</label>
                            <input type="file" id="picture" name="picture"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                @change="onFileChange" />
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button data-modal-hide="edit-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
                        v-text="leftButtonText" @click="$emit('cancelEvent')"> </button> &nbsp;
                    <button data-modal-hide="edit-modal" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        v-text="rightButtonText" @click="onSubmit"> </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EditModal',
    data() {
        return {
            form: {
                name: '',
                email: '',
                phone: '',
                age: null,
                address: {
                    street: '',
                    number: '',
                    city: '',
                    state: '',
                    neighborhood: ''
                },
                picture: null
            }
        }
    },
    props: {
        title: {
            type: String,
            default: 'Modal'
        },
        leftButtonText: {
            type: String,
            default: 'Cancelar'
        },
        rightButtonText: {
            type: String,
            default: 'Salvar'
        },
        selectedClient: {
            type:Object,
            default: {}
        }
    },
    methods: {
        onSubmit() {
            const payload = {};

            // função recursiva para comparar campos de objeto (ex: address)
            const buildDiff = (formObj, originalObj, target) => {
                for (const key in formObj) {
                    const newValue = formObj[key];
                    const oldValue = originalObj ? originalObj[key] : null;

                    if (newValue === '' || newValue === null) {
                        continue; // ignora vazios
                    }

                    if (typeof newValue === 'object' && newValue !== null && !Array.isArray(newValue)) {
                        const nested = {};
                        buildDiff(newValue, oldValue, nested);
                        if (Object.keys(nested).length > 0) {
                            target[key] = nested;
                        }
                    } else if (newValue !== oldValue) {
                        target[key] = newValue;
                    }
                }
            };

            buildDiff(this.form, this.selectedClient, payload);

            console.log("Payload final:", payload);

            const token = localStorage.getItem('token');

            axios.patch(`/api/v1/client/${this.selectedClient.id}`, payload, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }).then(() => {
                this.$emit('refresh');
                alert('Updated');
            }).catch(error => {
                console.error(error);
            });
        }
    },
    emits: ["cancelEvent", "confirmEvent"]
}
</script>
