<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-gray-800">
        <h1 class="text-9xl font-bold text-red-600">403</h1>
        <h2 class="mt-4 text-3xl font-semibold">Acesso Negado</h2>
        <p class="mt-2 text-gray-600">
            Você não tem permissão para acessar esta página.
        </p>

        <button @click="goBack"
            class="mt-6 px-6 py-3 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 transition">
            Logar
        </button>
    </div>
</template>

<script>
export default {
    name: "Forbidden",
    methods: {
        goBack() {
            this.$router.push('/'); // volta para a página anterior
        },
    },
};
</script>
