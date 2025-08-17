<template>
    <div>
        <section class="flex items-center justify-center h-screen bg-gray-100">
            <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8">
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h1>

                <form @submit.prevent="login" class="space-y-4">
                    <div>
                        <label for="email" class="block text-gray-700">E-mail</label>
                        <input type="email" id="email" v-model="email" required
                            class="w-full px-4 py-2 mt-1 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700">Senha</label>
                        <input type="password" id="password" v-model="password" required
                            class="w-full px-4 py-2 mt-1 border text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                            class="w-40 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                            Entrar
                        </button>
                    </div>

                    <p v-if="error" class="text-red-600 mt-4 text-center">{{ error }}</p>
                </form>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            error: null,
        };
    },
    methods: {
        async login() {
            this.error = null;
            try {
                const response = await axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password,
                });
                // salva token no localStorage
                localStorage.setItem('token', response.data.access_token);
                // redireciona para a rota de clientes
                this.$router.push('/clients');
            } catch (err) {
                this.error = err.response?.data?.message || 'Erro ao logar';
            }
        },
    },
};
</script>
