<template>
    <div class="wrapper" style="background-color: blue;">
        <div class="header" style="background-color: brown;">
            header
        </div>
        <div class="container" style="border:2px solid black; background-color: sandybrown">   
            <div class="sale-point-options" style="border:2px solid black; background-color: gold">
                <input v-model="deleteAfterPaid" type="checkbox" name="deleteAfterPaid" />
                <label for="deleteAfterPaid">الحذف بعد الدفع</label>  
                <div class="option-group">
                    <input v-model="currentOrderStatus"  type="radio" name="notPaid" value="notPaid">
                    <label for="notPaid">غير مدفوع(إفتراضي)</label>  

                    <input v-model="currentOrderStatus" type="radio" name="paid" value="paid">
                    <label for="paid"> مدفوع(إفتراضي) </label>  

                </div>
            </div>
            <div class="sectionItems">
                <div class="sections" style="border:2px solid black; ">
                    <ul>
                            <li :class="currentSection== -1 ? 'selected' : ''" @click="setSectionValue($event.target.value)" value="-1">عرض الكل</li>
                            <template v-for="(section , index) in  allSections" >
                                <li :class="currentSection==section.id ? 'selected' : ''" v-if="section.options == 'free-point' || section.options == 'both'"  :key="section.id"
                                :value="section.id" 
                                @click="setSectionValue($event.target.value)">{{section.name}}</li>
                            </template>
                    </ul>
                </div>
                <div style="border:2px solid black; background-color: blanchedalmond;" class="items">
                    <div class="item" v-for="item in currentItems" :key="item.id">
                        <input class="itemId" type="hidden" :value="item.id">
                        <div class="title" @click="activeItem"> {{item.title}} </div> 
                        <div class="order-quantity"> 
                            <button @click="decresQuantity" disabled class="decrement-order-btn"><i class='fa-solid fa-minus'></i></button>
                            <input disabled type="number" name="quantity"  class=" qty-input text-center" min="1" value="1">
                            <button @click="incresQuantity" disabled class=" increment-order-btn "><i class='fa-solid fa-plus'></i></button>
                        </div>
                        <div class="option">
                            <button disabled @click="add" >أضف</button>
                            <button disabled @click="cancel" >الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="border:2px solid black; background-color: coral;" class="currentOrder">
                <div class="order-option">
                    <button @click="saveFinallOrder" >حفظ</button> 
                    <button @click="currentOrderStatus = 'paid'" v-if="currentOrderStatus=='notPaid'">تعليم كمدفوع</button> 
                    <button  @click="currentOrderStatus = 'notPaid'" v-else >تعليم كغير مدفوع</button>
                    <button @click="currentOrders = []" >حذف</button> 
                    <!-- <button @click="cancelUpdatOrder = []" ></button>  -->
                    <input type="text" name="customerName"  v-model="currentCustomerName" placeholder="إضافة اسم الزبون">
                </div>
                <ul>
                    <li v-for=" order in currentOrders" :key="order.id" :id="'c-o'+order.id">
                            <span>{{order.title}}</span>
                            <div class="quantity"> 
                                <button  disabled  class="decrement-btn" @click="decresOrderQuant(order.id)"><i class='fa-solid fa-minus'></i></button>
                                <input disabled  type="number" name="quantity"  class=" qty-input text-center" min="1" :value="order.quantity">
                                <button  disabled class="increment-btn  " @click="incresOrderQuant(order.id)"><i class='fa-solid fa-plus'></i></button>
                            </div>
                            <button class="delete-current-order" @click="deleteCurrentOrder(order.id)">حذف</button> 
                            <button class="update-current-order" @click="updateCurrentOrder(order.id)">تعديل</button>
                            <button class="save-order-changes" @click="saveOrderChanges(order.id)">حفظ</button>
                            <button class="cancel-update-order" @click="cancelUpdatOrder(order.id)">الغاء</button>
                    </li>
                </ul>            
                <div class="total" style="border:2px solid black; background-color: lightgrey;">
                    {{ totale }}
                </div>
            </div>
            <div  class="orders">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>اسم الزبون</th>
                            <th>المجموع</th>
                            <th>حالة الطلب</th>
                            <th>وقت الطلب</th>
                            <th>اخر تعديل </th>
                            <th> خيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template  v-for="order in currentSalePointOrders">
                            <tr v-if="order" :key="order.id" :class="order.status == 'notPaid' ? 'orderNotPaidYet' : ''">
                                <td>{{order.customerName ? order.customerName : 'غير محدد'}}</td>
                                <td>{{order.totale}} <span>ل.س</span> </td>
                                <td>{{order.status.replace(/notPaid|paid/i,translate)}}</td>
                                <td>{{order.created_at ? order.created_at.replace(/AM|PM/i,translate) : 'غير محدد'}}</td>
                                <td>{{order.updated_at ? order.updated_at.replace(/AM|PM/i,translate) : 'غير محدد'}}</td>
                                <td>
                                    <div  class="orderTableOption">
                                        <button @click="editeSalePointOrder(order.id)">تعديل</button>
                                        <button @click="removeSalePointOrder(order.id)">حذف</button>
                                        <button @click="changeOrderStatus(order.id,'paid')" v-if="order.status =='notPaid'">تعليم كمدفوع</button> 
                                        <button @click="changeOrderStatus(order.id,'notPaid')" v-else>تعليم كغير مدفوع</button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { v4 as uuidv4 } from 'uuid';
