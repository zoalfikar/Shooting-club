import Vue from "vue";
import vuex from "vuex";
// import axios from "axios";
// import axiosClient from "../axios";
Vue.use(vuex);

const store = new vuex.Store({
    state: {
        currentTable: '',
        currentTableStatus: '',
        boards: [{
                tableNumber: '1',
                state: "active",
                order: 200,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [{
                        orderName: 'كباب',
                        price: 60,
                        quantity: 3,
                    },

                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },

                ]
            },
            {
                tableNumber: '2',
                state: "",
                order: 100,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '3',
                state: "",
                order: 100,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '4',
                state: "",
                order: 100,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '5',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '6',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '7',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '8',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '9',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '10',
                state: "",
                order: 100,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '11',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '12',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '13',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '14',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '15',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '16',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '17',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '18',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '19',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '20',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '21',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            }, {
                tableNumber: '22',
                state: "taken",
                order: 300,
                info: {
                    customName: '',
                    slug: '',
                    moreInfo: '',

                },
                orders: [


                    {
                        orderName: 'بيبسي',
                        price: 10,
                        quantity: 2,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },
                    {
                        orderName: 'فروج',
                        price: 60,
                        quantity: 3,
                    },

                ],

            },
        ],
        aviliabeBoards: []


    },
    getter: {},
    actions: {
        changeCurrentTableNumber({ commit }, tableNumber) {
            commit('setCurrentTableNumber', tableNumber)
        },
        changeCurrentTableStatus({ commit }, status) {
            commit('setCurrentTableStatus', status);
        },
        getAviliableBoards({ commit }) {
            var aviliableBoards = this.state.boards.filter((b) => {
                return b.state == '';
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
            state.boards[data.index].state = data.status;
        },
        setoOrders: (state, data) => {
            state.boards[data.index].orders = data.orders;
        },
    },
    modules: {}
})
export default store;