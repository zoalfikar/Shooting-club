<template>
    <div class="board-modal">
        <div class="board-modal-content">
            <div class="modal-title">
                <center><h1>{{currentTable}}</h1> </center>
            </div>
            <div class="modal-navigate">
                <v-btn depressed   class="naveB" @click="getOrders();">الطلبات</v-btn>
                <v-btn depressed   class="naveB"  @click="getStatus()">الحالة</v-btn>
                <v-btn depressed   class="naveB"  @click="getReservitions()">الحجوزات</v-btn>
                <div class="navunderline"></div>
            </div>
            <div class="modal-navigation-content">
                <div class="divider"></div>
                <router-view/>
            </div>
            <div class="btns">
                <v-btn large  @click="done" color="primary">
                    تم!
                </v-btn>
                <v-btn large @click="done" color="primary">
                    الغاء
                </v-btn>
            </div>
        </div>
        <resturant-menu></resturant-menu>
    </div>
</template>
<script>
import { set } from 'vue';
import router from "../../../routes";
import store from '../../../store';



export default {
  data () {

    return {
    }
  },
  computed : {
    currentTable:  ()=> store.state.curerntTable
  }
  ,
  methods:{
        done : () =>{

            var clearHideModal = ()=>{
                document.querySelector(".board-modal-content").classList.remove('animat-hide-modal')
                document.querySelector(".board-modal").style.display = "none" ;
                document.querySelector(".board-modal-content").removeEventListener("animationend" , clearHideModal)
            }
            document.querySelector(".board-modal-content").classList.add('animat-hide-modal')
            document.querySelector(".board-modal-content").addEventListener("animationend" , clearHideModal)
        },
        getOrders:()=>{
            router.push({
                name:"orders",
            });
        },
        getStatus:()=>{
            router.push({
                name:"info",
            });
        },
        getReservitions:()=>{
            router.push({
                name:"reservations",
            });
        }

  },
  mounted : function()
    {
        const modalTitleText = document.querySelector(".modal-title h1")
        modalTitleText.addEventListener('animationiteration' , ()=>{
            modalTitleText.style.animationPlayState ='paused'
            setTimeout(()=>{
                modalTitleText.style.animationPlayState = 'running'
            },7000)
        })
        const modCon =  document.querySelector(".modal-navigation-content")
        var modConAlternative ;
        var currentNavB ;
        var newNavB;
        const divider =document.querySelector(".divider");
        const modal = document.querySelector(".board-modal");
        const navButtuns = document.querySelectorAll(".naveB");
        const underline = document.querySelector(".navunderline")
        var oldModalDisplay = getComputedStyle(modal).display
        const mutationCallback = (mutationsList) => {
            for (const mutation of mutationsList) {
                if (mutation.attributeName == "style")
                {
                    var currentModalDisplay = getComputedStyle(modal).display;
                    if (oldModalDisplay == "none" && currentModalDisplay == "block") {
                        underline.style.left = navButtuns[0].offsetLeft;
                        underline.style.width = getComputedStyle(navButtuns[0]).width
                        oldModalDisplay = 'block';
                        modConAlternative = modCon.cloneNode(true);
                        modConAlternative.style.position="absolute";
                        currentNavB = navButtuns[0];
                    }
                    if (oldModalDisplay == "block" && currentModalDisplay == "none") {
                        underline.style.width = '0';
                        oldModalDisplay = 'none'
                        removeAlternative ()

                    }
                }

            }
        }
        const observer = new MutationObserver(mutationCallback)
        observer.observe(modal, { attributes: true })
        var clearLS = ()=>{
            modConAlternative.classList.remove('shift-center-left');
            modConAlternative.style.display="none"
            modConAlternative.innerHTML = modCon.innerHTML
            modConAlternative.removeEventListener("animationend",clearLS)
        }
        var clearContentLS=()=>{
            modCon.classList.remove('shift-right-center')
            modCon.removeEventListener("animationend",clearContentLS)
        }
        var clearRS = ()=>{
            modConAlternative.classList.remove('shift-center-right');
            modConAlternative.style.display="none"
            modConAlternative.innerHTML = modCon.innerHTML
            modConAlternative.removeEventListener("animationend",clearRS)

        }
        var clearContentRS=()=>{
            modCon.classList.remove('shift-left-center')
            modCon.removeEventListener("animationend",clearContentRS)
        }
        function transNavUnderline(target) {
            underline.style.left = target.offsetLeft
            underline.style.width = target.getBoundingClientRect().width
        }
        function setAlternative (element){
            modConAlternative.style.display="block"
            modConAlternative.style.left = modCon.offsetLeft;
            modConAlternative.style.top = modCon.offsetTop;
            modConAlternative.style.width =  getComputedStyle(modCon).width;
            document.querySelector(".board-modal-content").appendChild(modConAlternative)
        }
        function removeAlternative (){
            document.querySelector(".board-modal-content").removeChild(modConAlternative)
        }
        function slideContentR() {
            divider.style.left= '-unset'
            divider.style.right= '-3px'
            modConAlternative.classList.add('shift-center-right')
            modCon.classList.add('shift-left-center')
            modConAlternative.addEventListener("animationend",clearRS)
            modCon.addEventListener("animationend",clearContentRS)
        }
        function slideContentL() {
            divider.style.right= 'unset'
            divider.style.left= '-3px'
            modConAlternative.classList.add('shift-center-left')
            modCon.classList.add('shift-right-center')
            modConAlternative.addEventListener("animationend",clearLS)
            modCon.addEventListener("animationend",clearContentLS)
        }
        var clearWaitingSlideEnd =()=>{
            modCon.removeEventListener('animationend' ,clearWaitingSlideEnd)
            modCon.style.animationDuration = 'initial'
            modConAlternative.style.animationDuration = 'initial'
            if (currentNavB.offsetLeft >newNavB.offsetLeft) {
                setAlternative (modCon)
                slideContentR()
                currentNavB = newNavB
            }
            if (currentNavB.offsetLeft < newNavB.offsetLeft) {
                setAlternative (modCon)
                slideContentL()
                currentNavB = newNavB
            }
        }

        function slideContent() {
            if (modCon.classList.contains("shift-left-center") || modCon.classList.contains("shift-right-center")) {
                modCon.style.animationDuration = '0.1s'
                modConAlternative.style.animationDuration = '0.1s'
                modCon.addEventListener('animationend' ,clearWaitingSlideEnd)
            } else {
                if (currentNavB.offsetLeft >newNavB.offsetLeft) {
                    setAlternative (modCon)
                    slideContentR()
                    currentNavB = newNavB

                }
                if (currentNavB.offsetLeft < newNavB.offsetLeft) {
                    setAlternative (modCon)
                    slideContentL()
                    currentNavB = newNavB

                }
            }
        }
        for (let i = 0; i < navButtuns.length; i++) {
            navButtuns[i].addEventListener("click" , ()=>{
                if (event.target.tagName=="SPAN") {
                    newNavB=event.target.parentElement
                }
                else{
                    newNavB=event.target
                }
                if (newNavB.offsetLeft != currentNavB.offsetLeft) {
                    transNavUnderline(newNavB);
                    slideContent()
                }

            })
        }

        document.querySelector(".board-modal").addEventListener("click" , ()=>{
            var modal = document.querySelector(".board-modal-content");
            if ( !modal.contains(event.target)) {
                modal.classList.add("animat-alter-modal");
                modal.addEventListener('animationend', () => {
                    modal.classList.remove("animat-alter-modal");
                });
            }
        })
    }
}
</script>
<style scoped>
    @keyframes animat-alter-modal {
        0%{transform: scale(1);}
        50%{transform: scale(1.03);}
        100%{transform: scale(1);}
    }
    @keyframes animat-show-modal {
        from{transform: scale(0);}
        to{transform: scale(1);}
    }
    @keyframes animat-hide-modal {
        from{clip-path: inset(0 0 0 0);}
        to{clip-path: inset( 0 100% 0 0);}
    }
    .animat-alter-modal{
        animation: animat-alter-modal;
        animation-duration: 0.6s;
        animation-timing-function: ease-in-out;
        /* color:inherit */
    }
    .animat-show-modal{
        animation: animat-show-modal;
        animation-duration: 0.6s;
        animation-timing-function: ease-in-out;
    }
    .animat-hide-modal{
        animation: animat-hide-modal;
        animation-duration: 0.6s;
        animation-timing-function: ease-in-out;
    }
    .board-modal{
        display :none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        background-color: rgb(0, 0, 0,45%);
        overflow: auto;
        padding-top: 77px;
    }
    .board-modal-content{
        position: relative;
        overflow-x: hidden;
        color: aliceblue;
        margin: auto;
        width: 750px;

        background-image: linear-gradient(to left bottom ,rgb(102, 102, 102) ,rgb(109, 109, 109)) ;
        background-color: hsl(0, 0%, 45%);
        min-height: 400px;
        border-radius: 13px;
        position: relative;
    }

    .modal-title{
        padding: 5px;
    }

    @keyframes bright_text {
        0% { background-position-y:0px; background-position-x:-520px;}
        100% { background-position-y:5px;background-position-x:700px; }
    }
    .modal-title h1{
    background: linear-gradient(172deg,#1171ee,#1171ee,#1171ee, #ffffff,#1171ee, #1171ee , #1171ee, #1171ee , #1171ee, #1171ee);
    background-size: 200%;
    background-position-y:0px;
    background-position-x:-520px;
	background-clip: text;
    color: rgb(0, 0, 0,0);
	animation: bright_text 5s ease-in-out ;
    animation-iteration-count: infinite ;
    animation-delay: 2s;
    font-size: 90px;
    font-weight: bold;
    }
    .modal-navigate{
        position: relative;
        display: flex;
        padding-right: 20px;
        flex-direction: row;
        /* gap: 25px; */
        border-bottom: 2px solid rgb(255, 208, 208);
        background-color: #5c3636;
        /* row-gap: 10px; */
    }
    .navunderline{
        background-color: rgb(0, 69, 116);
        border-radius: 35%;
        position: absolute;
        height: 3px;
        bottom: 0;
        transform: translateY(2px);
        transition: width 0.2s ease-in-out , left 0.2s ease-in-out;
    }
    .modal-navigate button{
        text-decoration: none ;
        background: none!important;
        border: none;
        color: white;
    }
    @keyframes shift-center-left {
        from{transform: translateX(0);}
        to{transform: translateX(-100%); opacity: 0;}
    }
    @keyframes shift-right-center {
        from{transform: translateX(100%);}
        to{transform: translateX(0);}
    }
    @keyframes shift-center-right {
        from{transform: translateX(0); }
        to{transform: translateX(100%); opacity: 0;}
    }
    @keyframes shift-left-center {
        from{transform: translateX(-100%);}
        to{transform: translateX(0);}
    }
    .shift-right-center{
        animation: shift-right-center ;
        animation-duration: 0.6s !important;
        animation-fill-mode: forwards;
    }
    .shift-center-left{
        animation: shift-center-left ;
        animation-duration: 0.6s !important;
        animation-fill-mode: forwards;
    }
    .shift-left-center{
        animation: shift-left-center ;
        animation-duration: 0.6s !important;
        animation-fill-mode: forwards;
    }
    .shift-center-right{
        animation: shift-center-right ;
        animation-duration: 0.6s !important;
        animation-fill-mode: forwards;
    }
    .modal-navigation-content{
        position: relative;
        height: 400px;
        /* overflow-x: hidden; */
        /* clip-path: inset(0 0 0 0); */
    }
    .divider{
      position: absolute;
      right:-3px;
      width: 3px;
      height: 400px;
      background-color: hsl(0, 0%, 85%);
    }

    .btns{
        display: flex;
        gap: 20px;
        padding: 20px;
        width: 100%;
        border-top: 2px outset  rgb(255, 208, 208);
        position: relative;
        bottom: 0;
    }
    /* .btns button{
        width:70px  !important;
    } */
    .btns button:first-child{
        background: rgb(102, 28, 28) !important;
    }

    .btns button:last-child{
        background: #1b1212 !important;
    }

</style>