import store from '../../../store'
export default {
    data (){
        return{
            deleteAfterPaid:false,
            currentSection : -1,
            currentItems : [],
            currentOrders : [],
            temperoryVal : null,
            currentCustomerName :'',
            currentOrderStatus :'notPaid',
            createId:null,
            created_at:null,
            updated_at:null,
        }
    },
    computed:{
        allSections: ()=>store.state.menuItems,
        totale: function () {
            var total = 0;
            this.currentOrders.forEach((o)=>{
                total += o.price * o.quantity
            })
            return total;
        },
        currentSalePointOrders:()=> store.state.currentSalePointOrders,
        finallOrder:{
            get() {
                var finall = {
                    id:this.createId,
                    orders:this.currentOrders,
                    totale:this.totale,
                    customerName:this.currentCustomerName,
                    created_at:this.created_at,
                    updated_at:this.updated_at,
                    status : this.currentOrderStatus,
                }
                return finall
            },
            set(newVal){
                this.id = newVal.id;
                this.orders = newVal.orders;
                this.customerName = newVal.customerName;
                this.created_at = newVal.created_at;
                this.updated_at = newVal.updated_at;
                this.status = newVal.status;
            }
        },
    },
    watch:{
        currentSection : {
            handler:function(newVal,oldVal){
                if (newVal == -1) 
                {
                    var array = [];
                    this.allSections.forEach((s , i)=>{
                        array = array.concat(array, s.items);
                    })
                    array = array.sort((a , b)=>{
                        a.section - b.section
                    })
                    this.currentItems =  array;
                }
                else 
                {
                    this.currentItems = store.getters.menuSectionItems(newVal);
                }
            },
            immediate:false,
        },
    },
    methods:{
        translate(word){
            switch (word) {
                case 'paid':
                    word = 'مدفوع'
                    break;
                case 'notPaid':
                    word = 'غير مدفوع'
                    break;
                case 'AM':
                    word = ' صباحاً'
                break;
                case 'PM':
                    word = ' مساءً'
                break;
            }
            return word ;
        },
        setSectionValue(val){
            this.currentSection = val;
        },
        activeItem(e){
            $(e.target).closest('.item').find('.order-quantity , .option').css('visibility','visible')
            $(e.target).closest('.item').find('.order-quantity input[name="quantity"] , .order-quantity .decrement-order-btn ,.order-quantity .increment-order-btn , .option button')
            .attr('disabled',false);
        },
        async add(e){
            var id = parseInt($(e.target).closest('.item').find('.itemId').val());
            var quantity = parseInt($(e.target).closest('.item').find('.order-quantity input[name="quantity"]').val());
            var item = await this.findItem(id , this.currentItems);
            var order = this.currentOrders.find(o => o.id === id) ;
            if (order) {
                order.quantity +=  quantity
            } 
            else{
                var order = {
                    id : id,
                    title: item.title,
                    price:item.price,
                    quantity:quantity,
                }
                this.currentOrders.push(order);
            }
        },
        cancel(e){
            $(e.target).closest('.item').find('.order-quantity , .option').css('visibility','hidden')
            $(e.target).closest('.item').find('.order-quantity input[name="quantity"] , .order-quantity .decrement-order-btn ,.order-quantity .increment-order-btn , .option button')
            .attr('disabled',true);
            $(e.target).closest('.item').find('.order-quantity input[name="quantity"]').val(1);
        },
        decresQuantity(e){
           var q = parseInt($(e.target).closest('.item').find('.order-quantity input[name="quantity"]').val());
           if(q > 1) q--
           $(e.target).closest('.item').find('.order-quantity input[name="quantity"]').val(q)
        },
        incresQuantity(e){
           var q = parseInt($(e.target).closest('.item').find('.order-quantity input[name="quantity"]').val());
           q++
           $(e.target).closest('.item').find('.order-quantity input[name="quantity"]').val(q)
        },
        findItem(id , array){
            return new Promise((resolve)=>{
                var item = array.find((item )=> {return item.id == id})
                resolve(item)
            })
        },
        removItem(id , array){
                array = array.filter((item)=>{return item.id != id})
                return array;
        },
        async updateCurrentOrder(id){
            var order = await this.findItem(id , this.currentOrders);
            this.temperoryVal = JSON.parse(JSON.stringify(order.quantity));
            $('#c-o'+id).find('.quantity input[name="quantity"]').attr('disabled',false);
            $('#c-o'+id+' .decrement-btn , #c-o'+id+' .increment-btn').attr('disabled',false);
            $('#c-o'+id+' .decrement-btn , #c-o'+id+' .increment-btn').css('visibility','visible');
            $('.update-current-order').css('display','none');
            $('.save-order-changes').css('display','inline');
            $('.cancel-update-order').css('display','inline');
        },
        async cancelUpdatOrder(id){
            var order = await this.findItem(id , this.currentOrders);
            order.quantity =parseInt(this.temperoryVal);
            $('#c-o'+id).find('.quantity input[name="quantity"]').attr('disabled',true);
            $('#c-o'+id+' .decrement-btn , #c-o'+id+' .increment-btn').attr('disabled',true);
            $('#c-o'+id+' .decrement-btn , #c-o'+id+' .increment-btn').css('visibility','hidden');
            $('.update-current-order').css('display','inline');
            $('.save-order-changes').css('display','none');
            $('.cancel-update-order').css('display','none');
        },
        saveOrderChanges(id){
            $('#c-o'+id).find('.quantity input[name="quantity"]').attr('disabled',true);
            $('#c-o'+id+' .decrement-btn , #c-o'+id+' .increment-btn').attr('disabled',true);
            $('#c-o'+id+' .decrement-btn , #c-o'+id+' .increment-btn').css('visibility','hidden');
            $('.update-current-order').css('display','inline');
            $('.save-order-changes').css('display','none');
            $('.cancel-update-order').css('display','none');
        },
        deleteCurrentOrder(id){
           this.currentOrders = this.removItem(id , this.currentOrders) 
        },
        async decresOrderQuant(id){
            var order = await this.findItem(id , this.currentOrders);

            if (order.quantity > 1) order.quantity--
        },
        async incresOrderQuant(id){
            var order = await this.findItem(id , this.currentOrders);
            order.quantity++


        },
        saveFinallOrder(){
            if (this.deleteAfterPaid && this.currentOrderStatus=='paid') {
                    store.dispatch('deleteSalePointOrder' , {'id':this.createId});
            }
            else{
                if (!this.createId) {
                    this.createId =  uuidv4();
                }
                var finallO =  JSON.stringify(this.finallOrder);
                store.dispatch('saveSalePointOrder' , {'order':finallO});
            }
            this.createId=null;
            this.currentCustomerName = '';
            this.currentOrderStatus='notPaid';
            this.currentOrders=[];
            this.created_at=null;
            this.updated_at=null;
        },
        removeSalePointOrder(id){
            store.dispatch('deleteSalePointOrder' ,{ 'id': id});
        },
        async editeSalePointOrder(id){
            var order = await this.findItem(id,this.currentSalePointOrders);
            this.createId = order.id;
            this.currentOrders = order.orders;
            this.currentCustomerName = order.customerName;
            this.currentOrderStatus = order.status;
            this.created_at = order.created_at;
            this.updated_at = order.updated_at;
        },
        async changeOrderStatus(id , status){
            var order = await this.findItem(id,this.currentSalePointOrders);
            order.status = status;
            if (this.deleteAfterPaid && status == 'paid' ) {
                store.dispatch('deleteSalePointOrder' , {'id':order.id});
            }
            else{
                order = JSON.stringify(order);
                store.dispatch('saveSalePointOrder' , {'order':order});
            }
        }
    },
   mounted:function () {
        store.dispatch('bringAllMenuItems').then(()=>{
            setTimeout(()=>{
                this.currentSection = '-1' ;
            } ,1000)
        });
        store.dispatch('bringAllSalePointOrders');

    }
}
</script>
    
