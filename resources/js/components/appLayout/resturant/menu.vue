<template>
<div class="menu-wraper">
    <button class="orderDone" @click="takeOrder">تم!</button>
    <div class="RMioptions">
        <button class="resetOrder">إعادة الطلب</button>
        <button class="rollbackLastOrder">تراجع</button>
        <button class="cancelOrder">إلغاء</button>
    </div>
    <div class="r-menu-navigation">
        <div  class="display-all-section"><v-btn tile >عرض الكل</v-btn ></div>
        <div v-for="(section) in menuItems"  v-bind:key="section.id" class="section-nav"><v-btn tile >{{section.name}}</v-btn ></div>
    </div>
    <div class="resturant-menu d-flex flex-row flex-wrap justify-content-center">
        <div v-for="(section) in menuItems"
         v-bind:key="section.id"
         :id="section.id"
         class="col">
            <div class="menu-section" v-if="section.options == 'resturant' || section.options == 'both'">
                <center><h1>{{section.name}}</h1></center>
                <div v-if="!section.items.length" style="text-align: center;">لاتوجد عناصر في هذه القائمة</div>
                <div v-if="!section.items.length" class="menu-section-list" style="visibility: hidden !important;"> 
                    <div class="menu-section-list-item" >
                        <input type="hidden" value="-1" >
                        <input disabled type="checkbox" class=" form-check-input resturant-m-item-checkBox" name="chosen">
                        <div for="" :class="'resturant-m-item'">اسم العنصر</div>
                        <div :class="'resturant-m-item-info'" style="visibility: hidden;">
                           السعر&nbsp;ل.س &nbsp;&nbsp; / &nbsp;&nbsp;  <i>الواحدة&nbsp;</i> 
                        </div> 
                        <div class="resturant-m-item-quantity">
                            <button  class="  decrement-btn  "><i class='fa-solid fa-minus'></i></button>
                            <input type="number" name="quantity"  class=" qty-input text-center" min="1" >
                            <button  class=" increment-btn  "><i class='fa-solid fa-plus'></i></button>
                        </div>
                    </div>
                    
                </div>
                <div v-for="(item) in section.items" 
                v-bind:key="item.id"
                class="menu-section-list">
                    <div class="menu-section-list-item" :style="`opacity: ${!item.active ? 0.7 : 1}`" >
                        <input id="id" type="hidden" :value="item.id" >
                        <input type="checkbox" class=" form-check-input resturant-m-item-checkBox"   :disabled="!item.active ? true : false " name="chosen" @click="checkBoxClicked">
                        <div for="" :class="'resturant-m-item'" @click="itemClicked">{{item.title}}</div>
                        <div :class="'resturant-m-item-info'">
                            {{item.price}}&nbsp;ل.س &nbsp;&nbsp; / &nbsp;&nbsp;  <i>{{item.unit}}&nbsp;</i> 
                        </div> 
                        <div class="resturant-m-item-quantity">
                            <button  class="  decrement-btn  " @click="decrementBtnClicked"><i class='fa-solid fa-minus'></i></button>
                            <input type="number" name="quantity"  class=" qty-input text-center" min="0" :step="item.pace">
                            <button  class=" increment-btn  " @click="incrementBtnClicked"><i class='fa-solid fa-plus'></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</template>

