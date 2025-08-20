<script>
import notify from '../../Utils/Notify';
import BaseButton from '../UI/Buttons/BaseButton.vue';

export default {
    components: { BaseButton },
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
    methods: {
        onFileChange(event) {
            this.form.picture = event.target.files[0];
        },
        onCancel() {
            console.log("Cancelado");
        },
        submit() {
            // Monta o JSON para envio
            const payload = { ...this.form };
            const token = localStorage.getItem('token');

            // Aqui você pode fazer um POST com axios ou fetch
            axios.post('/api/v1/clients', payload, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }).then(response => {
                notify.success('Cliente cadastrado com sucesso!');
                this.$emit('refresh');
            }).catch(error => {
                notify.error('Erro ao cadastrar cliente.');
                console.error("Erro ao enviar dados:", error);
                if(403 === error.status) {
                    localStorage.removeItem('token');
                    this.$router.push('/');
                }
            });
        }
    }
}
</script>
<template>
    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Adicionar novo cliente
                    </h3>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
            <form class="space-y-6" @submit.prevent="">
                <!-- Dados pessoais -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                    <input v-model="form.name" type="text" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Nome Completo" required />
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input v-model="form.email" type="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Email" required />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
                        <input v-model="form.phone" type="text" id="phone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Telefone" />
                    </div>
                    <div>
                        <label for="age" class="block mb-2 text-sm font-medium text-gray-900">Age</label>
                        <input v-model="form.age" type="number" id="age"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Idade" />
                    </div>
                </div>

                <!-- Endereço -->
                <h4 class="text-md font-semibold text-gray-700 mt-4">Address</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Street</label>
                        <input v-model="form.address.street" type="text" id="street"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Rua" />
                    </div>
                    <div>
                        <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Number</label>
                        <input v-model="form.address.number" type="text" id="number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Numero" />
                    </div>
                    <div>
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900">City</label>
                        <input v-model="form.address.city" type="text" id="city"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Cidade" />
                    </div>
                    <div>
                        <label for="state" class="block mb-2 text-sm font-medium text-gray-900">State</label>
                        <input v-model="form.address.state" type="text" id="state"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Estado" />
                    </div>
                    <div class="col-span-2">
                        <label for="neighborhood"
                            class="block mb-2 text-sm font-medium text-gray-900">Neighborhood</label>
                        <input v-model="form.address.neighborhood" type="text" id="neighborhood"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Bairro" />
                    </div>
                </div>

                <!-- Foto -->
                <h4 class="text-md font-semibold text-gray-700 mt-4">Picture</h4>
                <div>
                    <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Upload Picture</label>
                    <input type="file" id="picture" name="picture"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        @change="onFileChange" />
                </div>
            </form>
                </div>

                <!-- Modal footer -->
                <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <base-button
                        data-modal-hide="default-modal" 
                        type="button"
                        variant="secondary"
                        @click="$emit('cancelEvent')"
                    >
                        Cancelar
                    </base-button>
                    &nbsp;
                    <base-button
                        data-modal-hide="default-modal"
                        type="button"
                        @click="submit"
                    >
                        Salvar
                    </base-button>
                </div>
            </div>
        </div>
    </div>
</template>