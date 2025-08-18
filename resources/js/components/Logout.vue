<template>
    <div>
        <h1>Logout</h1>
    </div>
</template>

<script>
export default {
    name: 'Logout',
    mounted() {
        this.logout();
    },
    methods: {
        async logout() {
            const token = localStorage.getItem('token');
            
            const response = await axios.get('/api/auth/logout', {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            });
            localStorage.removeItem('token');
            this.$router.push('/');
        }
    }
}
</script>
