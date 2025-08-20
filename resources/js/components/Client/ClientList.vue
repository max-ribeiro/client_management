<template>
    <div class="overflow-auto" id="client-list">
        <table class="min-w-full divide-gray-200 text-[14px]">
            <thead class="divide-y border-b-[1px] border-[#E1E1E1]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nome ↓</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Telefone</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-600"></th>
                </tr>
            </thead>
            <tbody class="">
                <tr v-for="client in clients" :key="client.id" class=" hover:bg-gray-50 p-[8px]">
                    <td class="px-6 py-3 flex items-center space-x-3" data-modal-target="info-modal" data-modal-toggle="info-modal" @click="selectedClientID = client.id">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 font-semibold">
                            US
                        </div>
                        <span class="text-gray-800">{{ client.name }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-600" data-modal-target="info-modal" data-modal-toggle="info-modal" @click="selectedClientID = client.id">{{ client.email }}</td>
                    <td class="px-6 py-3 items-center text-gray-600" data-modal-target="info-modal" data-modal-toggle="info-modal" @click="selectedClientID = client.id">
                        {{ client.phone }}
                    </td>
                    <td class="px-6 py-3 text-gray-500">
                        <div class="flex flex-row items-center justify-end gap-2">
                            <a title="efetuar chamada">
                                <phone-icon v-if="client.phone" class="cursor-pointer inline w-[20px] h-[20px]" :fill="'#505050'" @click="makeCall(client.id)"/>
                            </a>
                            <a data-modal-target="edit-modal" data-modal-toggle="edit-modal" title="editar cliente">
                                <edit-icon class="cursor-pointer w-[20px] h-[20px]" @click="selectedClientID = client.id" :id="client.id" :fill="'#505050'"/>
                            </a>    
                            <a data-modal-target="delete-modal" data-modal-toggle="delete-modal" data-modal-show="delete-modal" @click="selectedClientID = client.id" title="remover cliente"> 
                                <delete-icon class="cursor-pointer w-[20px] h-[20px]" :id="client.id" :fill="'#505050'"/>
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
import EditIcon from '../../../icons/edit.svg?component';
import DeleteIcon from '../../../icons/delete.svg?component';
import PhoneIcon from '../../../icons/phone.svg?component';
import { initFlowbite } from 'flowbite';
import DeleteModal from './DeleteModal.vue';
import EditModal from './EditModal.vue';
import InfoModal from './InfoModal.vue';
import notify from '../../Utils/Notify';

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
        PhoneIcon,
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
    methods: {
        async makeCall(id) {
            this.error = null;
            const token = localStorage.getItem('token');
            const response = await axios.post(`/api/voip/call/${id}`,{}, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }).then(response => {
                notify.success('Chamada será efetuada em alguns minutos!');
            }).catch(error => {
                notify.error('Erro ao efetuar chamada.');
                console.error(error);
                if(403 === error.status) {
                    localStorage.removeItem('token');
                    this.$router.push('/');
                }
            });
        }
    },
    mounted() {
        initFlowbite();
    }
};
</script>