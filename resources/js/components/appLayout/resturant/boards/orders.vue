<template>
  <div class="modal-grid">
                <div class="options">
                    <v-btn rounded color="primary" dark @click="toggleMenu">أضف طلب</v-btn>
                    <v-btn rounded color="primary" dark  @click="updateOrder">تعديل طلب</v-btn>
                    <v-btn rounded color="primary" dark> إسال الطلب</v-btn>
                </div>
                <div class="display-content">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                            <th scope="col">اسم الطلب</th>
                            <th scope="col">السعر</th>
                            <th scope="col">الكمية</th>
                            <th scope="col">المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in currentTable.orders" :key="order.id">
                                <td>{{order.orderName}} <i @click="deleteOrder(order.id)" class="fa fa-remove" ></i></td>
                                <td>{{order.price}}  ل.س</td>
                                <td><i @click="increseQ(order.id)" class="fa fa-plus" ></i>{{order.quantity}}<i @click="decreseQ(order.id)"  class="fa fa-minus" ></i></td>
                                <td>{{order.quantity * order.price}} ل.س</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <resturant-menu></resturant-menu>
            </div>
</template>

<script>
import router from '../../../../routes';
import store from '../../../../store';

export default {
    data () {
        return {
            currentTable:{},
        }
    },
    methods:{
        increseQ:function (id) {
            this.currentTable.orders.map((element) => {
                if (element.id == id) {
                    element.quantity++;
                }
            })
        },
        decreseQ:function (id) {
            this.currentTable.orders.map((element) => {
                if (element.id == id && element.quantity > 0) {
                    element.quantity--;
                }
            })
        },
        deleteOrder:function (id) {
            var index = this.currentTable.orders.findIndex(function (o)
            {
                return o.id == id;
            });
            this.currentTable.orders.splice(index,1);
        },
        toggleMenu: function () {
            document.querySelector(".menu-wraper").style.display = "block";
        },
        updateOrder: function (e) {
            const save = ()=>{this.saveOrder();}
            if (e.target.innerHTML== "تعديل طلب") {
                e.target.innerHTML= "حفظ"
                $('.fa-remove').css('display', "block");
                $('.fa-plus').css('display', "block");
                $('.fa-minus').css('display', "block");
            } else {
                e.target.innerHTML= "تعديل طلب"
                $('.fa-remove').css('display', "none");
                $('.fa-plus').css('display', "none");
                $('.fa-minus').css('display', "none");
                save();
            }
        },
        saveOrder:function () {
            var itemsToDelete = [];
            var newOrders = this.currentTable.orders;
            for (let i = 0; i < this.currentTable.orders.length; i++) {
                if (this.currentTable.orders[i].quantity === 0) {
                    itemsToDelete.push(i)
                }
            }
            for (let i = 0; i < itemsToDelete.length; i++) {
                this.currentTable.orders.splice(i,1)
            }
            for (let i = 0; i < newOrders.length; i++) {
                delete  newOrders[i].id;
            }

            store.dispatch("saveOrders",{"tableNumber": this.currentTable.tableNumber ,"orders":newOrders })
        }


    },
    mounted:function () {
        var value =  store.state.boards.filter((b)=>{
            return b.tableNumber == router.currentRoute.params.tableNumber
        });
        for (let i = 0; i < value[0].orders.length; i++) {
            value[0].orders[i].id = i;
        }
        this.currentTable=value[0];


    }

}
</script>

<style scoped>
        .modal-grid{
        padding-left: 15px;
        padding-right: 15px;
        display: grid;
        grid-template-areas: "options display-content" ;
        grid-template-columns: 20% 80%;
    }
    /* .display-content{

    } */
    .options{
        align-items: flex-start;
        padding: 10px;
        padding-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;

    }
    table{
        text-align: center !important;
    }
    td{
        position: relative;
    }
    .fa-remove{
        display: none;
        cursor: pointer;
        border-radius: 100%;
        width:20px;
        height: 20px;
        text-align: center;
        margin-left: 12px;
    }
    .fa-remove:hover{
        background-color: rgb(255, 0, 0,70%);
    }
    .fa-remove:active{
        transform: scale(1.1);
    }

    .fa-minus , .fa-plus{
        display: none;
        position: absolute;
        margin-top: unset !important;
        cursor: pointer;
        border-radius: 100%;
        width:20px;
        height: 20px;
        text-align: center;
    }

    .fa-minus{
       right:10px;
       top: 10px;

    }
    .fa-minus:hover{
        background-color: rgba(0, 47, 255, 0.7);
    }

    .fa-plus{
        left:10px;
        top: 10px;

    }
    .fa-plus:hover{
        background-color: rgba(0, 47, 255, 0.7);
    }

    .fa-plus:active , .fa-minus:active{
        transform: scale(1.1);
    }

</style>
