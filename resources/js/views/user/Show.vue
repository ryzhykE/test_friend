<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                <div v-if="user" class="card-body">
                    <strong class="d-inline-block mb-2 text-primary">{{ user.data.name }}</strong>
                    <p class="card-text mb-auto">{{ user.data.email }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button v-if="friendButtonText && friendButtonText !== 'Accept'"
                                    class="py-1 px-3 bg-gray-400 rounded"
                                    @click="$store.dispatch('sendFriendRequest', $route.params.userId)">
                                {{ friendButtonText }}
                            </button>
                        </div>
                        <small class="text-muted">{{ user.data.created }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "Show",

        created: function() {
             this.$store.dispatch('fetchUser', this.$route.params.userId);
        },


        computed: {
            ...mapGetters({
                user: 'user',
                friendButtonText: 'friendButtonText',
            }),
        }
    }
</script>

<style scoped>

</style>
