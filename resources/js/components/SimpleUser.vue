<template>
        <div class="row mb-2">
            <div class="col-md-6" v-for="users in authUser.data">
                <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">{{ users.data.name }}</strong>
                        <div class="mb-1 text-muted">{{ users.data.created }}</div>
                        <p class="card-text mb-auto">{{ users.data.email }}</p>
                        <a :href="users.links.self" class="stretched-link">Profile</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "SimpleUser",
        computed: {
            ...mapGetters({
                authUser: 'authUser'
            })
        },
    }
</script>

<style scoped>

</style>
