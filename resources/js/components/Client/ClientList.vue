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
                    <td class="px-6 py-3 text-right text-gray-500">—</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: 'ClientList',
    props: {
        clients: {
            type: Array,
            default: () => []
        }
    },
};
</script>