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
                <h1>{{tablenumber}}</h1>
            </div>
        </div>

        <v-card-subtitle>الحالة : مشغولة / محجوزة / متوفرة</v-card-subtitle>
        <v-card-actions>
        <v-btn
            text
            color="teal accent-4"
            @click.stop="reservation"
        >
            حجز
        </v-btn>
        <v-btn
            text
            color="teal accent-4"
            @click.stop="occupied"
        >
            مشغولة
        </v-btn>
        <v-btn
            text
            color="teal accent-4"
            @click.stop="empty"
        >
            فارغة
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
                <h1>{{tablenumber}}</h1>
            </div>
        </div>
        <v-card-subtitle><div style="color: hwb(153 7% 76%);">الحالة : للعرض فقط</div></v-card-subtitle>
        <v-card-actions>
             <h4 class="notActiveAlert" style="color: hwb(153 7% 76%); text-align: center; width:100%">خارج الخدمة حاليا </h4>
        </v-card-actions>
    </v-card>
  </template>

<script>
import router from '../../../routes';
import store from "../../../store";
export default {
    props:{
        'status': String ,
        'tablenumber' : Number,
        'active' : Number,
        },
        // emits:['statusChanged'],
    data () {
        return {
        }
    },
    computed: {
            // test: ()=> store.state.test,
        },
    methods : {
        reservation: function(){
            this.status = 'taken';
            this.$emit('statusChanged' , {order:3,tableNumber:this.tablenumber });
            // moveitem('3', this.tablenumber);
            store.dispatch("changeBoardState" ,  {"status":'taken' ,"tableNumber":this.tablenumber} );
        },
        empty: function(){
            this.status = '';
            this.$emit('statusChanged' , {order:1,tableNumber:this.tablenumber });

            // moveitem('1',this.tablenumber)
            store.dispatch("changeBoardState" ,  {"status":'' ,"tableNumber":this.tablenumber} );
        },
        occupied: function(){
            this.status = 'active';
            // moveitem('2',this.tablenumber)
            this.$emit('statusChanged' , {order:2,tableNumber:this.tablenumber });

            $(".info-modal").css("display", "block");
            store.dispatch("changeBoardState" ,  {"status":'active' ,"tableNumber":this.tablenumber}  );
        },
        notActiveAction:function (element) {
            console.log(element);
        },
        toggleBoardModal : function() {
            store.dispatch("changeCurrentTableNumber" , this.tablenumber);
            store.dispatch("changeCurrentTableStatus" , this.status);
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
</style>
