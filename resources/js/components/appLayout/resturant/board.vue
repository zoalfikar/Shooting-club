<template>
    <v-card
      v-if="active"
      @click="toggleBoardModal"
      :ripple="false"
      class="mx-auto"
      dark
      max-width="400"
      :color ="`${status ? `${status == 'active' ? 'rgb(119, 82, 82)' : 'rgb(66, 21, 21)' }` : 'rgb(151, 151, 151)'} `"
    >
        <div class="boardNumber text-h1 font-weight-light">
            <div class="boardNumber-border">
                <h1>{{tableNumber}}</h1>
            </div>
            
        </div>
        <v-card-subtitle :id="`cutomerInfo-${tableNumber}`"> 
            <span v-if="borad.customerInfo.customerName"> 
                اسم الزبون :  <span v-if="!nameFilterActive">
                                    {{ borad.customerInfo.customerName}}
                                </span>
                                <span :style="`display: ${nameFilterActive ? 'block' : 'none'}`" :id="`cutomer-info-name-${tableNumber}`">
                                    {{customerNameAlternative}}
                                </span>
                                
            </span>
            <span v-else> 
                <span :id="`table-info-state-${tableNumber}`"> الحالة : متوفرة </span>
            </span>
            <span class="max-capacity"> سعة :&nbsp;{{maxCapacity}} اشخاص</span></v-card-subtitle>
        <v-card-actions>
        <v-btn
            text
            color="teal accent-4"
            @click.stop="reservation"
        >
            حجز
        </v-btn>
        <v-btn v-if="status == '' || status == 'taken'"
            text
            color="teal accent-4"
            @click.stop="occupied"
        >
            مشغولة
        </v-btn>
        <v-btn v-if="status == 'active' || status == 'taken'"
            text
            color="teal accent-4"
            @click.stop="empty"
        >
            دفع الحساب
        </v-btn>
        </v-card-actions>
    </v-card>
    <v-card
      v-else
      @click="notActiveAction($event.target)"
      :ripple="false"
      class="mx-auto v-card-disabled"
      dark
      max-width="400"
      :color ="'rgba(255, 255, 255,20%)'"
    >
        <div class="boardNumber text-h1 font-weight-light">
            <div class="boardNumber-border">
                <h1>{{tableNumber}}</h1>
            </div>
        </div>
        <v-card-subtitle><div style="color: hwb(153 7% 76%);">الحالة : للعرض فقط</div></v-card-subtitle>
        <v-card-actions>
             <h4 class="notActiveAlert" style="color: hwb(153 7% 76%); text-align: center; width:100%">خارج الخدمة حاليا </h4>
        </v-card-actions>
    </v-card>
  </template>

