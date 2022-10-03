<template>
    <aside :class="`${is_expanded && 'is_expanded'}`">
        <div class="logo">
            <img :src="`${src}`" alt="" class="logo-image">
        </div>
        <div class="menu-toggle-wrap">
            <v-btn icon class="menu-toggle text-white" @click="toggleMenu">
                <v-icon class=" toggle">
                     mdi-chevron-double-left
                </v-icon>
            </v-btn>
        </div>
        <div class="menu">
        <div class="menu-item-itemChild">
            <div class="menu-item"  @click="showItemChildren($event.target)">
                <div class="item-icon">
                    <i class="fa fa-home fa-2x" aria-hidden="true"></i>
                </div>
                <span class="item-text"> <span id="test">الرئيسية</span></span>
            </div>
            <div class="item-children">
                <div class="item-child">
                    <span>+</span><span>&nbsp;&nbsp;&nbsp;<a href="">فرع أول</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع ثاني</a></span>
                </div>
            </div>
        </div>
        <div class="menu-item-itemChild">
            <div class="menu-item" @click="showItemChildren($event.target)">
                <div class="item-icon">
                    <i class="fa fa-calendar fa-2x" aria-hidden="true"></i>
                </div>
                <span class="item-text"> <span>الحجوزات</span></span>
            </div>
            <div class="item-children" @click="showItemChildren($event.target)">
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع أول</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع ثاني</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 3</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 4</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 5</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 6</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 7</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 8</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 9</a></span>
                </div>
            </div>
        </div>
        <div class="menu-item-itemChild">
            <div class="menu-item"  @click="showItemChildren($event.target)">
                <div class="item-icon">
                    <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                </div>
                <span class="item-text"> <span>الطلبات</span></span>
            </div>
            <div class="item-children ">
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع أول</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع ثاني</a></span>
                </div>
            </div>
        </div>
        <div class="menu-item-itemChild">
            <div class="menu-item"  @click="showItemChildren($event.target)">
                <div class="item-icon">
                    <i class="fa fa-restaurant fa-2x" aria-hidden="true"></i>
                </div>
                <span class="item-text"> <span>الطاولات</span></span>
            </div>
            <div class="item-children ">
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a href="">عرض</a></span>
                </div>
                <div class="item-child">
                    <span>+</span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/dev1'">طاولة جديدة</a></span>
                </div>
            </div>
        </div>
        </div>
    </aside>
</template>

<script>
import { ref } from 'vue';

if (!sessionStorage.expanded) {
    sessionStorage.setItem('expanded',false)
}
const is_expanded = ref((sessionStorage.expanded ==='true'));
const showItemChildren = (e)=>{
    var div = false;
    while (!div) {
        if(e.tagName != "DIV"){
            e = e.parentElement;
        }
        else
        {
            div=true
        }
    }
    if (e.parentElement.lastChild.classList.contains("show-children")) {
       if(is_expanded.value){
            e.parentElement.lastChild.classList.remove("show-children");
        }
    } else {
        e.parentElement.lastChild.classList.add("show-children");
    }

    is_expanded.value = true;
}

const toggleMenu = () => {
    sessionStorage.expanded = !(sessionStorage.expanded ==='true')
    is_expanded.value = (sessionStorage.expanded ==='true');
}
export default {
    props:['src','url'],
    data: function () {
    return {
        is_expanded: is_expanded,
   }
  },
   methods:{
    'toggleMenu':toggleMenu,
    'showItemChildren':showItemChildren

   }
}
</script>
<style  scoped>
    .is_expanded{
        width: var(--sidebar-width);
    }

   aside{
        box-shadow: -2px 0 10px rgb(43, 43, 43);
        display: inline-block;
        background-color: var(--dark);
        color: azure;
        width: calc(2rem + 32px);
        overflow: hidden;
        min-height:  100vh;
        transition: 0.3s ease-in-out;
        @media (max-width:768px) {
            position: fixed;
            z-index: 99;
        }
   }
   .menu-toggle-wrap{
    padding: 1rem;
    width: 100%;
    display: flex;
    justify-content: flex-end;
    position: relative;
    transition: 0.2s ease-out;
   }

   .menu-toggle{
    transition: 0.2s ease-out;
   }
   .menu-toggle:hover{
    color: chartreuse !important;
    transform:translateX(-0.5rem) ;
   }

   .is_expanded .menu-toggle:hover  {
        transform:translateX(0.5rem) ;
    }

   .toggle:hover{
    transition: 0.2s ease-out;
   }
   .is_expanded .toggle  {
        transform: rotate(-180deg) ;
    }
    .menu{
        margin-top: 40px;
    }

    .menu-item{
        position: relative;
        top:0;
        margin:1px;
        padding: 13px;
        display: flex;
        border: 2px solid white;
        transition: top 0.2s ease-in;
    }
    .menu-item:hover{
        cursor: pointer;
        color: chartreuse;
        top:-5px;
        font-size: 0.7rem;
    }

   .item-text  {
        overflow: hidden;
        font-size: 2rem;
        margin-right: 30px;
        transition:font-size 0.2s ease-in ,margin-right 0.2s ease-in ;
   }
   .menu-item:hover .item-text {
        font-size: 1.5rem;
        margin-right: 15px;
   }
   .item-icon  {
        width: 40px;
        display: flex;
        justify-content: center;
        padding-right: 0px;
        padding-top: 8px;
        transition: padding-right 0.2s ease-in;
   }
   .is_expanded .menu-item:hover .item-icon {
        padding-right: 23px;
   }

   .item-children{
        max-height: 0;
        overflow: hidden;
        transition: 0.19s ease-in-out;
   }
   .is_expanded .show-children{
        max-height: 320px;
        transition: 0.6s ease-in-out;
    }
   .item-child{
        padding-right:4rem ;
        overflow: hidden;
        font-size: 18px;
        display: flex;
   }
   .item-child:hover{
    color:chartreuse;
   }
   .item-child:hover a{
    color:chartreuse;
   }
   .item-child:nth-child(n){
    padding-top:10px;
   }
   .item-child:last-child{
    padding-bottom: 10px;
   }

   .logo{
        margin-top: 40px;
        display: flex;
        justify-content: center;
   }
   .logo-image{
        margin: auto;
        max-width: 90%;
        max-height:  90%;
        border-radius: 50%;
   }
   a {
        color:white;
   }
   a:link {
        text-decoration: none;
   }
</style>

