<template>
    <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" @submit.prevent="login">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input v-model="email" type="email" name="email" id="email" placeholder="name@company.com" required
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"/>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Senhas</label>
                            <input v-model="password" type="password" name="password" id="password" placeholder="••••••••" required
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"/>
                        </div>
                        
                        <base-button class="w-full">
                            Logar no sistema
                        </base-button >
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import BaseButton from '../UI/Buttons/BaseButton.vue';
    import notify from '../../Utils/Notify';

    export default {
        name: 'LoginModal',
        components: {
            BaseButton
        },
        data() {
            return {
                email: '',
                password: '',
                error: null,
            };
        },
        methods: {
            login() {
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password,
                }).then(response => {
                    if(200 == response.status) {
                        // salva token no localStorage
                        localStorage.setItem('token', response.data.access_token);
                        // redireciona para a rota de clientes
                        this.$router.push('/clients');
                    }
                    notify.error('Erro ao logar');
                }).catch(err => {
                    if (401 === err.status) {
                        notify.error('Credenciais inválidas');
                    } else {
                        notify.error('Erro ao logar');
                    }
                    console.log(err);
                });
            
            },
        }
    }
</script>