import { createStore } from "vuex";
import router from "@/router";

const state = {};
const getters = {};
const mutations = {
  redirectTo(state, payload) {
    router.push({ name: payload });
  },
};
const actions = {
  redirectTo({ commit }, payload) {
    commit("redirectTo", payload.val);
  },
};

export default createStore({
  state,
  getters,
  mutations,
  actions,
  modules: {},
});
