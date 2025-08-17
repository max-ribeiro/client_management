<template>
    <div>
        <section class="flex items-center justify-center h-screen bg-gray-100">
            <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8">
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h1>
                
                <form action="#" method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block text-gray-700">E-mail</label>
                    <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="password" class="block text-gray-700">Senha</label>
                    <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="flex justify-center">
                    <button type="submit"
                    class="w-40 btn btn-primary" @click="login">
                    Entrar
                    </button>
                </div>
                </form>
            </div>
        </section>
    </div>
</template>
<script>
export default {
    name: 'Login',
    methods: {
        login() {
            this.$router.push('/clients');
        },
    }
};
</script>
<style>
</style>