<template>
    <div class="bg-gray-100 min-h-screen p-6" id="clients">
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
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <span class="mr-1">+</span> Adicionar contato
                        </button>
                        <ChartBarIcon @click="goToCharts">
                        </ChartBarIcon>
                    </div>
                </div>
                <client-list v-if="clients.length" :clients="clients"/>
            </div>
        </div>
    </div>
</template>
<script>
import { ChartBarIcon } from '@heroicons/vue/16/solid';
import ClientList from './ClientList.vue';
export default {
    name: 'Clients',
    data() {
        return {
            clients: []
        }
    },
    components: {
        ChartBarIcon,
        ClientList
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
                console.error('Error fetching clients:', error);
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