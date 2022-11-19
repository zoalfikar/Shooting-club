import axios from "axios";
import Vue from "vue";
import vuex from "vuex";
Vue.use(vuex);

const store = new vuex.Store({
    state: {
        halls: [],
        currentHall: '',
        currentHallName: '',
        currentTable: '',
        currentTableStatus: '',
        boards: [],
        boardsLoading: false,
        aviliabeBoards: [],


    },
    getters: {
        currentOrder(state) {
            var board = state.boards.find(board => board.tableNumber === state.currentTable);
            return board.orders;
        }
    },
    actions: {
        pringAllHalls({ commit }) {
            axios.get(`/halls/`)
                .then((response) => {
                    commit("setHalls", response.data.halls)
                })
        },
        changeCurrentHallNumber({ commit }, hallNumber) {
            commit('setCurrentHallNumber', hallNumber)
        },
        pringAllBoardsInThisHall({ commit }, hallNumber) {
            // commit("setBoards", [])
            commit('setBoardsLoading', true)
            axios.get(`/boards/${hallNumber}`)
                .then((response) => {
                    commit("setBoardsLoading", false);
                    commit("setBoards", response.data.tables)
                })
        },
        changeCurrentTableNumber({ commit }, tableNumber) {
            commit('setCurrentTableNumber', tableNumber)
        },
        changeCurrentTableStatus({ commit }, status) {
            commit('setCurrentTableStatus', status);
        },
        getAviliableBoards({ commit }) {
            var aviliableBoards = this.state.boards.filter((b) => {
                return b.status == '';
            })
            commit('setAviliableBoards', aviliableBoards)
        },
        changeBoardState({ commit }, payload) {
            var index = this.state.boards.findIndex((b) => {
                return b.tableNumber == payload.tableNumber;
            })
            var data = { "index": index, "status": payload.status }
            commit('setBoardState', data)
            this.dispatch("getAviliableBoards");
        },
        saveOrders({ commit }, payload) {
            var index = this.state.boards.findIndex((b) => {
                return b.tableNumber == payload.tableNumber;
            })
            var data = { "index": index, "orders": payload.orders }
            commit('setoOrders', data)
        }
    },
    mutations: {
        setHalls: (state, halls) => {
            state.halls = halls.sort((a, b) => a.hallNumber - b.hallNumber);
        },
        setCurrentHallNumber: (state, hallNumber) => {
            state.currentHall = hallNumber;
            state.currentHallName = state.halls.find((hall) => { return hall.hallNumber == hallNumber }).name;
        },
        setBoardsLoading: (state, loading) => {
            state.boardsLoading = loading;
        },
        setBoards: (state, boards) => {
            state.boards = boards.sort((a, b) => a.order - b.order);
            // console.log(state.boards);

        },
        setCurrentTableNumber: (state, tableNumber) => {
            state.currentTable = tableNumber;
        },
        setCurrentTableStatus: (state, status) => {
            state.currentTableStatus = status;
        },
        setAviliableBoards: (state, aviliableBoards) => {

            state.aviliabeBoards = aviliableBoards;
        },
        setBoardState: (state, data) => {
            state.boards[data.index].status = data.status;
        },
        setoOrders: (state, data) => {
            state.boards[data.index].orders = data.orders;
        },
    },
    modules: {}
})
export default store;