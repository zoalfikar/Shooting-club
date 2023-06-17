<template>
    <div v-if="salePointNotFound" class="container2" >
        <div class="notFound">
            <h1>لم يتم تحديد مجال عمل حتى الان</h1>
        </div>
    </div>
    <div v-else class="container">
        <div class="sale-point-options" >
           <!-- <div class="option-group1">
                <input @click="displayDeleteOptions" v-model="deleteAfterPaid" type="checkbox" name="deleteAfterPaid"/>
                <label for="deleteAfterPaid">الحذف بعد الدفع</label>
            </div>-->
            <div class="option-group2">
                <input v-model="currentOrderStatus"  type="radio" name="notPaid" value="notPaid">
                <label for="notPaid">غير مدفوع ( إفتراضي )</label>

                <input v-model="currentOrderStatus" type="radio" name="paid" value="paid">
                <label for="paid"> مدفوع ( إفتراضي ) </label>

            </div>
        </div>
        <div class="sectionItems">
            <div class="sections" >
                <ul>
                    <template v-for="(section , index) in  allSections" >
                        <li :class="currentSection.id==section.id ? 'selected' : ''" :key="section.id"
                        :value="section.id"
                        :disabled="section.active?false:true"
                        :style="`
                        background-color: ${section.active?'':'rgb(255, 112, 112)'}
                        opacity: ${section.active? 1 : 0.3}
                        `"
                        @click="setSectionValue(section ,section.active)">{{section.name}}</li>
                    </template>
                </ul>
            </div>
            <div  class="items">
                <div class="item" v-for="item in currentItems" :key="item.id"
                :style="`
                background-color: ${item.active?'':'rgb(255, 112, 112)'}
                opacity: ${item.active? 1 : 0.3}
                `"
                :class="`${item.active? '':'item-not-active'}`"
                >
                    <input class="itemId" type="hidden" :value="item.id">
                    <div class="title" @click="activeItem($event,item.active)" :title="item.price + ' ل.س' + '  /  ' + item.unit"> {{item.title}} </div>
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
        <div  class="currentOrder">
            <div class="order-option">
                <button @click="saveFinallOrder" >حفظ</button>
                <button @click="currentOrderStatus = 'paid'" v-if="currentOrderStatus=='notPaid'">تعليم كمدفوع</button>
                <button  @click="currentOrderStatus = 'notPaid'" v-else >تعليم كغير مدفوع</button>
                <button @click="currentOrders = []" >محو</button>
                <input type="text" name="customerName"  v-model="currentCustomerName" placeholder="إضافة اسم الزبون">
            </div>
            <ul>
                <li v-for=" order in currentOrders" :key="order.id" :id="'c-o'+order.id">
                        <div class="title">{{order.title}}</div>
                        <div class="quantity">
                            <button  disabled  class="decrement-btn" @click="decresOrderQuant(order.id)"><i class='fa-solid fa-minus'></i></button>
                            <input disabled  type="number" name="quantity"  class=" qty-input text-center" min="1" :value="order.quantity">
                            <button  disabled class="increment-btn  " @click="incresOrderQuant(order.id)"><i class='fa-solid fa-plus'></i></button>
                        </div>
                        <button class="delete-current-order bOption" @click="deleteCurrentOrder(order.id)">حذف</button>
                        <button class="update-current-order bOption" @click="updateCurrentOrder(order.id)">تعديل</button>
                        <button class="save-order-changes bOption" @click="saveOrderChanges(order.id)">حفظ</button>
                        <button class="cancel-update-order bOption" @click="cancelUpdatOrder(order.id)">الغاء</button>
                </li>
            </ul>
            <div class="total" >
                {{ totale }} &nbsp;<span>ل.س</span>
            </div>
        </div>
        <div  class="orders">
            <table class="table table-striped" :style="`display: ${loading?'block !important':''}`">
                <thead class="table-dark" :style="` ${loading?'display: block !important ; width:100%':''}`">
                    <tr :style="` ${loading?'display: flex !important ; width:100%':''}`">
                        <th :style="` ${loading?'flex-grow: 1 !important':''}`">اسم الزبون</th>
                        <th :style="` ${loading?'flex-grow: 1 !important':''}`">المجموع</th>
                        <th :style="` ${loading?'flex-grow: 1 !important':''}`">حالة الطلب</th>
                        <th :style="` ${loading?'flex-grow: 1 !important':''}`">وقت الطلب</th>
                        <th :style="` ${loading?'flex-grow: 1 !important':''}`">اخر تعديل </th>
                        <th :style="` ${loading?'flex-grow: 1 !important':''}`"> خيارات</th>
                    </tr>
                </thead>
                <div v-if="loading"  style="text-align:center;font-size:20px;padding:30px;">تحميل الطلبات ...</div>
                <tbody v-else>
                    <template  v-for="order in currentSalePointOrders">
                        <tr v-if="order" :key="order.id" :class="order.status == 'notPaid' ? 'orderNotPaidYet' : ''">
                            <td>{{order.customerName ? order.customerName : 'غير محدد'}}</td>
                            <td>{{order.totale}} <span>ل.س</span> </td>
                            <td>{{order.status.replace(/notPaid|paid/i,translate)}}</td>
                            <td>{{order.created_at ? order.created_at.replace(/AM|PM/i,translate) : 'غير محدد'}}</td>
                            <td>{{order.updated_at ? order.updated_at.replace(/AM|PM/i,translate) : 'غير محدد'}}</td>
                            <td>
                                <div  class="orderTableOption">
                                    <button @click="editeSalePointOrder(order.id)">عرض</button>
                                    <button @click="removeSalePointOrder(order.id)">حذف</button>
                                    <button @click="changeOrderStatus(order.id,'paid')" v-if="order.status =='notPaid'">دفع الحساب</button>
                                   <!-- <button @click=" changeOrderStatus(order.id,'notPaid')" v-else>تعليم كغير مدفوع</button>-->
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { v4 as uuidv4 } from 'uuid';
import store from '../../../store'
export default {
    data (){
        return{
            deleteAfterPaid:null,
            currentSection : -1,
            currentOrders : [],
            temperoryVal : null,
            currentCustomerName :'',
            currentOrderStatus :null,
            createId:null,
            created_at:null,
            updated_at:null,
        }
    },
    computed:{
        setting:()=>store.state.currentSalePointSetting,
        loading: ()=>store.state.ordersLoading,
        allSections: ()=>store.state.salePointMenuItems,
        currentItems: function(){return this.currentSection.items},
        totale: function () {
            var total = 0;
            this.currentOrders.forEach((o)=>{
                total += o.price * o.quantity
            })
            return total;
        },
        salePointNotFound:()=>store.state.salePointNotFound,
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
                if(newVal == -1)
                    this.currentItems = []
                // else
                //    this.currentItems = store.getters.salePointMenuSectionItems(newVal);
            },
            immediate:false,
        },
        currentItems : {
            handler: function(newVal,oldVal){
                const callFunc = this.cancelAllDisactive;
                Promise.resolve(newVal).then((e)=>{
                    callFunc()
               })

            },
            immediate:false,
            deep:true
        },
        setting : {
            handler:function(newVal,oldVal){
                this.deleteAfterPaid = newVal.deleteAfterPaid;
                this.currentOrderStatus = newVal.paid?'paid':'notPaid';
            },
            immediate:true,
        },
        deleteAfterPaid : {
            handler:async function(newVal,oldVal){
                if(newVal !== oldVal){
                    var p = this.currentOrderStatus == 'paid'
                    store.dispatch("setSalePointSettings",{'deleteAfterPaid':this.deleteAfterPaid,'paid':p})

                }
            },
            immediate:false,
        },
        currentOrderStatus : {
            handler:function(newVal,oldVal){
                if(newVal !== oldVal){
                    var p = newVal == 'paid'
                    store.dispatch("setSalePointSettings",{'deleteAfterPaid':this.deleteAfterPaid,'paid':p})
                }
            },
            immediate:false,
        },
    },
    methods:{
        async displayDeleteOptions(){
            if(!this.deleteAfterPaid){
                confirm = await swal({
                    text: `هل تريد حذف جميع الطلبات المدفوعة السابقة`,
                    icon: "warning",
                    buttons: {
                        yes: {text:'نعم',classNacme:'sweet-warning'},
                        no: 'لا',
                    },
                })
                if(confirm == 'yes') store.dispatch('deletePreviousSPOreders')
            }
        },
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
        setSectionValue(val , active){
            if(!active) return 0
            this.currentSection = val;
        },
        activeItem(e , active){
            if(!active) return 0;
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
                    section:item.section,
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
        cancelAllDisactive(){
            $('.items .item').each((i,v)=>{
                if ($(v).hasClass('item-not-active'))
                {
                    this.cancel({target:v})
                    this.deleteCurrentOrder($(v).find('input').val())
                }
            })
        },
        removeDisactiveSectionOreders(section){
            this.currentOrders =  this.currentOrders.filter((o)=>o.section !== section)
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
                store.dispatch('saveSalePointOrder' , {'order':finallO , 'salePoint':store.state.currentSalePoint});
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
        },
        addToInventory(salePoint , order){

        }
    },
   mounted:function () {
    Echo.channel('sale-point-channel').listen('orderAdded', (e) =>
        {
            if (e.salePoint == this.currentSalePoint) {
                store.commit('setSalePointOrder' , e.order)
            }
        })
        Echo.channel('sale-point-channel').listen('orderDeleted', (e) =>
        {
            if (e.salePoint == this.currentSalePoint) {
                store.commit('deleteSalePointOrder' , e.order)
            }
        })
        Echo.channel('sale-point-channel').listen('orderDeleted', (e) =>
        {
            if (e.salePoint == this.currentSalePoint) {
                store.commit('setSalePointOrders' , e.orders)
            }
        })
        Echo.channel('sale-point-channel').listen('salePointSettings', (e) =>
        {
            if (e.salePoint == this.currentSalePoint) {
                store.commit('setSalePointOrders' , e.settings)
            }
        })
        Echo.channel('menu-sections').listen('menuSectionAdded', (e) =>
        {
            if (e.menuSection.options == 'both' || e.menuSection.options == 'free-point' ) {
                store.commit('addMenuSection' , e.menuSection)
            }
        })
        Echo.channel('menu-sections').listen('menuSectionUpdated', (e) =>
        {
            if (e.menuSection.options == 'both' || e.menuSection.options == 'free-point' ) {
                store.commit('updateMenuSection' , e.menuSection)
               if(!e.menuSection.active)
                    {
                        this.removeDisactiveSectionOreders(e.menuSection.id)
                        if(e.menuSection.id == this.currentSection.id)
                            this.currentSection = -1
                    }
            }
        })
        Echo.channel('menu-sections').listen('menuSectionDeleted', (e) =>
        {
            if (e.menuSection.options == 'both' || e.menuSection.options == 'free-point' ) {
                store.commit('deleteMenuSection' , e.menuSection)
                this.removeDisactiveSectionOreders(e.menuSection.id)
                if(e.menuSection.id == this.currentSection.id)
                    this.currentSection = -1
            }
        })
        Echo.channel('menu-sections').listen('menuSectionItemsUpdated', (e) =>
        {
            if (e.menuSection.options == 'both' || e.menuSection.options == 'free-point' ) {
                store.commit('setMenuSectionItems' ,{ section:e.menuSection , items:e.items})
                // if(e.menuSection.id == this.currentSection.id)
                //     this.currentSection = -1
            }
        })
        const currentOrderUl = document.querySelector('.currentOrder ul');
        const orders = document.querySelector('.orders');
        const ordersTable = document.querySelector('.orders tbody');
        const config = { childList: true };
        const callback = function (mutationsList, observer) {
        for (let mutation of mutationsList) {
            if (mutation.type === "childList") {
            currentOrderUl.scrollTo(0, currentOrderUl.scrollHeight);
            }
        }
        };
        const callback2 = function (mutationsList, observer) {
        for (let mutation of mutationsList) {
            if (mutation.type === "childList") {
                orders.scrollTo(0, orders.scrollHeight);
            }
        }
        };
        const observer = new MutationObserver(callback);
        const observer2 = new MutationObserver(callback2);
        observer.observe(currentOrderUl, config);
        observer2.observe(ordersTable, config);
        ///
    }
}
</script>

<style scoped>
    .container{
        width: 1160px;
        min-height: 70vh ;
        display: grid;
        grid-template-columns: 56% 44%;
        grid-auto-rows:auto;
        padding-top: 0px !important;
        border: 2px solid black;


    }
    .notFound{
        background-color: red;
        color: white;
        height:170px;
        text-align: center;
        padding: 30px;
        width:100%;
    }
    .sale-point-options{
        grid-column: 1/3;
        grid-row: 1;
        display: flex;
        height: max-content;
        padding: 20px 14px;
        gap: 40px;
        color: white;
    }
    .sale-point-options .option-group2{
        display: flex;
        gap: 10px;
    }
    .sectionItems{
        grid-column: 1/1;
        grid-row: 2;
        display: flex;
        flex-grow: 1;
        min-width: 580px;
        box-sizing: border-box;
        border: 2px solid black;
    }
    .currentOrder{
        background-color: hsla(0, 100%, 82%, 0.788);
        position: relative;
        grid-column: 2/3;
        grid-row: 2;
        min-height:320px;
        max-height:320px;
        overflow: overlay;
        border: 2px solid black;

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
        background-color: hsla(0, 19%, 21%, 0.788);
        height: 320px;
        overflow-y: auto;
        overflow-x: hidden;
        width: 30%;
        border: 2px solid black;

    }
    .sections ul{
        width: 100%;
        padding-left: 0%;
    }

    .sections li{
        width: 100%;
        padding: 6px 10px;
        cursor: pointer;
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
        box-sizing: border-box;
        width: 70%;
        height: 320px;
        overflow: scroll;
        border: 2px solid black;
        background-color: hsla(221, 70%, 8%, 0.788);
        color: aqua;

    }
    .items .item{
        padding: 10px 10px;
        display: flex;
        justify-content: space-evenly;
        flex-grow: 1;
        align-items: center;
        font-size: large;
        gap:5px;
        border-bottom:0.5px inset rgb(126, 79, 79) ;
    }
    .items .item:hover{
        color: rgb(61, 32, 32);
       background-color: rgba(230, 230, 230, 0.4);
       cursor:pointer;
    }

    .items .item .title{
        width: 130px;
        white-space: nowrap;
        overflow-x: auto;
    }

    .items .item .order-quantity {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        gap:3px
    }
    .items .item .order-quantity button{
        width: 20px;
        height:20px;
        background-color: rgb(126, 53, 53);
        border-radius: 100%;
        color: white;
    }
    .items .item .order-quantity button:hover{
        background-color: rgb(90, 31, 31);
    }
    .items .item .order-quantity button:active{
        background-color: rgb(71, 22, 22);
    }

    .items .item .order-quantity input[type="number"]{
        text-align: center;
        width: 50px;
        background-color: rgba(126, 53, 53, 0.7);
        color: white;

    }
    .items .item .order-quantity input[type="number"]::-webkit-inner-spin-button
    {
        appearance: none;
    }
    .items .item .option{
        display: flex;
        justify-content: center;
        gap:14px;
        width: 90px;
    }
    .items .item .option button{
        color: white;
        width: 40px;
        background-color: rgb(95, 25, 25);
    }
    .items .item .option button:hover{
        background-color: rgb(75, 15, 15);
    }
    .items .item .option button:active{
        background-color: rgb(0, 0, 0);
    }
    .currentOrder .order-option{
        display: flex;
        flex-wrap: wrap;
    }
    .currentOrder .order-option button{
        color: aqua;
        flex: 0 0 33.3333%;
        background-color: rgba(126, 53, 53, 0.7);
    }
    .currentOrder .order-option button:hover{
        background-color: rgba(161, 87, 87, 0.7);
    }
    .currentOrder .order-option button:active{
        background-color: rgba(189, 141, 141, 0.7);
    }
    .currentOrder .order-option input{
        padding: 4px 8px;
        flex: 0 0 100%;
        background-color: rgb(221, 202, 206);
        color: rgb(37, 41, 41);
    }
    .currentOrder .order-option input:hover{
        background-color: rgb(202, 173, 179);
        color: rgb(37, 41, 41);
    }
    .currentOrder ul{
        height: 210px;
        overflow: overlay;
        padding-left:0 !important ;
        list-style: none;
    }
    .currentOrder li{
        width: 100%;
        padding: 5px 10px;
        display: flex;
        flex-grow: 1;
        justify-content: space-between;
        gap: 20px;
    }
    .currentOrder li .title{
        width: 120px;
    }
    .currentOrder li .quantity{
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        gap:6px
    }
    .currentOrder li .quantity button{
        width: 20px;
        height:20px;
        background-color: rgb(126, 53, 53);
        border-radius: 100%;
        color: white;
    }
    .currentOrder li .quantity input{
        text-align: center;
        width: 50px;
        background-color: rgba(126, 53, 53, 0.7);
        color: white;
    }
    .currentOrder li .quantity input::-webkit-inner-spin-button{
        appearance: none;
    }
    .currentOrder li .bOption{
        padding: 2px 5px;
    }
    .currentOrder li .bOption:hover{
        background-color: rgba(212, 212, 212,0.7);
    }
    .currentOrder li .bOption:active{
        background-color: rgb(247, 247, 247,0.7);
    }
    .total{
        height: 47px;
        width: 107px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        bottom: 0;
        background-color: rgb(22, 21, 21);
        color: aliceblue;
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
    ul{
        padding-left:0 !important ;
        list-style: none;
    }
    .decrement-btn , .increment-btn  , .order-quantity , .option{
        visibility: hidden;
    }
    .save-order-changes , .cancel-update-order{
        display: none;
    }
</style>

