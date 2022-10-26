<template>
    <div class="board-modal">
        <div class="board-modal-content">
            <div class="modal-title">
                <center><h1>رقم الطاولة</h1> </center>
            </div>
            <div class="modal-navigate">
                <button  class="naveB" @click="getOrders();">الطلبات</button>
                <button class="naveB"  @click="getStatus()">الحالة</button>
                <div class="navunderline"></div>
            </div>
            <div class="modal-navigation-content">
                <router-view/>
            </div>
            <div class="btns">
                <button @click="done">
                    تم!
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import router from "../../../routes";
export default {
  data () {
    return {
    }
  },
  methods:{
        animatNavAnderline:()=>{
            // console.log(event.target);
            // const naveT = document.querySelector(".naveT")
            // underline.style.left = naveT.getBoundingClientRect().left
            // underline.style.top = event.target.getBoundingClientRect().top
            // underline.style.top = event.target.getBoundingClientRect().bottom
            // console.log(underline);
            // console.log(naveT);
            // console.log(underline.style.right);
            // console.log(naveT.getBoundingClientRect().right);
            // console.log(underline.style.width);
            // console.log(naveT.getBoundingClientRect().width);
        },
        done : () =>{
            document.querySelector(".board-modal").style.display = "none" ;
        },
        getOrders:()=>{
            router.push({
                name:"orders",
            });
        },
        getStatus:()=>{
            // var copy = document.querySelector(".modal-navigation-content").cloneNode(true);
            // console.log(copy);
            // copy.classList.add(".modal-navigation-conten-copy");
            // // copy.innerHTML=document.querySelector(".modal-navigation-content").innerHTML;
            // copy.style.position="absolute";
            // copy.style.width=document.querySelector(".modal-navigation-content").getBoundingClientRect().width;
            // copy.style.left=document.querySelector(".modal-navigation-content").getBoundingClientRect().left;
            // copy.style.top=document.querySelector(".modal-navigation-content").getBoundingClientRect().top;
            // // copy.classList.add("shift-center-left");
            // // document.querySelector(".modal-navigation-content").style.transform="translateX(-100%)";
            // document.querySelector(".modal-navigation-content").after(copy)
            // document.querySelector(".modal-navigation-content").style.display="none";
            // // document.querySelector(".board-modal-content").appendChild(copy);
            // // document.querySelector(".modal-navigation-content").classList.add("shift-right-center") ;
            // document.querySelector(".modal-navigation-content").addEventListener("animationend",()=>{
            //     document.querySelector(".modal-navigation-content").classList.remove("shift-right-center") ;
            // }) ;
            router.push({
                name:"info",
            });
        }

  },
  mounted : function()
    {
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
                    }
                    if (oldModalDisplay == "block" && currentModalDisplay == "none") {
                        underline.style.width = '0';
                        oldModalDisplay = 'none'
                    }
                }

            }
        }
        const observer = new MutationObserver(mutationCallback)
        observer.observe(modal, { attributes: true })

        for (let i = 0; i < navButtuns.length; i++) {
            navButtuns[i].addEventListener("click" , ()=>{
                underline.style.left = event.target.offsetLeft
                underline.style.width = event.target.getBoundingClientRect().width
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
    .board-modal{
        display :none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999999;
        background-color: rgb(0, 0, 0,45%);
        overflow: auto;
        padding-top: 127px;
    }
    .board-modal-content{
        overflow-x: hidden;
        color: aliceblue;
        margin: auto;
        width: 750px;
        background-color: rgb(102, 102, 102);
        min-height: 400px;
        border-radius: 13px;
        position: relative;
    }
    .modal-title{
        padding: 15px;
        padding-bottom: 10px;
    }
    .modal-navigate{
        position: relative;
        display: flex;
        padding-right: 20px;
        flex-direction: row;
        gap: 25px;
        border-bottom: 2px solid rgb(255, 208, 208);
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
        color: unset;
    }
    @keyframes shift-center-left {
        from{transform: translateX(0);}
        to{transform: translateX(100%);}
    }
    @keyframes shift-right-center {
        from{transform: translateX(-100%);}
        to{transform: translateX(0);}
    }
    @keyframes shift-center-right {
        from{transform: translateX(0);}
        to{transform: translateX(-100%);}
    }
    @keyframes shift-left-center {
        from{transform: translateX(100%);}
        to{transform: translateX(0);}
    }
    .shift-right-center{
        animation: shift-right-center ;
        animation-duration: 0.3s;
        animation-fill-mode: forwards;
    }
    .shift-center-left{
        animation: shift-center-left ;
        animation-duration: 0.3s;
        animation-fill-mode: forwards;
    }
    .shift-left-center{
        animation: shift-left-center ;
        animation-duration: 0.3s;
        animation-fill-mode: forwards;
    }
    .shift-center-right{
        animation: shift-center-right ;
        animation-duration: 0.3s;
        animation-fill-mode: forwards;
    }
    .modal-navigation-content{
        position: relative;
        overflow-x: hidden;
        clip-path: inset(0 0 0 0);
    }
    /* .modal-navigation-content-copy{
        overflow: hidden;
    } */

    .btns{
        padding: 20px;
        width: 100%;
        border-top: 2px solid rgb(255, 208, 208);
        position: absolute;
        bottom: 0;
    }

    @keyframes animat-alter-modal {
        0%{transform: scale(1);}
        50%{transform: scale(1.03);}
        100%{transform: scale(1);}
    }
    @keyframes animat-show-modal {
        from{transform: scale(0);}
        to{transform: scale(1);}
    }
    .animat-alter-modal{
        animation: animat-alter-modal;
        animation-duration: 0.4s;
        animation-timing-function: ease-in-out;
    }
    .animat-show-modal{
        animation: animat-show-modal;
        animation-duration: 0.4s;
        animation-timing-function: ease-in-out;
    }
</style>
