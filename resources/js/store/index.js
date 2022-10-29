import Vue from "vue";
import vuex from "vuex";
// import axios from "axios";
// import axiosClient from "../axios";
Vue.use(vuex);

const store = new vuex.Store({
    state: {
        curerntTable: '',
    },
    getter: {},
    actions: {
        change({ commit }, tableNumber) {
            commit('setnumber', tableNumber)
        }
    },
    mutations: {
        setnumber: (state, tableNumber) => {
            state.curerntTable = tableNumber;
        }
    },
    modules: {}
})
export default store;