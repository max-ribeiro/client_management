<template>
    <modal title="Formulário" leftButtonText="Cancelar" rightButtonText="Enviar" @cancelEvent="onCancel"
        @confirmEvent="onSubmit">
        <template v-slot:body>
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
                    <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Upload Picture</label>
                    <input type="file" id="picture" name="picture"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        @change="onFileChange" />
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
import Modal from '@/components/General/Modal.vue';

export default {
    components: { Modal },
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
        onSubmit() {
            // Monta o JSON para envio
            const payload = { ...this.form };
            const token = localStorage.getItem('token');

            // Aqui você pode fazer um POST com axios ou fetch
            axios.post('/api/v1/client', payload, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }).then(response => {
                alert('Salvo com sucesso');
                this.$emit('refresh');
            }).catch(error => {
                alert('Erro ao salvar cliente');
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
