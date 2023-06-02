import AuthService from '../services/auth.service';

const user = localStorage.getItem('user');
const accesses = localStorage.getItem('accesses') ? JSON.parse(localStorage.getItem('accesses')): [];
const initialState = user
    ? {status: {loggedIn: true}, user, accesses}
    : {status: {loggedIn: false}, user: null};

export const auth = {
    namespaced: true,
    state: initialState,
    actions: {
        login({commit}, user) {
            return AuthService.login(user).then(
                user => {
                    commit('loginSuccess', user);
                    return Promise.resolve(user);
                },
                error => {
                    commit('loginFailure');
                    return Promise.reject(error);
                }
            );
        },
        logout({commit}) {
            AuthService.logout();
            commit('logout');
        },
    },
    mutations: {
        loginSuccess(state, data) {
            state.status.loggedIn = true;
            state.user = data.user;
            state.accesses = data.accesses;
        },
        loginFailure(state) {
            state.status.loggedIn = false;
            state.user = null;
        },
        logout(state) {
            state.status.loggedIn = false;
            state.user = null;
        },
    },
};
