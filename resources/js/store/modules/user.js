const state = {
    users: [],
};

const getters = {
    authUser: state => {
        return state.users;
    }
};

const actions = {
    fetchAuthUser({commit, state}) {
        axios.get('/api/v1/user')
            .then(res => {
                commit('setAuthUser', res.data);
            })
            .catch(error => {
                console.log('Unable to fetch auth user');
            });
    }
};

const mutations = {
    setAuthUser(state, user) {
        state.users = user;
    }
};

export default {
    state, getters, actions, mutations,
}
