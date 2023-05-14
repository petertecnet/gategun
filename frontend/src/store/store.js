import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    // Aqui você pode definir os dados iniciais do estado da sua aplicação
    user: null,
    token: null,
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setToken(state, token) {
      state.token = token;
    },
  },
  actions: {
    loginUser({ commit }, { user, token }) {
      // Aqui você pode executar a lógica para fazer login do usuário e armazenar as informações no estado
      commit('setUser', user);
      commit('setToken', token);
    },
    logoutUser({ commit }) {
      // Aqui você pode executar a lógica para fazer logout do usuário e limpar as informações do estado
      commit('setUser', null);
      commit('setToken', null);
    },
  },
});

export default store;
