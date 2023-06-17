import axios from "axios";
import Vue from "vue";
import vuex from "vuex";
Vue.use(vuex);

const store = new vuex.Store({
    state: {
        role: sessionStorage.getItem("userRole"),
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
        salePoints: [],
        salePointMenuItems: [],
        currentSalePoint: null,
        currentSalePointName: '',
        currentSalePointActive: true,
        currentSalePointOrders: [],
        currentSalePointSetting: {},
        ordersLoading: false,
        salePointNotFound: false,
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
        salePointMenuSectionItems: (state) => (sectionId) => {
            var section = state.salePointMenuItems.find(section => section.id === sectionId);
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
        getRole({ commit }) {
            axios.get(`/role`)
                .then((response) => {
                    commit("setRole", response.data.role)
                })
        },
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
        // sale points
        bringAllSalePointMenuItems({ commit }) {
            axios.get('get-sale-point-menu').then((res) => {
                commit("setSalePointMenuItems", res.data.items)
            })
        },
        bringAllSalePointOrders({ commit }, req) {
            axios.get('/sale-point-orders', req).then((res) => {
                commit('setCurrentSalePointOrders', res.data.orders)
            })
        },
        saveSalePointOrder({ commit }, req) {
            axios.post('/set-sale-point-order/' + this.state.currentSalePoint, req).then((res) => {
                commit('setSalePointOrder', res.data.order)
            })
        },
        deleteSalePointOrder({ commit }, req) {
            axios.post('/delete-sale-point-order', req).then((res) => {
                commit('deleteSalePointOrder', res.data.id)
            })
        },
        bringAllSalePoints({ commit }, req) {
            if (this.state.role == 'acountant')
                axios.get('/all-sale-points', req).then((res) => {
                    if (res.data.salePoints) {
                        commit('setSalePoints', res.data.salePoints)
                    }
                })
            else
                this.dispatch('getSalePoint', null)
        },
        getSalePoint({ commit }, id) {
            commit('setSalePointOrdersLoading', true)
            axios.get(`/get-sale-point${id ?'/'+ id : '-'}`).then((res) => {
                console.log(res.data.salePoint);
                if (res.data.salePoint !== null) {
                    commit('setSalePoint', res.data)
                    commit('setSalePointOrdersLoading', false)
                } else {
                    if (this.state.role !== "acountant")
                        commit('setSalePointNotFound')
                    commit('setSalePointOrdersLoading', false)
                }
            })
        },
        setSalePointSettings({ commit }, req) {
            axios.post('/set-sale-point-settings/' + this.state.currentSalePoint, req)
        },
        deletePreviousSPOreders({ commit }) {
            axios.post('/delete-paid-sp-orders/' + this.state.currentSalePoint).then((res) => {
                commit('setSalePointOrders', res.data)
            })
        }
    },
    mutations: {
        setRole: (state, role) => {
            sessionStorage.setItem("userRole", role);
            state.role = sessionStorage.getItem("userRole");
        },
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
        addMenuSection: (state, section) => {
            state.salePointMenuItems.push(section)
        },
        updateMenuSection: (state, section) => {
            var index = state.salePointMenuItems.findIndex(s => s.id == section.id)
            state.salePointMenuItems[index].name = section.name
            state.salePointMenuItems[index].active = section.active
            state.salePointMenuItems[index].options = section.options
            state.salePointMenuItems[index].description = section.description
            state.salePointMenuItems[index].created_at = section.created_at
            state.salePointMenuItems[index].updated_at = section.updated_at
        },
        deleteMenuSection: (state, section) => {
            state.salePointMenuItems = state.salePointMenuItems.filter(s => s.id !== section.id)
        },
        setMenuSectionItems: (state, data) => {
            state.salePointMenuItems = state.salePointMenuItems.map((s) => {
                if (s.id == data.section.id)
                    s.items = data.items
                return s
            })
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
        setBoardStateRealTimeTest: (state, data) => {
            // console.log(data);
            state.boards.find(b => {
                return b.tableNumber == data.tableNumber
            }).status = data.status;
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
        setSalePointMenuItems: (state, items) => {
            state.salePointMenuItems = items;
        },
        setSalePoints: (state, salePoints) => {
            state.salePoints = salePoints;
        },
        setSalePoint: (state, data) => {
            state.currentSalePoint = data.salePoint.id
            state.currentSalePointName = data.salePoint.name
            state.currentSalePointActive = data.salePoint.active
            state.currentSalePointOrders = data.orders;
            state.currentSalePointSetting = data.setting;

        },
        setSalePointOrders: (state, data) => {
            state.currentSalePointOrders = data.orders;
        },
        setSalePointOrder: (state, order) => {
            var oldOrder = state.currentSalePointOrders.find(o => o.id == order.id);
            if (oldOrder) {
                oldOrder.orders = order.orders
                oldOrder.customerName = order.customerName
                oldOrder.status = order.status
                oldOrder.totale = order.totale
                oldOrder.created_at = order.created_at
                oldOrder.updated_at = order.updated_at
            } else state.currentSalePointOrders.push(order);
        },
        deleteSalePointOrder: (state, id) => {
            state.currentSalePointOrders = state.currentSalePointOrders.filter(o => o.id !== id);
        },
        setSalePointOrdersLoading: (state, loading) => {
            state.ordersLoading = loading;
        },
        setSalePointNotFound: (state) => {
            state.salePointNotFound = true;
        },
    },
    modules: {}
})
export default store;