<script>
import store from '../../../store';

    export default {
        data (){
            return {
                momento:[]
            }
        },
        computed:{
            menuItems:()=> store.state.menuItems,
            currentTable:()=> store.state.currentTable,
            now() {
                return Date.now()
            }
        },
        methods:{
            itemClicked:function (e) {
                $(e.target).closest('.menu-section-list-item').find('.resturant-m-item-checkBox').click();
            },
            checkBoxClicked:function (e) {
                if($(e.target).prop("checked")) {
                    $(e.target).closest('.menu-section-list-item').find('.resturant-m-item-quantity').css('visibility','visible');
                    $(e.target).closest('.menu-section-list-item').find('.resturant-m-item-quantity .qty-input').val(1);
                   this.momento.push(e)
                } else {
                    $(e.target).closest('.menu-section-list-item').find('.resturant-m-item-quantity').css('visibility','hidden');
                    $(e.target).closest('.menu-section-list-item').find('.resturant-m-item-quantity .qty-input').val('');
                }
            },
            incrementBtnClicked:function (e) {
                var inc_value=$(e.target).closest('.resturant-m-item-quantity').find('.qty-input').val();
                var pace = $(e.target).closest('.resturant-m-item-quantity').find('.qty-input').attr("step");
                var value=parseInt(inc_value,10);
                value= isNaN(value) ? 0 : value ;
                value+=parseInt(pace,10);
                value= value < 0 ? 0 : value ;
                $(e.target).closest('.resturant-m-item-quantity').find('.qty-input').val(value);
            },
            decrementBtnClicked:function (e) {
                var dec_value=$(e.target).closest('.resturant-m-item-quantity').find('.qty-input').val();
                var pace = $(e.target).closest('.resturant-m-item-quantity').find('.qty-input').attr("step");
                var value=parseInt(dec_value,10);
                value= isNaN(value) ? 0 : value ;

                value-=parseInt(pace,10);
                value= value < 0 ? 0 : value ;
                $(e.target).closest('.resturant-m-item-quantity').find('.qty-input').val(value);
            },
            takeOrder:function () {
                var newOrders = []
                $( ".menu-section-list-item" ).each(function( index ) {
                    if ($(this).children(".resturant-m-item-checkBox" ).prop("checked")==true) {
                        var order = {}
                        order.id = $(this).children("#id").val();
                        order.quantity = $(this).children(".resturant-m-item-quantity").find(".qty-input").val();
                        newOrders.push(order)
                        
                    }
                });
                store.dispatch("saveOrders",{"tableNumber": this.currentTable ,"orders":newOrders })
            }
        },
        watch: {
            menuItems:{
                handler:function (newVal, oldVal) {
                },
                deep:true
            }
        },
        mounted : function()
        {
            $('.display-all-section').css("margin-top",'-4px');
            const RWMenu = document.querySelector(".menu-wraper");
            var oldRWMenuDisplay = getComputedStyle(RWMenu).display
            var currentRWMenuDisplay ;
            var momento =[]
            const REMenuMutationCallback = (mutationsList) => {
                for (const mutation of mutationsList) {
                    if (mutation.attributeName == "style")
                    {
                        currentRWMenuDisplay = getComputedStyle(RWMenu).display;
                        if (oldRWMenuDisplay == "none" && currentRWMenuDisplay == "block") {
                            $(".resturant-menu").toggleClass("resturant-menu-show");
                            $(".resetOrder").toggleClass("show-RMOptions-buttun");
                            $(".rollbackLastOrder").toggleClass("show-RMOptions-buttun");
                            $(".cancelOrder").toggleClass("show-RMOptions-buttun");
                            $(".orderDone").toggleClass("show-order-done-buttun");
                            setTimeout(() => {
                            $(".resturant-menu").toggleClass("resturant-menu-show");
                                $(".orderDone").toggleClass("show-order-done-buttun");
                                $(".orderDone").toggleClass("button-float");
                                $(".resetOrder").toggleClass("show-RMOptions-buttun");
                                $(".rollbackLastOrder").toggleClass("show-RMOptions-buttun");
                                $(".cancelOrder").toggleClass("show-RMOptions-buttun");
                            }, 1300);
                            oldRWMenuDisplay = 'block';
                        }
                        if (oldRWMenuDisplay == "block" && currentRWMenuDisplay == "none") {
                            oldRWMenuDisplay = 'none'
                        }
                    }

                }
            }
            const REMObserver = new MutationObserver(REMenuMutationCallback)
            REMObserver.observe(RWMenu, { attributes: true })
            function closeRMenu(){
                $(".resturant-menu").toggleClass("resturant-menu-hide");
                $(".orderDone").toggleClass("button-float");
                $(".orderDone").toggleClass("hide-order-done-buttun");
                $(".resetOrder").toggleClass("hide-RMOptions-buttun");
                $(".rollbackLastOrder").toggleClass("hide-RMOptions-buttun");
                $(".cancelOrder").toggleClass("hide-RMOptions-buttun");
                setTimeout(() => {
                    $(".resturant-menu").toggleClass("resturant-menu-hide");
                    $(".orderDone").toggleClass("hide-order-done-buttun");
                    $(".resetOrder").toggleClass("hide-RMOptions-buttun");
                    $(".rollbackLastOrder").toggleClass("hide-RMOptions-buttun");
                    $(".cancelOrder").toggleClass("hide-RMOptions-buttun");
                    RWMenu.style.display='none';
                }, 700);
            }
            $(".orderDone").click(function (e) {
                closeRMenu()
            });
            $(".cancelOrder").click(function (e) {
                closeRMenu()
            });
            $(".resetOrder").click(function (e) {
                $('.resturant-m-item-checkBox').prop("checked",false);
                $('.resturant-m-item-quantity').css('visibility','hidden');
                $('.resturant-m-item-quantity').val('');
            });
            $(".rollbackLastOrder").click(function (e) {
               var ev = momento.pop();
               if (ev) {
                    $(ev.target).closest('.menu-section-list-item').find('.resturant-m-item-checkBox').click()
               }
            });
            $('.section-nav').click(function (e) {
                e.preventDefault();
                $('.display-all-section').css("margin-top",'0');
                $('.section-nav').css("margin-top",'0');
                $(this).css("margin-top",'-4px');
                var clicked = $(this).children( "button" ).children("span").text();
                $('.col ').css("display","none");
                $( ".col" ).filter(function(  ) {
                    return  $( this ).children('.menu-section').children('center').children('h1').text()===clicked;
                }).css( "display", "block" );

            });
            $('.display-all-section').click(function (e) {
                e.preventDefault();
                $('.section-nav').css("margin-top",'0');
                $(this).css("margin-top",'-4px');
                $('.col ').css("display","block");
            });
        }
    }
