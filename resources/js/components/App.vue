<template>
    <div class="container">
        <router-view :key="$route.fullPath"></router-view>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "App",

        computed: {
            ...mapGetters({
                authUser: 'authUser',
            }),
        },

        mounted() {
            this.$store.dispatch('fetchAuthUser');
        }
    }
</script>
