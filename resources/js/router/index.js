import Vue from "vue";
import Router from "vue-router";
import Home from '../views/pages/home/Home.vue';
import Register from '../views/pages/auth/Register.vue';
import AccountConfirmation from '../views/pages/auth/AccountConfirmation.vue';
import Login from '../views/pages/auth/Login.vue';
import Users from '../views/pages/Users.vue';
import PageNotFound from '../views/pages/404/PageNotFound';
Vue.use(Router);

let router = new Router({
    mode: 'history',
    routes: [
        {
            name: 'home',
            path: '/',
            component: Home
        },
        {
            name: "register",
            path: "/register",
            component: Register
        },
        {
            name: "register/confirm-email",
            path: "/register/confirm-email/:email/token/:token",
            component: AccountConfirmation
        },
        {
            name: "login",
            path: "/login",
            component: Login
        },
        {
            name: "users",
            path: "/users",
            component: Users,
            meta: { authOnly: true }
        },

        {
            path: '/404',
            name: '404',
            component: PageNotFound,
        },
        {
            path: '*',
            redirect: '/404'
        }
    ]
});

router.beforeEach((to, from, next) => {
    const authRequired = to.matched.some(record => record.meta.authOnly);
    const loggedIn = localStorage.getItem('user');

    // trying to access a restricted page + not logged in
    // redirect to login page
    if (authRequired && !loggedIn) {
      next('/login');
    } else {
      next();
    }
  });

export default router;