</script>

<style>
@keyframes button-float {
    0%{transform:translateY(3px)  }
    50%{transform:translateY(-2px) }
    100%{transform:translateY(3px) }
}
.button-float{
    animation:button-float 2s ease-in-out infinite;
    animation-play-state: running;

}
@keyframes show-order-done-buttun {
    0%{transform:translateX(100%)  }
    100%{transform:translateX(0); transform:translateY(3px)}
}
.show-order-done-buttun{
    animation-name: show-order-done-buttun  ;
    animation-duration: 0.7s;
    animation-fill-mode: forwards;
}
@keyframes hide-order-done-buttun {
    0%{transform:translateX(0)  }
    100%{transform:translateX(-100vw)}
}
.hide-order-done-buttun{
    animation-name: hide-order-done-buttun  ;
    animation-duration: 0.7s;
    animation-play-state: running !important;
}
.orderDone{
    position: fixed;
    border-radius: 100%;
    top:10px;
    right: 23px;
    width: 150px;
    height: 150px;
    background-color: rgb(75, 75, 41);
    z-index:10000;
    font-size: 40px;
}
.orderDone:hover{
    animation-play-state: paused;
    background-color: rgb(75, 75, 41,70%);
}
.orderDone:active{
    background-color: rgba(228, 228, 82, 0.7);

}
.RMioptions{
    position: fixed;
    background-color: rgb(0, 0, 0 ,0%);
    left: 23px;
    top:10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-content: center;
    gap: 20px;
    z-index:10000;
    height: max-content;
    width: max-content;
}
@keyframes show-RMOptions-buttun {
    0%{transform:translateY(100vh);  }
    100%{transform:translateY(0);}
}
@keyframes hide-RMOptions-buttun {
    0%{transform:translateY(0);  }
    100%{transform:translateY(-100vh);}
}
.show-RMOptions-buttun{
    animation-name: show-RMOptions-buttun ;
    animation-fill-mode: forwards;
}
.hide-RMOptions-buttun{
    animation-name: hide-RMOptions-buttun ;
    animation-duration: 0.7s !important;
}
.resetOrder,.rollbackLastOrder,.cancelOrder{
    border-radius: 5%;
    width: 150px;
    height: 50px;
    font-size: 30px;
    background-color: rgb(75, 75, 41);
}
.resetOrder{
    animation-duration: 0.7s;

}
.rollbackLastOrder{
    animation-duration: 1s;
}
.cancelOrder{
    animation-duration: 1.3s;
}
.resetOrder:hover,.rollbackLastOrder:hover,.cancelOrder:hover{
    background-color: rgb(75, 75, 41,70%);
}
.resetOrder:active,.rollbackLastOrder:active,.cancelOrder:active{
    background-color: rgba(228, 228, 82, 0.7);
}

