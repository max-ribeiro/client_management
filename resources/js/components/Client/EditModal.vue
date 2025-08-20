<script>
import notify from '../../Utils/Notify';
import BaseButton from '../UI/Buttons/BaseButton.vue';

export default {
    name: 'EditModal',
    components: {
        BaseButton
    },
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
            default: 'Editar cliente'
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
        onFileChange(event) {
            const file = event.target.files[0];
            if (!file) return;

            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                notify.error("Formato de imagem inválido. Use PNG ou JPG.");
                e.target.value = ""; // limpa input
                this.form.picture = null;
                return;
            }

            const reader = new FileReader();

            reader.onload = (e) => {
                // e.target.result contém o arquivo em Base64
                this.form.picture = {};
                this.form.picture.content = e.target.result;
            };

            reader.readAsDataURL(file);
        },
        onSubmit() {
            const payload = {};

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

            if (payload.phone) {
                payload.phone = payload.phone.replace(/\D/g, ''); // mantém só dígitos
            }
            if (payload?.address?.number) {
                payload.address.number = payload.address.number.replace(/\D/g, '');
            }

            const token = localStorage.getItem('token');

            axios.patch(`/api/v1/clients/${this.selectedClient.id}`, payload, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }).then(() => {
                notify.success('Dados atualizados com sucesso!');
                this.clearForm();
                this.$emit('refresh');
            }).catch(error => {
                notify.error('Desculpe, houve algum erro ao atualizar os dados.')
                console.error(error);
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
        }
    },
    emits: ["cancelEvent", "confirmEvent"]
}
</script>

<template>
    <!-- Main modal -->
    <div id="edit-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900" v-text="title">
                    </h3>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form class="space-y-6" @submit.prevent="onSubmit">
                        <!-- Dados pessoais -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nome</label>
                            <input v-model="form.name" type="text" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                :placeholder="selectedClient.name || 'Nome'" />
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input v-model="form.email" type="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                :placeholder="selectedClient.email || 'Email'" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Telefone</label>
                                <input v-model="form.phone" type="text" id="phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    v-mask="['(##) #####-####', '(##) ####-####']"
                                    :placeholder="selectedClient.phone || 'Email'"  />
                            </div>
                            <div>
                                <label for="age" class="block mb-2 text-sm font-medium text-gray-900">Idade</label>
                                <input v-model="form.age" type="number" id="age"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :placeholder="selectedClient.age || 'Email'" />
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Rua</label>
                                <input v-model="form.address.street" type="text" id="street"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :placeholder="selectedClient.address?.street || 'Rua'" />
                            </div>
                            <div>
                                <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Numero</label>
                                <input v-model="form.address.number" type="text" id="number"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :placeholder="selectedClient.address?.number || 'Numero'" />
                            </div>
                            <div>
                                <label for="city" class="block mb-2 text-sm font-medium text-gray-900">Cidade</label>
                                <input v-model="form.address.city" type="text" id="city"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :placeholder="selectedClient.address?.city || 'Cidade'" />
                            </div>
                            <div>
                                <label for="state" class="block mb-2 text-sm font-medium text-gray-900">Estado</label>
                                <input v-model="form.address.state" type="text" id="state"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :placeholder="selectedClient.address?.state || 'Estado'" />
                            </div>
                            <div class="col-span-2">
                                <label for="neighborhood"
                                    class="block mb-2 text-sm font-medium text-gray-900">Bairro</label>
                                <input v-model="form.address.neighborhood" type="text" id="neighborhood"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    :placeholder="selectedClient.address?.neighborhood || 'Bairro'" />
                            </div>
                        </div>

                        <!-- Foto -->
                        <h4 class="text-md font-semibold text-gray-700 mt-4">Foto</h4>
                        <div>
                            <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Upload
                                de foto</label>
                            <input type="file" id="picture" name="picture"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                @change="onFileChange" />
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <base-button data-modal-hide="edit-modal" type="button" variant="secondary"
                        @click="$emit('cancelEvent')">
                        {{ leftButtonText }}
                    </base-button>
                        &nbsp;
                    <base-button data-modal-hide="edit-modal" type="button"
                        @click="onSubmit">
                        {{ rightButtonText }}
                    </base-button>
                </div>
            </div>
        </div>
    </div>
</template>