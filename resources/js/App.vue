<template>
    <router-view v-slot="{ Component, route }">
        <div :key="route.name">
            <Component :is="Component" />
        </div>
    </router-view>
</template>

<script>
import { initFlowbite } from 'flowbite'

export default {
    name: 'App',
    mounted() {
        initFlowbite()
    }
};
</script>