<script>
import store from "../../../store";
export default {
    props:{
        currentHallActive : Number,
        'tableNumber' : Number,
        'index' : Number,
        // 'status': String ,
        // 'maxCapacity': Number ,
        // 'active' : Number,
        },
        // emits:['statusChanged'],
    data () {
        return {
            nameFilterActive : false,
            customerNameAlternativeEl:null,
            customerNameAlternativeColorLetterEl:null,
        }
    },
    computed: {
        // borad:function( )  {
        //     return store.state.boards[this.index]
        // },
        //
        borad:function( )  {
            return store.getters.table(this.tableNumber)
        },
        status:function( )  {
            return this.borad.status
        },
        maxCapacity:function( )  {
            return this.borad.maxCapacity
        },
        active:function( )  {
            return  this.currentHallActive ? this.borad.active : 0
        },
        customerNameAlternative:function( )  {
            if (this.borad.customerInfo.customerName) {
                
                return  (this.borad.customerInfo.customerName).toString() ;
            }
            else{
                return  '' ;

            }
        },
        //
        nameFilter:function () {
           return this.$parent.$data.currentCustomerNameFilter;
        },
    },
    watch:{
        nameFilter:{
            handler(newVal,oldVal){
                if (this.nameFilter !== '') {
                    this.$data.nameFilterActive=true;
                    if (this.customerNameAlternativeEl) {
                        if (this.customerNameAlternativeEl.querySelector('strong')) {
                            this.customerNameAlternativeEl.querySelector('strong').remove()
                        }
                        this.customerNameAlternativeEl.innerHTML = this.customerNameAlternative.replace(String(newVal) , `<strong style="color:blue; background:gray;">${String(newVal)}</strong>` )
                    }
                }
                else {
                    this.$data.nameFilterActive=false;
                }
            },
            immediate:true,
        },
        nameFilterActive(newVal,oldVal){
            if (newVal == true) {
                var el = this.$el.querySelector(`#cutomer-info-name-${this.tableNumber}`);
                if (el ) this.customerNameAlternativeEl = el;
                // var strong = document.createElement('strong');
                // strong.style.color = 'blue';
                // strong.style.background = 'grey';
                // strong.innerText = '';
                // customerNameAlternativeColorLetterEl=strong;
                // customerNameAlternativeEl.appendChild(customerNameAlternativeColorLetterEl);
            }
        }
    },
    methods : {
        reservation: function(){
            // this.status = 'taken';
            this.$emit('statusChanged' , {order:3,tableNumber:this.tableNumber });
            // moveitem('3', this.tableNumber);
            store.dispatch("changeBoardState" ,  {"status":'taken' ,"tableNumber":this.tableNumber} );
        },
        empty: function(){
            // this.status = '';
            this.$emit('statusChanged' , {order:1,tableNumber:this.tableNumber });

            // moveitem('1',this.tableNumber)
            store.dispatch("changeBoardState" ,  {"status":'' ,"tableNumber":this.tableNumber} );
        },
        occupied: function(){
            store.dispatch("changeCurrentTableNumber" , this.tableNumber  );
            store.dispatch("changeBoardState" ,  {"status":'active' ,"tableNumber":this.tableNumber}  );
            $(".info-modal").css("display", "block");
            // this.status = 'active';
            // moveitem('2',this.tableNumber)
            // this.$emit('statusChanged' , {order:2,tableNumber:this.tableNumber });

        },
        notActiveAction:function (element) {
            console.log(element);
        },
        toggleBoardModal : function() {
            store.dispatch("changeCurrentTableNumber" , this.tableNumber);
            store.dispatch("changeCurrentTableStatus" , this.status);
            // store.dispatch("changeCurrentTableData",this.tableNumber);
            var clearShowModel = ()=>{
                document.querySelector(".board-modal-content").classList.remove("animat-show-modal");
                document.querySelector(".board-modal-content").removeEventListener('animationend',clearShowModel);
            }
            document.querySelector(".board-modal").style.display = "block";
            document.querySelector(".board-modal-content").classList.add("animat-show-modal");
            document.querySelector(".board-modal-content").addEventListener('animationend', clearShowModel);

    }

    },
    mounted:function () {
        let created = (e)=>{
            if( e.animationName == 'fade-in-down'){
                this.$el.classList.remove('animate-fade-in-down')
                this.$el.removeEventListener("animationend",created );
            }
        }
        this.$el.addEventListener("animationend",created)
    }
};
</script>

<style scoped>

    .v-card{
        box-shadow:0 0 black;
        top:0;
        opacity: 1;
        transition: top ease-in-out 0.2s , box-shadow ease-in-out 0.2s , opacity ease-in-out 0.2s , background-color ease-in-out 0.4s ;
    }
    .v-card:hover{
        top: 10px;
        box-shadow:0 0 10px black;
    }
    .v-card-disabled{
        top: 0 !important;
        box-shadow: unset !important;
    }
    .v-card-disabled:hover{
        top: 0 !important;
        box-shadow: unset !important;
    }
    .v-card__subtitle{
        position: relative;
    }
    #cutomerInfo{
        position: relative;
    }
    .boardNumber{
        padding-top: 35px;
        width: 100%;
        height: 180px;
        display: flex;
        justify-content: center;
        align-content: center;
    }
    .boardNumber-border{
        width: 120px;
        border: 4px solid white;
        border-radius: 100%;
        display: flex;
        align-content: center;
        justify-content: center;
        background-color: hwb(153 7% 76%);
    }
    .boardNumber-border h1{
        margin: auto;
    }
    .max-capacity{
        float: left;
    }
</style>
