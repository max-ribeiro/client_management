<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-gray-800">
        <h1 class="text-9xl font-bold text-indigo-600">404</h1>
        <h2 class="mt-4 text-3xl font-semibold">Página não encontrada</h2>
        <p class="mt-2 text-gray-600">A página que você tentou acessar não existe.</p>

        <button
            @click="goBack"
            class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition"
        >
            Voltar
        </button>
    </div>
</template>

<script>
export default {
    name: "NotFound",
    methods: {
        goBack() {
            this.$router.back(); // volta para a página anterior
        },
    },
};
</script>
