import Vue from "vue";
import VueRouter from "vue-router";
import UserList from "./components/SimpleUser";
import Show from "./views/user/Show";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/', name: 'home', component: UserList,
        },
        {
            path: '/user/:userId', name: 'user.show', component: Show,
        }
    ]
});
