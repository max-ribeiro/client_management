<template>
    <div class="bg-gray-100 min-h-screen p-6" id="clients">
        <form-modal @refresh="fetchClients" />
        <!-- Container alinhado -->
        <div class="max-w-5xl mx-auto">
            <!-- Título -->
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Contatos</h1>
            <!-- Card -->
            <div class="bg-white rounded-xl shadow p-6">
                <!-- Search -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center w-1/3">
                        <input type="text" placeholder="Buscar contato"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>
                    <div class="flex space-x-2">
                        <base-button :icon="true" data-modal-target="default-modal" data-modal-toggle="default-modal">
                            <span class="mr-1">+</span> Adicionar contato
                        </base-button>
                        <ReportIcon @click="goToCharts" class="max-w-8">
                        </ReportIcon>
                    </div>
                </div>
                <client-list v-if="clients.length" :clients="clients" @refresh="fetchClients"/>
            </div>
        </div>
    </div>
</template>
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
            clients: []
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
                const response = await axios.get('/api/v1/client', {
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
<style></style>