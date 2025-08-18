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
                    <td class="px-6 py-3 flex items-center space-x-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 font-semibold">
                            US
                        </div>
                        <span class="text-gray-800">{{ client.name }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-600">{{ client.email }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ client.phone }}</td>
                    <td class="px-6 py-3 text-gray-500">
                        <div class="flex flex-row items-center justify-end gap-2">
                            <pencil-icon class="w-4 h-4 cursor-pointer" data-modal-target="delete-modal" data-modal-toggle="delete-modal" @click="selectedClientID = client.id" :id="client.id"/>
                            <a data-modal-target="delete-modal" data-modal-toggle="delete-modal" data-modal-show="delete-modal" @click="selectedClientID = client.id"> 
                                <trash-icon class="w-4 h-4 cursor-pointer" :id="client.id"/>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <delete-modal :selected-client="selectedClientID" @refresh="$emit('refresh')"></delete-modal>
    </div>
</template>
<script>
import { PencilIcon, TrashIcon } from '@heroicons/vue/16/solid';
import { initFlowbite } from 'flowbite';
import DeleteModal from './DeleteModal.vue';
export default {
    name: 'ClientList',
    data() {
        return {
            selectedClientID: null
        }
    },
    components: {
        PencilIcon,
        TrashIcon,
        DeleteModal
    },
    props: {
        clients: {
            type: Array,
            default: () => []
        }
    },
    mounted() {
        initFlowbite();
    }
};
</script>