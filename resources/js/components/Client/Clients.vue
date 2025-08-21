<script>
import ClientList from './ClientList.vue';
import FormModal from './FormModal.vue';
import notify from '../../Utils/Notify';
import ReportIcon from '../../../icons/report.svg?component'
import BaseButton from '../UI/Buttons/BaseButton.vue';

export default {
    name: 'Clients',
    data() {
        return {
            clients: [],
            searchText: ''
        }
    },
    components: {
        ClientList,
        FormModal,
        ReportIcon,
        BaseButton
    },
    methods: {
        goToCharts() {
            this.$router.push('/charts');
        },
        async fetchClients() {
            const token = localStorage.getItem('token');
            try {
                const response = await axios.get('/api/v1/clients', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: 'application/json'
                    },
                });

                this.clients = response.data;
            } catch (error) {
                notify.error('Erro ao trazer dados de clientes.')
                console.error('Error fetching clients:', error);
                    if(403 === error.status) {
                        localStorage.removeItem('token');
                        this.$router.push('/');
                    }
            }
        }
    },
    mounted() {
        // Lógica a ser executada quando o componente é montado
        this.fetchClients();
    }
};
</script>
<template>
    <div class="bg-gray-100 min-h-screen p-6" id="clients">
        <form-modal @refresh="fetchClients" />
        <!-- Container alinhado -->
        <div class="max-w-5xl mx-auto">
            <!-- Título -->
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Contatos</h1>
            <!-- Card -->
            <div class="bg-white rounded-xl shadow">
                <!-- Search -->
                <div class="flex flex-row items-center justify-between p-[16px]">
                    <div class="flex items-center w-1/3">
                        <label for="default-search" class="sr-only">Buscar cliente</label>
                        <div class="relative w-80 h-9">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" placeholder="Buscar cliente" v-model="searchText"
                                class="block w-full h-full ps-10 text-sm text-gray-900 border border-[#E1E1E1] rounded-lg bg-[#F8F8F8] focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>


                    </div>
                    <div class="flex items-center gap-[16px]">
                        <base-button :icon="true" data-modal-target="default-modal" data-modal-toggle="default-modal">
                            <span class="mr-1">+</span> Adicionar contato
                        </base-button>
                        <report-icon @click="goToCharts" class="w-[20px] h-[20px] cursor-pointer" fill="#505050">
                        </report-icon>
                    </div>
                </div>
                <client-list :clients="clients" @refresh="fetchClients" :search-text="searchText"/>
            </div>
        </div>
    </div>
</template>
<style>
</style>