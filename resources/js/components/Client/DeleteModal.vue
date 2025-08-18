<template>
    <div id="delete-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Force modal background to white -->
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Close button -->
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 
                rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="delete-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

                <!-- Modal content -->
                <div class="p-4 md:p-5 text-left">
                    <h3 class="mb-5 text-lg font-normal text-gray-700">
                        Excluir esse cliente?
                    </h3>

                    <div class="flex justify-end gap-3">
                        
                        <!-- Cancel button -->
                        <button data-modal-hide="delete-modal" type="button"
                            class="px-4 py-2 rounded-lg bg-transparent 
                            text-gray-500 hover:text-gray-700 hover:bg-gray-50 
                            focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2
                            disabled:opacity-50 disabled:pointer-events-none"
                        >
                            Cancelar
                        </button>
                        <!-- Confirm button -->
                        <button data-modal-hide="delete-modal" type="button"
                            class="px-4 py-2 rounded-lg bg-transparent text-red-600 
                                    hover:text-red-800 hover:bg-red-100 
                                    focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2
                                    disabled:opacity-50"
                            @click="deleteClient"
                        >
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import notify from '../../Utils/Notify';

export default {
    name: 'DeleteModal',
    props: {
        selectedClient: null
    },
    methods: {
        deleteClient() {
            const token = localStorage.getItem('token');

            // Aqui você pode fazer um POST com axios ou fetch
            axios.delete(`/api/v1/client/${this.selectedClient}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }).then(response => {
                notify.success('Removido com sucesso');
                this.$emit('refresh');
            }).catch(error => {
                notify.error('Erro ao remover cliente');
                console.error("Erro ao enviar dados:", error);
                if(403 === error.status) {
                    localStorage.removeItem('token');
                    this.$router.push('/');
                }
            });
        },
        emits: [
            'refresh'
        ]
    }
}
</script>