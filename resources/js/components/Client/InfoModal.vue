<template>
    <!-- Main modal -->
    <div id="info-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Client Information
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="info-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-3">
                    <p><strong>Name:</strong> {{ selectedClient?.name }}</p>
                    <p><strong>Email:</strong> {{ selectedClient?.email }}</p>
                    <p><strong>Phone:</strong> {{ selectedClient?.phone }}</p>
                    <p><strong>Age:</strong> {{ selectedClient?.age }}</p>

                    <div>
                        <h4 class="font-semibold text-gray-700 mt-4 mb-2">Address</h4>
                        <p><strong>Street:</strong> {{ selectedClient?.address?.street }}</p>
                        <p><strong>City:</strong> {{ selectedClient?.address?.city }}</p>
                        <p><strong>State:</strong> {{ selectedClient?.address?.state }}</p>
                        <p><strong>Neighborhood:</strong> {{ selectedClient?.address?.neighborhood }}</p>
                        <p><strong>Number:</strong> {{ selectedClient?.address?.number }}</p>
                    </div>

                    <div v-if="selectedClient?.picture?.content">
                        <h4 class="font-semibold text-gray-700 mt-4 mb-2">Picture</h4>
                        <img :src="'data:image/png;base64,' + selectedClient.picture.content"
                            alt="Client Picture" class="w-24 h-24 rounded-lg object-cover border" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'InfoModal',
    props: {
        selectedClient: {
            type: Object,
            default: () => ({})
        }
    }
}
</script>
