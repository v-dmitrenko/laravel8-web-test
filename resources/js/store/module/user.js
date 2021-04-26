import Vue from "vue";
import axios from "axios";
import UserService from '../../services/user-service';

const API_URL = 'http://localhost/api/page/book/';

const initialState = {
    users: [],
};

const state = { ...initialState };

const getters = {
    users(state) {
        return state.users;
    }
};

const actions = {
    async getListUsers (context, pageNumber = 1) {
        try {
            let response = await UserService.getListUsers(pageNumber);
            if (response.data.status === 'success') {
                context.commit('setUsers', response.data);
            } else {
                context.commit('clearUsers');
            }

            return response;
        } catch (error) {
            context.commit('clearUsers');
            throw Error(error);
        }
    },
};

const mutations = {
    setUsers(state, data) {
        state.users = data.users;
    },
    clearUsers(state) {
        state.users = [];
    },
};

export default {
    state,
    actions,
    mutations,
    getters
};