<style scoped>
    .wrapper{
        transform: translateY(0);
    }
    .container{
        width: 1000px;
        min-height: 70vh ;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: minmax(100px, auto);
    }
    .sale-point-options{
        grid-column: 1/3;
        grid-row: 1;
    }
    .sectionItems{
        grid-column: 1/1;
        grid-row: 2;
        display: flex;
        flex-grow: 1;
    }
    .currentOrder{
        position: relative;
        grid-column: 2/3;
        grid-row: 2;

    }
    .orders{
        max-height: 585px;
        overflow: auto;
        grid-column: 1/3;
        grid-row: 3;
        padding-left: 70px;
        padding-right: 70px;
        background: rgba(0, 0, 0);
    }
    .sections{
        overflow-y: auto;
        overflow-x: hidden;
        width: 40%;
    }
    .sections ul{
        width: 100%;
        padding-left: 0%;
    }
    
    .sections li{
        width: 100%;
        padding: 6px 10px;
    }
    .sections li:hover{
        background-color: rgb(15, 15, 15) !important;
        color: azure;
    }
    .sections li:nth-child(2n){
        background-color: darkgray;
    }
    .sections li:nth-child(2n+1){
        background-color: rgb(117, 116, 116);
    }
     .sections .selected{
        background-color: rgb(15, 15, 15) !important;
        color: azure;
    }
    .items{
        width: 60%;
        min-height: 100px;
        height: 250px;
        overflow: scroll;
    }
    .items .item{
        padding: 6px 10px;
        display: flex;
        justify-content: space-evenly;
        flex-grow: 1;
        align-items: center;
    }
    .items .item .title{
        width: 90px;
    } 
    .items .item .order-quantity {
        display: flex;
        flex-wrap: nowrap;
    }
    .items .item input[type="number"]{
        text-align: center;
        width: 50px;
    }
    .items .item input[type="number"]{
        text-align: center;
        width: 50px;
    }
    .items .item input[type="number"]::-webkit-inner-spin-button
    {
        appearance: none;
    }
    .items .item .option{
        display: flex;
        justify-content: center;
        gap:10px;
        width: 90px;
    }
    .orderNotPaidYet{
        background: rgba(212, 108, 108 , 0.6);
    }
    .orderTableOption{
        display: flex;
        justify-content: space-between;
        height: 100%;
        width: 250px;
    }
    
    .orderTableOption button{
        border-radius: 20px;
        padding: 0px 6px;
        color: aliceblue;
        background: rgb(18, 116, 111);
    }
    
    .orderTableOption button:hover{
        background: rgb(29, 77, 58);
    }
    .orderTableOption button:active{
        background: rgb(17, 48, 35);
    }
    table{
        border: 2px solid rgb(250, 245, 240);
        border-top: 0px solid rgb(250, 245, 240);
        background: rgb(250, 245, 240);
        height: 100%;
        margin-bottom: 0%;
    }
    thead{
        position: sticky;
        top: 0px;
    }
    th , td {
        text-align: center;
    }
    .total{
        position: absolute;
        bottom: 0;
    }
    ul{
        list-style: none;
    }
    .order-option{
        display: flex;
        flex-wrap: wrap;
    }
    .order-option button{
        flex: 0 0 33.3333%;
    }
    .decrement-btn , .increment-btn  , .order-quantity , .option{
        visibility: hidden;
    }
    .save-order-changes , .cancel-update-order{
        display: none;
    }
</style>