import orders from "../components/appLayout/resturant/boards/orders.vue";
import info from "../components/appLayout/resturant/boards/info.vue";
import reservations from "../components/appLayout/resturant/boards/reservations.vue";
const routes = [{
        path: '/vue/orders/:tableNumber',
        component: orders,
        name: 'orders',
    },
    {
        path: '/vue/info',
        component: info,
        name: 'info',
    },
    {
        path: '/vue/reservations',
        component: reservations,
        name: 'reservations',
    }
]
export default routes