.menu-wraper{
    display: none;
    position: fixed;
    background-color: rgba(0, 0, 0, 10%);
    width: 100vw;
    height: 100vh;
    top: 0px;
    left: 0px;
    z-index: 9999;
}
@keyframes resturant-menu-show {
    from{transform: translateY(-100vh);}
    to{transform: translateY(0);}
}
.r-menu-navigation{
    padding-top: 10px;
    padding-bottom: 10px;
    display: flex;
    flex-grow :1;
    background-color: rgb(75, 75, 41);
    position: relative;
    width: 1100px;
    border: 2px outset white;
    margin: auto;
    gap: 2px;
}
.r-menu-navigation .v-btn{
    color: white !important;
    background-color: rgb(109, 109, 55) !important;
}
.resturant-menu-show{
    animation-name:  resturant-menu-show  ;
    animation-duration: 0.7s;
    animation-fill-mode: forwards;
}
@keyframes resturant-menu-hide {
    from{transform: translateY(0);}
    to{transform: translateY(100vh);}
}
.resturant-menu-hide{
    animation-name:  resturant-menu-hide  ;
    animation-duration: 0.7s;
}
.resturant-menu{
    background-color: rgb(75, 75, 41);
    position: relative;
    overflow-y: auto !important;
    width: 1100px;
    height: 100vh;
    border: 2px outset white;
    margin: auto;
}
::-webkit-scrollbar {
        width: 10px;
        border-radius: 10px;

    }


::-webkit-scrollbar-track {
    background: rgb(75, 75, 41 / 90%);
    border-radius: 10px;

}


::-webkit-scrollbar-thumb {
    size: 10px;
    border-radius: 10px;
    background-color: #ad8181;
}


::-webkit-scrollbar-thumb:hover {
    background:  rgb(204, 204, 204);
}
.menu-section{
    border: 2px outset rgb(139, 139, 139);
    /* padding: 20px; */
    width:max-content;

    min-height: 500px;
}
.menu-section-list{
    display: block;
    width:max-content;
}
.menu-section .menu-section-list-item{
    position: relative;
    width:max-content;
    display :flex;
    flex-direction: row;
    margin: 1rem;
    border-bottom: 2px groove rgb(139, 139, 139);
    padding-bottom: 1rem;

}
.resturant-m-item-checkBox , .resturant-m-item ,.resturant-m-item-quantity{
    margin-right: 10px;
    align-self: center !important;
    cursor: pointer;
}

.resturant-m-item{

    width: 120px !important;
    overflow-x: auto;
    font-size: large;
}
.resturant-m-item-quantity{
    display: flex;
    visibility: hidden;
    float: left;
}
.resturant-m-item-info{
    display: flex;
    align-items: center;
    justify-content: center;
}
.resturant-m-item-info p{
    display: block;
}
.resturant-m-item-quantity input[type=text]{
    width:40px;
    height:40px;
    background-color: rgb(224, 224, 224);

}
.resturant-m-item-quantity input[type=number]{
    width:40px;
    height:40px;
    background-color: rgb(224, 224, 224);

}
.resturant-m-item-quantity input[type=number]::-webkit-inner-spin-button,
.resturant-m-item-quantity input[type=number]::-webkit-inner-spin-button
{
appearance: none;

}
.resturant-m-item-quantity button{
    background-color: rgb(124, 80, 80);
    width:40px ;
    height:40px ;
    font-size: 10px;
}
.resturant-m-item-quantity button:first-child{
    border-radius: 0 100% 100% 0;
}
.resturant-m-item-quantity button:last-child{
    /* float: left; */
    border-radius: 100% 0 0 100%  ;

}
@media only screen and (max-device-width: 1024px) and (orientation:landscape) {
    .menu-wraper{
        display: none;
        position: fixed;
        background-color: rgba(0, 0, 0, 10%);
        width:85vw;
        height: 100vh;
        top: 0px;
        left: 0px;
        z-index: 9999;
    }
    .RMioptions{
        position: fixed;
        background-color: rgb(0, 0, 0 ,0%);
        right: 23px;
        top:180px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        gap: 20px;
        z-index:10000;
        height: max-content;
        width: max-content;
    }
}
</style>
