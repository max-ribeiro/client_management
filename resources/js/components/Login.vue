<script>
import axios from 'axios';
import BaseButton from './UI/Buttons/BaseButton.vue';
import LoginModal from './Modals/LoginModal.vue';


export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            error: null,
        };
    },
    components: {
        BaseButton,
        LoginModal
    },
};
</script>
<template>
    <div id="login">
        <section class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
            <div class="w-full">
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h1>
            </div>
            <base-button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                Fazer login
            </base-button>
        </section>
        <login-modal>
        </login-modal>
    </div>
</template>