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
                    </div>
                </div>
                

                <!-- Table -->
                <div class="overflow-hidden border rounded-lg">
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
                            <!-- Linha 1 -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 flex items-center space-x-3">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 font-semibold">
                                        HG
                                    </div>
                                    <span class="text-gray-800">Henrique Gomes Santana</span>
                                </td>
                                <td class="px-6 py-3 text-gray-600">henrique.gomes@huggy.io</td>
                                <td class="px-6 py-3 text-gray-600">75992503245</td>
                                <td class="px-6 py-3 text-right text-gray-500">—</td>
                            </tr>

                            <!-- Linha 2 -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 flex items-center space-x-3">
                                    <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full" alt="">
                                    <span class="text-gray-800">Rafael Macedo</span>
                                </td>
                                <td class="px-6 py-3 text-gray-600">rafael.macedo@huggy.io</td>
                                <td class="px-6 py-3 text-gray-600">-</td>
                                <td class="px-6 py-3 text-right space-x-2">
                                    <button class="text-gray-500 hover:text-indigo-600">✏️</button>
                                    <button class="text-gray-500 hover:text-red-600">🗑️</button>
                                </td>
                            </tr>

                            <!-- Linha 3 -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 flex items-center space-x-3">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-100 text-purple-600 font-semibold">
                                        PG
                                    </div>
                                    <span class="text-gray-800">Philippe Gomes Santana</span>
                                </td>
                                <td class="px-6 py-3 text-gray-600">-</td>
                                <td class="px-6 py-3 text-gray-600">75992514121</td>
                                <td class="px-6 py-3 text-right text-gray-500">—</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Login',
};
</script>
<style></style>