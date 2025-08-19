<template>
    <div class="overflow-hidden border rounded-lg" id="client-list">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nome ↓</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Telefone</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-600">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr v-for="client in clients" :key="client.id" class="hover:bg-gray-50">
                    <td class="px-6 py-3 flex items-center space-x-3" data-modal-target="info-modal" data-modal-toggle="info-modal" @click="selectedClientID = client.id">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 font-semibold">
                            US
                        </div>
                        <span class="text-gray-800">{{ client.name }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-600" data-modal-target="info-modal" data-modal-toggle="info-modal" @click="selectedClientID = client.id">{{ client.email }}</td>
                    <td class="px-6 py-3 text-gray-600" data-modal-target="info-modal" data-modal-toggle="info-modal" @click="selectedClientID = client.id">{{ client.phone }}</td>
                    <td class="px-6 py-3 text-gray-500">
                        <div class="flex flex-row items-center justify-end gap-2">
                            <a data-modal-target="edit-modal" data-modal-toggle="edit-modal">
                                <edit-icon class="w-4 h-4 cursor-pointer" @click="selectedClientID = client.id" :id="client.id"/>
                            </a>    
                            <a data-modal-target="delete-modal" data-modal-toggle="delete-modal" data-modal-show="delete-modal" @click="selectedClientID = client.id"> 
                                <delete-icon class="w-4 h-4 cursor-pointer" :id="client.id"/>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <delete-modal :selected-client="selectedClientID" @refresh="$emit('refresh')"></delete-modal>
        <edit-modal :selected-client="selectedClient" @refresh="$emit('refresh')"></edit-modal>
        <info-modal :selected-client="selectedClient"></info-modal>
    </div>
</template>
<script>
import EditIcon from '../../../icons/edit.svg?component'
import DeleteIcon from '../../../icons/delete.svg?component'
import { initFlowbite } from 'flowbite';
import DeleteModal from './DeleteModal.vue';
import EditModal from './EditModal.vue';
import InfoModal from './InfoModal.vue';

export default {
    name: 'ClientList',
    data() {
        return {
            selectedClientID: null
        }
    },
    components: {
        EditIcon,
        DeleteIcon,
        DeleteModal,
        EditModal,
        InfoModal
    },
    props: {
        clients: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        selectedClient() {
            if(!this.selectedClientID) {
                return {};
            }
            const client = this.clients.filter(client => {
                return client.id == this.selectedClientID;
            }, this.selectedClientID);

            return client.shift();
        }
    },
    mounted() {
        initFlowbite();
    }
};
</script>