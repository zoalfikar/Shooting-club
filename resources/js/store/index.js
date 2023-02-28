import axios from "axios";
import Vue from "vue";
import vuex from "vuex";
Vue.use(vuex);

const store = new vuex.Store({
    state: {
        // halls //
        halls: [],
        currentHall: '',
        currentHallName: '',
        currentHallActive: 1,
        noHalls: false,
        // tables //
        currentTable: '',
        currentTableIndex: -1,
        currentTableStatus: '',
        boards: [],
        boardsLoading: false,
        noBoards: false,
        aviliabeBoards: [],
        // menu //
        menuItems: [],
        // orders //
        // currentOrders: [],
        // customer info //

        //sale point
        currentSalePointOrders: [],
    },
    getters: {
        table: (state) => (tableNumber) => {
            var board = state.boards.find(board => board.tableNumber === tableNumber);
            return board;
        },
        menuSectionItems: (state) => (sectionId) => {
            var section = state.menuItems.find(section => section.id === sectionId);
            return section.items;
        },
        orders: (state) => (tableNumber) => {
            var board = state.boards.find(board => board.tableNumber === tableNumber);
            return board.orders;
        },
        // currentOrder(state) {
        //     var board = state.boards.find(board => board.tableNumber === state.currentTable);
        //     return board.orders;
        // },
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
                    commit("setAviliableTables", response.data.tables)
                })
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
            axios.post(`set-table-status/${this.state.currentHall}/${payload.tableNumber}`, { "status": payload.status })
            commit('setBoardState', data)
            this.dispatch("getAviliableBoards");
        },
        saveOrders({ commit }, payload) {
            var index = this.state.boards.findIndex((b) => {
                return b.tableNumber == payload.tableNumber;
            })
            axios.post(`/set-table-orders/${this.state.currentHall}/${this.state.currentTable}`, { "orders": payload.orders, "updateMode": payload.updateMode })
                .then((res) => {
                    var data = { "index": index, "orders": res.data.orders }
                    commit('setoOrders', data)
                })
        },
        setTableInfo({ commit }, data) {
            var hall = this.state.currentHall;
            var table = this.state.currentTable;
            var index = -1;
            var indexes = [];
            axios.post(`/set-table-info/${hall}/${table}`, data)
                .then((response) => {
                    if (data.allTables) {
                        this.dispatch("findBoardsIndexes", data.allTables).then(function(result) {
                            indexes = result;
                            commit('setTablesInfoState', { "indexes": indexes, "info": data.info });
                        });
                    } else {
                        this.dispatch("findBoardIndex", table).then(function(result) {
                            index = result;
                            commit('setTableInfoState', { "index": index, "info": data.info });
                        });
                    }
                })
        },
        //
        getTableByNumber({ commit }, tableNumber) {
            // console.log(tableNumber);
            this.dispatch('findBoardIndex', tableNumber).then((index) => {
                // console.log(index);
                // console.log(this.state.boards[index]);
                return Promise.resolve(this.state.boards[index]);
            })
        },
        bringAllSalePointOrders({ commit }) {
            axios.get('/sale-point-orders').then((res) => {
                commit('setCurrentSalePointOrders', res.orders)
            })
        },
        // helpers 
        findBoardIndex({ commit }, tableNumber) {
            var index = this.state.boards.findIndex((board) => { return board.tableNumber === tableNumber });
            return index;
        },
        findBoardsIndexes({ commit }, tables) {
            var indexes = []
            this.state.boards.map((board, i) => { tables.includes(board.tableNumber) ? indexes.push(i) : false });
            return indexes;
        },
        changeCurrentTableNumber({ commit }, tableNumber) {
            var index = store.dispatch("findBoardIndex", tableNumber).then((index) => {
                commit('setCurrentTableIndex', index)
                commit('setCurrentTableNumber', tableNumber)
            })
        },
        changeCurrentTableStatus({ commit }, status) {
            commit('setCurrentTableStatus', status);
        },
        changeCurrentTableData({ commit }, tableNumber) {
            this.dispatch("findBoardIndex", tableNumber).then((index) => {
                commit("setCurrentTableData", index);
            })
        },
        bringAllSalePointOrders({ commit }, req) {
            axios.get('/sale-point-orders', req).then((res) => {
                commit('setSalePointOrder', res.orders)
            })
        },
        saveSalePointOrder({ commit }, req) {
            axios.post('/set-sale-point-order', req).then((res) => {
                commit('setSalePointOrder', res.order)
            })
        },
        //test// saveSalePointOrder
        // switchArrayPistion({ commit }, data) {
        //     var temp = this.state.boards[data.index1];
        //     this.state.boards[data.index1] = this.state.boards[data.index2];
        //     this.state.boards[data.index2] = temp;
        //     // this.state.boards = [this.state.boards[data.index2], this.state.boards[data.index1]]
        //     console.log(data.index1, this.state.boards[data.index1]);
        //     console.log(data.index2, this.state.boards[data.index2]);
        // },
        // addElement({ commit }, data) {
        //     var temp = this.state.boards[data.index1];
        //     var newTable = {
        //         status: 'taken',
        //         tableNumber: 10000,
        //         hallNumber: 1,
        //         active: 1,
        //         customerInfo: {
        //             customerId: 787878,
        //             customerName: 'zoalfikar alassad',
        //             extraInfo: 'ok'
        //         },
        //         order: 1000,
        //         orders: [],
        //     }
        //     this.state.boards.push(newTable)
        //     console.log(data.x, this.state.boards[data.x]);
        // },
        //
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
            boards.forEach(board => {
                board.extra = {}
                board.extra.filterShow = true;
            });
            state.boards = boards.sort((a, b) => a.order - b.order);
        },
        setCurrentTableNumber: (state, tableNumber) => {
            state.currentTable = tableNumber;
        },
        setCurrentTableStatus: (state, status) => {
            state.currentTableStatus = status;
        },
        setCurrentTableIndex: (state, index) => {
            state.currentTableIndex = index;
        },
        setAviliableBoards: (state, aviliableBoards) => {

            state.aviliabeBoards = aviliableBoards;
        },
        setAviliableTables: (state, tables) => {
            var aviliableBoards = tables.filter((e, i) => {
                return e.status == '';
            })
            state.aviliabeBoards = aviliableBoards;
        },
        setBoardState: (state, data) => {
            state.boards[data.index].status = data.status;
        },
        setoOrders: (state, data) => {
            state.boards[data.index].orders = data.orders;
            console.log(state.boards[data.index].orders);
        },
        setTableInfoState: (state, data) => {

            state.boards[data.index].customerInfo = data.info;

        },
        setTablesInfoState: (state, data) => {
            data.indexes.forEach((ind, i) => {
                console.log(ind);
                state.boards[ind].customerInfo = data.info;
            });
            // console.log(state.boards);

        },
        setCurrentTableData: (state, index) => {
            state.currentTable = state.boards[index].tableNumber
            state.currentOrders = state.boards[index].orders
            state.currentTable = state.boards[index].tableNumber
            state.currentTableStatus = state.boards[index].status
        },
        setCurrentSalePointOrders: (state, orders) => {
            state.currentSalePointOrders = orders;
        },
        setSalePointOrder: (state, orders) => {
            state.currentSalePointOrders = orders;
        },
        setSalePointOrder: (state, order) => {

            // state.currentSalePointOrders = state.currentSalePointOrders.filter((o) => {
            //     return o['id'] !== order['id']
            // });
            state.currentSalePointOrders.push(order);
            state.currentSalePointOrders.sort((a, b) => {
                return b["created_at"] - a["created_at"]
            })
        }
    },
    modules: {}
})
export default store;