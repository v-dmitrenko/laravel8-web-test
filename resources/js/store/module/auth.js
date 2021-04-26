import Vue from "vue";
import axios from "axios";
import AuthService from '../../services/auth-service';

const userData = JSON.parse(localStorage.getItem('user'));
const initialState = userData ? { status: { loggedIn: true }, user: userData } : { status: {}, user: null };

const state = {
    status: initialState.status,
    user: initialState.user
};

const getters = {
    getUser: (state) => state.user,
    getStatus: (state) => state.status,
    getLoggedStatus: (state) => state.status.loggedIn,
    getCurrentRoute: (state) => state.route,
};

const actions = {
    register(context, user) {
        return new Promise((resolve, reject) => {
            AuthService.register(user)
                .then(response => { resolve(response); })
                .catch(error => { reject(error); });
        });
    },

    confirmEmail(context, data) {
        return new Promise((resolve, reject) => {
            AuthService.confirmEmail(data)
                .then(response => {
                    if (response.data.status === 'success') {
                        const token = response.data.token;
                        if (token) {
                            localStorage.setItem('user-token', token);
                            localStorage.setItem('user', JSON.stringify(response.data.user));
                            axios.defaults.headers.common['Authorization'] = token;
                            context.commit('loginSuccess', {user: response.data.user, access_token: token});
                        }
                    }

                    resolve(response);
                })
                .catch(error => { reject(error); });
        });
    },

    login(context, credentials) {
        return new Promise((resolve, reject) => {
            AuthService.login(credentials)
                .then(response => {
                    if (response.data.status === 'success') {
                        const token = response.data.token;
                        if (token) {
                            localStorage.setItem('user-token', token);
                            localStorage.setItem('user', JSON.stringify(response.data.user));
                            axios.defaults.headers.common['Authorization'] = token;
                            context.commit('loginSuccess', {user: response.data.user, access_token: token});
                        }
                    }

                    resolve(response);
                })
                .catch(error => {
                    localStorage.removeItem('user-token');
                    localStorage.removeItem('user');
                    delete axios.defaults.headers.common['Authorization'];
                    context.commit('loginFailure');
                    reject(error);
                });
        });
    },

    logout(context) {
        AuthService.logout()
            .then(response => {
                localStorage.removeItem('user');
                localStorage.removeItem('user-token');
                delete axios.defaults.headers.common['Authorization']
                context.commit('logout');
            })
            .catch(error => {
                localStorage.removeItem('user');
                localStorage.removeItem('user-token');
                delete axios.defaults.headers.common['Authorization']
                context.commit('logout');
            });

    },

    refreshToken(context) {
        return new Promise((resolve, reject) => {
            AuthService.refreshToken()
                .then(response => {
                    if (response.data.status === 'success') {
                        const token = response.data.token;
                        if (token) {
                            localStorage.setItem('user-token', token);
                            localStorage.setItem('user', JSON.stringify(response.data.user));
                            axios.defaults.headers.common['Authorization'] = token;
                            context.commit('loginSuccess', {user: response.data.user, access_token: token});
                        }
                    }

                    resolve(response);
                })
                .catch(error => {
                    localStorage.removeItem('user-token');
                    localStorage.removeItem('user');
                    delete axios.defaults.headers.common['Authorization'];
                    context.commit('logout');
                    reject(error);
                });
        });
    },
};

const mutations = {
    loginSuccess(state, data) {
        state.status = { loggedIn: true };
        state.user = {
            name: data.user.name,
            email: data.user.email,
            token: data.access_token
        };
    },
    setToken(state, data) {
        state.user.token = data;
    },
    loginFailure(state) {
        state.status = {};
        state.user = null;
    },
    logout(state) {
        state.status = {};
        state.user = null;
    },
};

export default {
    state,
    actions,
    mutations,
    getters
};
