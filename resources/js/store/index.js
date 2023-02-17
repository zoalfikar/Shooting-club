import axios from "axios";
import Vue from "vue";
import vuex from "vuex";
Vue.use(vuex);

const store = new vuex.Store({
    state: {
        // halls
        halls: [],
        currentHall: '',
        currentHallName: '',
        currentHallActive: 1,
        noHalls: false,
        // tables
        currentTable: '',
        currentTableStatus: '',
        boards: [],
        boardsLoading: false,
        noBoards: false,
        aviliabeBoards: [],
        // menu
        menuItems: [],
        // orders
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
        bringAllMenuItems({ commit }) {
            axios.get(`/get-menu-items`)
                .then((response) => {
                    commit("setMenuItems", response.data.sections)
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
            if (!halls.length > 0) {
                state.noHalls = true;
            } else {
                state.noHalls = false;
                state.halls = halls.sort((a, b) => a.hallNumber - b.hallNumber);
            }
        },
        setMenuItems: (state, sections) => {
            if (!sections.length > 0) {
                // state.noHalls = true;
            } else {
                // state.noHalls = false;
                state.menuItems = sections;
                console.log(state.menuItems[0].items);
            }
        },
        setCurrentHallNumber: (state, hallNumber) => {
            var hall;
            state.currentHall = hallNumber;
            hall = state.halls.find((hall) => { return hall.hallNumber == hallNumber });
            state.currentHallName = hall.hallName;
            state.currentHallActive = hall.active;
        },
        setBoardsLoading: (state, loading) => {
            state.boardsLoading = loading;
        },
        setBoards: (state, boards) => {
            if (!boards.length > 0) {
                state.noBoards = true;
            } else {
                state.noBoards = false;
            }
            state.boards = boards.sort((a, b) => a.order - b.order);
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