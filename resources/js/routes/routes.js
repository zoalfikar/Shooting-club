import orders from "../components/appLayout/resturant/boards/orders.vue";
import info from "../components/appLayout/resturant/boards/info.vue";
import reservations from "../components/appLayout/resturant/boards/reservations.vue";
import facility from "../components/appLayout/setting/components/facility.vue";
import logo from "../components/appLayout/setting/components/logo.vue";
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
    },
    {
        path: '/vue/facility',
        component: facility,
        name: 'facility',
    },
    {
        path: '/vue/log',
        component: logo,
        name: 'logo',
    }
]
export default routes