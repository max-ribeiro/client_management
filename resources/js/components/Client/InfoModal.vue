<script>
import EditIcon from '../../../icons/edit.svg?component';
import DeleteIcon from '../../../icons/delete.svg?component';
import { getInitials } from '../../Utils/StringUtils';


export default {
    name: 'InfoModal',
    components: {
        EditIcon,
        DeleteIcon
    },
    props: {
        selectedClient: {
            type: Object,
            default: () => ({})
        }
    },
    methods: {
        getFullnameInitials(fullname) {
            return getInitials(fullname);
        }
    }
}
</script>
<template>
    <!-- Main modal -->
    <div id="info-modal" tabindex="0" aria-hidden="true"
        class="hidden bg-[rgba(0,0,0,0.35)] overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-20 flex justify-center items-center w-full md:inset-0 max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <div class="flex items-center flex-row gap-4">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 font-semibold">
                            <span v-if="selectedClient?.picture">
                                <img class="w-8 h-8 rounded-full object-cover" :src="selectedClient?.picture?.content" />
                            </span>
                            <span v-else>
                                {{ getFullnameInitials(selectedClient.name) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ selectedClient?.name }}
                        </h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <a data-modal-target="edit-modal" data-modal-toggle="edit-modal" title="editar cliente">
                            <edit-icon class="cursor-pointer w-[20px] h-[20px]" :fill="'#505050'"/>
                        </a>    
                        <a data-modal-target="delete-modal" data-modal-toggle="delete-modal" data-modal-show="delete-modal" title="remover cliente"> 
                            <delete-icon class="cursor-pointer w-[20px] h-[20px]" :fill="'#505050'"/>
                        </a>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="info-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-3">
                    <p><strong>Nome:</strong> {{ selectedClient?.name }}</p>
                    <p><strong>Email:</strong> {{ selectedClient?.email }}</p>
                    <p><strong>Telefone:</strong> {{ selectedClient?.phone }}</p>
                    <p><strong>Idade:</strong> {{ selectedClient?.age }}</p>

                    <div>
                        <p><strong>Rua:</strong> {{ selectedClient?.address?.street }}</p>
                        <p><strong>Cidade:</strong> {{ selectedClient?.address?.city }}</p>
                        <p><strong>Estado:</strong> {{ selectedClient?.address?.state }}</p>
                        <p><strong>Bairro:</strong> {{ selectedClient?.address?.neighborhood }}</p>
                        <p><strong>Numero:</strong> {{ selectedClient?.address?.number }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>