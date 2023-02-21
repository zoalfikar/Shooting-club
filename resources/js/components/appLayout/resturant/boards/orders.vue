<template>
    <div class="modal-grid">
              <div class="optionplusTotal">
                  <div class="options">
                      <v-btn rounded color="primary" dark @click="toggleMenu">أضف طلب</v-btn>
                      <v-btn v-if ="editMode" rounded color="primary" dark  @click="saveOrder">حفظ</v-btn>
                      <v-btn v-else rounded color="primary" dark  @click="updateOrder">تعديل طلب</v-btn>
                      <v-btn rounded color="primary" dark> إسال الطلب</v-btn>
                  </div>
                  <div class="total">{{total}} ل.س</div>
              </div>
                  <div class="display-content">
                      <table class="table table-dark table-striped">
                          <thead>
                              <tr>
                                <th scope="col">اسم الطلب</th>
                                <th scope="col">السعر الإفرادي</th>
                                <th scope="col">الكمية</th>
                                <th scope="col">المجموع</th>
                              </tr>
                          </thead>
                          <tbody v-if="orders">
                              <tr v-for="order in orders" :key="order.id">
                                  <td>{{order.title}} <i @click="deleteOrder(order.id)" class="fa fa-remove" ></i></td>
                                  <td>{{order.price}}  ل.س</td>
                                  <td><i @click="increseQ(order.id)" class="fa fa-plus" ></i>{{order.quantity}}<i @click="decreseQ(order.id)"  class="fa fa-minus" ></i></td>
                                  <td>{{order.quantity * order.price}} ل.س</td>
                              </tr>
                          </tbody>
                        </table>
                        <div v-if="!orders" class="empty-orders">لاتوجد طلبات حتى الان</div>
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
              editMode:0,
          }
      },
      computed:{
        currentTableTable:()=>store.state.currentTable,
        currentTableIndex:()=>store.state.currentTableIndex,
        orders:function(){
            if (store.state.boards) {
                return store.state.boards[this.currentTableIndex].orders
            }
            else{
                return []
            }
        },
        total:{
            get(){
                var total = 0;
                if (this.orders) {
                    console.log(this.orders);
                    this.orders.forEach(order => {
                        total += order.price * order.quantity
                    });
                }
                return total
            },
        },
    },
    watch:{

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
            this.editMode = 1 ;
                  $('.fa-remove').css('display', "block");
                  $('.fa-plus').css('display', "block");
                  $('.fa-minus').css('display', "block");
          },
          saveOrder:function (e) {
            // this.editMode = 0 ;
            // $('.fa-remove').css('display', "none");
            // $('.fa-plus').css('display', "none");
            // $('.fa-minus').css('display', "none");
            //   var itemsToDelete = [];
            //   var newOrders = this.currentTable.orders;
            //   for (let i = 0; i < this.currentTable.orders.length; i++) {
            //       if (this.currentTable.orders[i].quantity === 0) {
            //           itemsToDelete.push(i)
            //       }
            //   }
            //   for (let i = 0; i < itemsToDelete.length; i++) {
            //       this.currentTable.orders.splice(i,1)
            //   }
            //   for (let i = 0; i < newOrders.length; i++) {
            //       delete  newOrders[i].id;
            //   }

            //   store.dispatch("saveOrders",{"tableNumber": this.currentTable.tableNumber ,"orders":newOrders })
          }


      },
      mounted:function () {
        //   var value =  store.state.boards.filter((b)=>{
        //       return b.tableNumber == router.currentRoute.params.tableNumber
        //   });
        //   for (let i = 0; i < value[0].orders.length; i++) {
        //       value[0].orders[i].id = i;
        //   }
        //   this.currentTable=value[0];

          $('.optionplusTotal').css('height', $('.modal-navigation-content').css('height'));

      }

  }
  </script>

  <style scoped>
          .modal-grid{
          padding-left: 15px;
          padding-right: 15px;
          display: grid;
          grid-template-areas: "optionplusTotal display-content" ;
          grid-template-columns: 20% 80%;
          min-height: 100%;
      }
      /* .display-content{

      } */
      .optionplusTotal{
          position: sticky;
          top:0;
      }
      .options{
          align-items: flex-start;
          padding: 10px;
          padding-top: 20px;
          display: flex;
          flex-direction: column;
          gap: 15px;
      }
      .total{
          display: flex;
          align-items:center;
          justify-content:center;
          position: absolute;
          bottom: 40px;
          width: 90%;
          height: 70px;
          background:linear-gradient(135deg,rgba(255,255,255,0.1),rgba(255,255,255,0));
          backdrop-filter: blur(10px);
          border:1px solid rgba(255,255,255,0.18);
          margin-left: 20px;
          border-radius: 30%;
          box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.37);


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
      .empty-orders{
        font-size: large;
        color: rgb(172, 174, 175);
        padding-top: 20px;
        width: 100%;
        height: 50px;
        text-align: center;
      }

  </style>
