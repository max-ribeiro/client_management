<script>
import EditIcon from '../../../icons/edit.svg?component';
import DeleteIcon from '../../../icons/delete.svg?component';
import PhoneIcon from '../../../icons/phone.svg?component';
import DownArrow from '../../../icons/south.svg?component';
import DeleteModal from './DeleteModal.vue';
import BaseButton from '../UI/Buttons/BaseButton.vue';
import EditModal from './EditModal.vue';
import InfoModal from './InfoModal.vue';
import FormModal from './FormModal.vue';
import notify from '../../Utils/Notify';
import { getInitials } from '../../Utils/StringUtils';

export default {
    name: 'ClientList',
    data() {
        return {
            selectedClientID: null,
            sortKey: 'name',      // coluna ativa
            sortOrder: 'asc',     // asc | desc
        }
    },
    components: {
        EditIcon,
        DeleteIcon,
        PhoneIcon,
        DownArrow,
        BaseButton,
        DeleteModal,
        EditModal,
        InfoModal,
        FormModal
    },
    props: {
        searchText: {
            type: String,
            default: ''
        },
        clients: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        selectedClient() {
            if (!this.selectedClientID) {
                return {};
            }
            return this.clients.find(client => client.id == this.selectedClientID) || {};
        },
        filteredClients() {
            let result = [...this.clients];

            if (this.searchText) {
                const term = this.searchText.toLowerCase();
                result = result.filter(client => {
                    return (
                        (client.name && client.name.toLowerCase().includes(term)) ||
                        (client.email && client.email.toLowerCase().includes(term)) ||
                        (client.phone && client.phone.toLowerCase().includes(term))
                    );
                });
            }

            if (this.sortKey) {
                result.sort((a, b) => {
                    const valA = (a[this.sortKey] || '').toString().toLowerCase();
                    const valB = (b[this.sortKey] || '').toString().toLowerCase();

                    if (valA < valB) return this.sortOrder === 'asc' ? -1 : 1;
                    if (valA > valB) return this.sortOrder === 'asc' ? 1 : -1;
                    return 0;
                });
            }

            return result;
        }
    },
    methods: {
        setSort(key) {
            if (this.sortKey === key) {
                // se clicar de novo na mesma coluna, inverte a ordem
                this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortKey = key;
                this.sortOrder = 'asc';
            }
        },
        async makeCall(id) {
            this.error = null;
            const token = localStorage.getItem('token');
            const response = await axios.post(`/api/voip/call/${id}`, {}, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }).then(response => {
                notify.success('Chamada será efetuada em alguns minutos!');
            }).catch(error => {
                notify.error('Erro ao efetuar chamada.');
                console.error(error);
                if (403 === error.status) {
                    localStorage.removeItem('token');
                    this.$router.push('/');
                }
            });
        },
        getFullnameInitials(fullname) {
            return getInitials(fullname);
        }
    },
    mounted() {
        this.$nextTick(() => {
            initFlowbite()
        })
    },
    updated() {
        initFlowbite();
    }
};
</script>

<template>
    <div class="overflow-auto" id="client-list">
        <table class="min-w-full divide-gray-200 text-[14px] table-auto">
            <thead class="divide-y border-b-[1px] border-[#E1E1E1]">
                <tr>
                    <th @click="setSort('name')"
                        class="px-6 py-3 text-left text-sm font-medium text-gray-600 cursor-pointer">
                        <div class="flex items-center gap-1">
                            Nome
                            <down-arrow v-if="sortKey === 'name'" class="w-[12px]"
                                :class="{ 'rotate-180': sortOrder === 'desc' }" />
                        </div>
                    </th>
                    <th @click="setSort('email')"
                        class="px-6 py-3 text-left text-sm font-medium text-gray-600 cursor-pointer">
                        <div class="flex items-center gap-1">
                            Email
                            <down-arrow v-if="sortKey === 'email'" class="w-[12px]"
                                :class="{ 'rotate-180': sortOrder === 'desc' }" />
                        </div>
                    </th>
                    <th @click="setSort('phone')"
                        class="px-6 py-3 text-left text-sm font-medium text-gray-600 cursor-pointer">
                        <div class="flex items-center gap-1">
                            Telefone
                            <down-arrow v-if="sortKey === 'phone'" class="w-[12px]"
                                :class="{ 'rotate-180': sortOrder === 'desc' }" />
                        </div>
                    </th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-600"></th>
                </tr>
            </thead>

            <tbody v-if="filteredClients.length">
                <tr v-for="client in filteredClients" :key="client.id" class="hover:bg-gray-50">
                    <td class="px-6 py-3 flex items-center space-x-3 cursor-pointer"
                        @click="selectedClientID = client.id">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 font-semibold">
                            <span v-if="client?.picture?.content">
                                <img :src="client?.picture?.content" class="w-8 h-8 rounded-full object-cover" />
                            </span>
                            <span v-else>{{ getFullnameInitials(client.name) }}</span>
                        </div>
                        <span class="text-gray-800">{{ client.name }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-600 cursor-pointer" @click="selectedClientID = client.id">{{
                        client.email }}</td>
                    <td class="px-6 py-3 text-gray-600 cursor-pointer" @click="selectedClientID = client.id">{{
                        client.phone || '-' }}</td>
                    <td class="px-6 py-3 text-gray-500">
                        <div class="flex items-center justify-end gap-2">
                            <phone-icon v-if="client.phone" class="cursor-pointer w-[20px] h-[20px]" :fill="'#505050'"
                                @click="makeCall(client.id)" />
                            <edit-icon class="cursor-pointer w-[20px] h-[20px]" @click="selectedClientID = client.id"
                                :fill="'#505050'" />
                            <delete-icon class="cursor-pointer w-[20px] h-[20px]" @click="selectedClientID = client.id"
                                :fill="'#505050'" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- quando não houver registros -->
        <div v-show="!filteredClients.length" class="h-[75vh] w-full flex flex-col items-center justify-center">
            <div>
                <img src="/public/assets/img/book.png" />
            </div>
            <base-button :icon="true" class="mt-[16px]" data-modal-target="default-modal"
                data-modal-toggle="default-modal">
                <span class="">+</span> Adicionar contato
            </base-button>
            <form-modal @refresh="$emit('refresh')" />
        </div>

        <!-- modais -->
        <span v-if="filteredClients.length">
            <delete-modal :selected-client="selectedClientID" @refresh="$emit('refresh')"></delete-modal>
            <edit-modal :selected-client="selectedClient" @refresh="$emit('refresh')"></edit-modal>
            <info-modal :selected-client="selectedClient"></info-modal>
        </span>
    </div>
</template>
