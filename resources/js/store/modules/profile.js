const state = {
     user: [],
};

const getters = {
    user: state => {return state.user;},
    friendButtonText: (state, getters, rootState) => {
        return 'Accept';
    },
    friendship: state => {
        return state.user.data.friendship;
    },
};

const actions = {
    fetchUser({commit, getters}, userId) {
        axios.get('/api/v1/user/' + userId)
            .then(res => {
                commit('setUser', res.data);
            })
            .catch(error => {
                console.log('Unable to fetch user');
            });
    },
    sendFriendRequest({commit, getters}, friendId) {
        if (getters.friendButtonText !== 'Add Friend') {
            return;
        }

        axios.post('/api/v1/friend-request', { 'friend_id': friendId })
            .then(res => {
                commit('setUserFriendship', res.data);
            })
            .catch(error => {
            });
    },
    acceptFriendRequest({commit, state}, userId) {
        axios.post('/api/v1/friend-response', { 'user_id': userId, 'status': 1 })
            .then(res => {
                commit('setUserFriendship', res.data);
            })
            .catch(error => {
            });
    },
    ignoreFriendRequest({commit, state}, userId) {
        axios.delete('/api/v1/friend-response/delete', { data: { 'user_id': userId }})
            .then(res => {
                commit('setUserFriendship', null);
            })
            .catch(error => {
            });
    },
};

const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setUserFriendship(state, friendship) {
        state.user.data.friendship = friendship;
    },
};

export default {
    state, getters, actions, mutations,
}
