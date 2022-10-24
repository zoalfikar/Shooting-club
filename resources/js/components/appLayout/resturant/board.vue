<template>
    <v-card
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
            @click.stop="active"
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
  </template>

<script>
import store from "../../../store";
export default {
    props:{
        'status': String ,
        'tablenumber' : String
        },
    data () {
        return {
        }
    },
    computed: {
            test: ()=> store.state.test,
        },
    methods : {
        reservation: function(){
            this.status = 'taken';
            moveitem('3', this.tablenumber);
            // store.dispatch("chang" , this.tablenumber);
        },
        empty: function(){
            this.status = '';
            moveitem('1',this.tablenumber)
        },
        active: function(){
            this.status = 'active';
            moveitem('2',this.tablenumber)
        },
        toggleBoardModal : function() {
            document.querySelector(".board-modal").style.display = "block";
            document.querySelector(".board-modal-content").classList.add("animat-show-modal");
            document.querySelector(".board-modal-content").addEventListener('animationend', () => {
                document.querySelector(".board-modal-content").classList.remove("animat-show-modal");

            });

    }

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
</style>
