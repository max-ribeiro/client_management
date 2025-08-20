<script>
import notify from '../../Utils/Notify';
import BaseButton from '../UI/Buttons/BaseButton.vue';

export default {
    components: { BaseButton },
    data() {
        return {
            errors: {},
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
                picture: {}
            },
            errorClass: 'border-red-600 focus:ring-red-500 focus:border-red-500',
            defaultClass: 'border-gray-300 focus:ring-blue-500 focus:border-blue-500'
        }
    },
    methods: {
        onFileChange(event) {
            const file = event.target.files[0];
            console.dir(event.target.files);
            if (!file) return;

            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                notify.error("Formato de imagem inválido. Use PNG ou JPG.");
                event.target.value = ""; // limpa input
                this.form.picture = null;
                return;
            }

            const reader = new FileReader();

            reader.onload = (e) => {
                // e.target.result contém o arquivo em Base64
                this.form.picture.content = e.target.result;
            };

            reader.readAsDataURL(file);
        },
        onCancel() {
            console.log("Cancelado");
        },
        validateForm() {
            this.errors = {}; 

            if (!this.form.name) this.errors.name = 'Campo obrigatório';
            if (!this.form.email) this.errors.email = 'Campo obrigatório';
            if (!this.form.address.street) this.errors.street = 'Campo obrigatório';
            if (!this.form.address.neighborhood) this.errors.neighborhood = 'Campo obrigatório';
            if (!this.form.address.city) this.errors.city = 'Campo obrigatório';
            if (!this.form.address.state) this.errors.state = 'Campo obrigatório';

            return Object.keys(this.errors).length === 0; // retorna true se não houver erros
        },
        submit() {
            if (!this.validateForm()) return; // não envia se houver erros

            const payload = { ...this.form };

            // Remover máscaras
            if (payload.phone) {
                payload.phone = payload.phone.replace(/\D/g, ''); // mantém só dígitos
            }
            if (payload.age) {
                payload.age = payload.age.replace(/\D/g, '');
            }
            if (payload.address.number) {
                payload.address.number = payload.address.number.replace(/\D/g, '');
            }

            const token = localStorage.getItem('token');

            axios.post('/api/v1/clients', payload, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }).then(response => {
                notify.success('Cliente cadastrado com sucesso!');
                this.clearForm();
                this.$emit('refresh');
            }).catch(error => {
                notify.error('Erro ao cadastrar cliente.');
                console.error("Erro ao enviar dados:", error);
                if (403 === error.status) {
                    localStorage.removeItem('token');
                    this.$router.push('/');
                }
            });
        },
        clearForm() {
            this.form = {
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
            this.form.picture = {};
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
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nome</label>
                            <input v-model="form.name" type="text" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                :class="errors.name ? errorClass : defaultClass"
                                placeholder="Nome Completo" required />
                            <p v-if="errors.name" class="text-red-600 text-sm mt-1">{{ errors.name }}</p>
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input v-model="form.email" type="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                :class="errors.email ? errorClass : defaultClass"
                                placeholder="Email" required />
                            <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Telefone</label>
                                <input v-model="form.phone" type="text" id="phone"
                                    v-mask="['(##) #####-####', '(##) ####-####']"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Telefone" />
                            </div>
                            <div>
                                <label for="age" class="block mb-2 text-sm font-medium text-gray-900">Idade</label>
                                <input v-model="form.age" type="text" id="age"
                                    v-mask="'##'"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Idade" />
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Rua</label>
                                <input v-model="form.address.street" type="text" id="street"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :class="errors.street ? errorClass : defaultClass"
                                    placeholder="Rua" />
                                <p v-if="errors.street" class="text-red-600 text-sm mt-1">{{ errors.street }}</p>
                            </div>
                            <div>
                                <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Numero</label>
                                <input v-model="form.address.number" type="text" id="number"
                                    v-mask="'#####'"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Número" />
                            </div>
                            <div class="col-span-2">
                                <label for="neighborhood"
                                    class="block mb-2 text-sm font-medium text-gray-900">Bairro</label>
                                <input v-model="form.address.neighborhood" type="text" id="neighborhood"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :class="errors.neighborhood ? errorClass : defaultClass"
                                    placeholder="Bairro" />
                                <p v-if="errors.neighborhood" class="text-red-600 text-sm mt-1">{{ errors.neighborhood }}</p>
                            </div>
                            <div>
                                <label for="city" class="block mb-2 text-sm font-medium text-gray-900">Cidade</label>
                                <input v-model="form.address.city" type="text" id="city"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :class="errors.city ? errorClass : defaultClass"
                                    placeholder="Cidade" />
                                <p v-if="errors.city" class="text-red-600 text-sm mt-1">{{ errors.city }}</p>
                            </div>
                            <div>
                                <label for="state" class="block mb-2 text-sm font-medium text-gray-900">Estado</label>
                                <input v-model="form.address.state" type="text" id="state"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :class="errors.state ? errorClass : defaultClass"
                                    placeholder="Estado" />
                                <p v-if="errors.state" class="text-red-600 text-sm mt-1">{{ errors.state }}</p>
                            </div>
                        </div>

                        <!-- Foto -->
                        <h4 class="text-md font-semibold text-gray-700 mt-4">Picture</h4>
                        <div>
                            <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Upload Picture</label>
                            <input type="file" id="picture" name="picture"
                                accept=".png, .jpg, .jpeg"
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
