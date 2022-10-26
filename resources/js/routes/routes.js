import orders from "../components/appLayout/resturant/boards/orders.vue";
import info from "../components/appLayout/resturant/boards/info.vue";
const routes = [{
        path: '/vue/orders',
        component: orders,
        name: 'orders',
    },
    {
        path: '/vue/info',
        component: info,
        name: 'info',
    }
]
export default routes
