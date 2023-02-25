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
                    <i class="fa fa-home" aria-hidden="true"></i>
                </div>
                <span class="item-text"> <span>الرئيسية</span></span>
            </div>
            <div class="item-children">
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span><span>&nbsp;&nbsp;&nbsp;<a :href="`${url}`+'/users/create'"> إضافة مستخدمين جدد</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/users/all'">تعديل المستخدمين</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-waiter-area-form'">مجال عمل النادل</a></span>
                </div>
            </div>
        </div>
        <div class="menu-item-itemChild">
            <div class="menu-item" @click="showItemChildren($event.target)">
                <div class="item-icon">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                </div>
                <span class="item-text"> <span>الحجوزات</span></span>
            </div>
            <div class="item-children" @click="showItemChildren($event.target)">
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع أول</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع ثاني</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 3</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 4</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 5</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 6</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 7</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a href="">فرع 8</a></span>
                </div>
            </div>
        </div>
        <div class="menu-item-itemChild">
            <div class="menu-item"  @click="showItemChildren($event.target)">
                <div class="item-icon">
                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                </div>
                <span class="item-text"> <span>قائمة الطعام</span></span>
            </div>
            <div class="item-children ">
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-new-section-form'">إضافة نوع جديد</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-edit-sections-form'">تعديل الانواع في القائمة </a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-new-item-form'">إضافة مواد جديدة</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-edit-items-form'">تعديل  قائمة الطعام</a></span>
                </div>
            </div>
        </div>
        <div class="menu-item-itemChild">
            <div class="menu-item"  @click="showItemChildren($event.target)">
                <div class="item-icon">
                    <i class="fa fa-chair" aria-hidden="true"></i>
                </div>
                <span class="item-text"> <span>الطاولات والصالات</span></span>
            </div>
            <div class="item-children ">
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-new-table-form'">طاولة جديدة</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-update-tables-form'">تعديل الطاولات</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-new-hall-form'">صالة جديدة</a></span>
                </div>
                <div class="item-child">
                    <span><i  class="fa fa-angle-double-left" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span><a :href="`${url}`+'/show-update-hall-form'">تعديل الصالات</a></span>
                </div>
            </div>
        </div>
        </div>
    </aside>
</template>

<script>
import { ref } from 'vue';
const sidebarStatus = new CustomEvent('sidebarStatusChanged');
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
    sessionStorage.expanded ='true' ;
    document.dispatchEvent(sidebarStatus);

}


const toggleMenu = () => {
    sessionStorage.expanded = !(sessionStorage.expanded ==='true')
    is_expanded.value = (sessionStorage.expanded ==='true');
    document.dispatchEvent(sidebarStatus);
}
export default {
    props:['src','url'],
    data: function () {
    return {
        is_expanded: is_expanded,
        sidebarStatus:sidebarStatus
   }
  },
   methods:{
    'toggleMenu':toggleMenu,
    'showItemChildren':showItemChildren,
   },
   mounted : function () {
        function initJQuery(){

        }
        $(document).ready( function() {

        });
        var app1 ;
        var currentLink = null;
        var vueMounted = true ;
        var extendedScripts = null ;
        var extendedStyles = null ;
        var divEl = document.createElement('div');
        divEl.innerHTML = "<h1>wait a second!</h1>" ;
        function resetNavVar() {
            extendedScripts = null ;
            extendedStyles = null ;
            divEl.innerHTML = "<h1>wait a second!</h1>" ;
        }
        $("aside .menu a").click(function (e)  {
            e.preventDefault();
            if (currentLink) {
                $(currentLink).parents(".item-child").toggleClass("item-child-clicked");
            }
            currentLink = this;
            $(this).parents(".item-child").toggleClass("item-child-clicked");
            history.pushState("","",$(this).attr("href"));
            $('.app-container').css("visibility", "hidden");
            vueMounted = false ;
            resetNavVar();
            $.ajax({
                type: "get",
                url: $(this).attr("href"),
                success:function (response)
                {
                    if (response.title != null) {
                        document.title = response.title
                    }
                    extendedStyles = response.extendedStyles != null ? response.extendedStyles : null;
                    extendedScripts = response.extendedScripts != null ? response.extendedScripts : null ;
                    divEl.innerHTML = response.content != null ? response.content : null;
                    $('.app-container').html(response.content != null ? response.content : null);
                }
            }).then(()=>{
                vueMount();
            });
        });

        function appContainerLoadFinished() {
            return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        let condition = true;
                        var startTime = Date.now();
                        try {
                            while (condition) {
                                if (Date.now() - startTime > 7000 ) {
                                    condition = false ;
                                    throw new Error("something went rong!");
                                }
                                if ( $('.app-container').html() == divEl.innerHTML ) {
                                    condition = false ;
                                    resolve("vue mounted allowed");
                                }
                                console.log("not now!");
                            }

                        } catch (error) {
                            console.log(error);
                            alert("حدث خطأ ما , استمرت العملية وقت اطول من المتوقع ")
                            location.reload();
                        }
                    }, 100);
                });
        }
        async function vueMount()
        {
            var result = await appContainerLoadFinished();
            console.log(result);
            if (!vueMounted) {
                app1 = new Vue(vueAppOptions);
                app1.$mount('.app-container');
                vueMounted = true ;
                initJQuery();
                $('.extendedStyles').html(extendedStyles);
                $('.extendedScripts').html(extendedScripts);
                $('.app-container').css("visibility", "visible");
                console.log("vue Mounted");
            }
        }
   }
}
</script>
<style  scoped>
    .is_expanded{
        width: var(--sidebar-width);
        overflow-y: auto;
    }


   aside{
        position: fixed;
        top: 59px;
        bottom: 0;
        box-shadow: -2px 0 10px rgb(43, 43, 43);
        display: inline-block;
        background-color: var(--dark);
        color: azure;
        width: calc(2rem + 32px);
        overflow-x: hidden;
        overflow-y: unset;
        /* min-height:  100vh; */
        transition: 0.3s ease-in-out;
        /* @media (max-width:768px) {
            position: fixed;
            z-index: 99;
        } */
   }

    ::-webkit-scrollbar {
        width: 10px;
    }


    ::-webkit-scrollbar-track {
        background: rgb(0 0 0 / 90%);
    }


    ::-webkit-scrollbar-thumb {
        size: 10px;
        border-radius: 10px;
        background-color: #dfdfdf;
    }


    ::-webkit-scrollbar-thumb:hover {
        background:  rgb(204, 204, 204);
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
        margin-top: 15px;
    }

    .menu-item{
        display: grid;
        grid-template-areas: 'item-icon item-text';
        grid-template-columns: calc(2rem + 28px) auto;
        grid-gap:  11px ;
        font-size: 2rem;
        position: relative;
        border: 2px solid white;
        transition: transform 0.2s ease-in-out , background-color 0.2s  ease-in-out;
        z-index: unset;
    }


    .menu-item:hover{
        cursor: pointer;
        color: chartreuse;
        transform: translateY(-5px);
        z-index: 9;
        background-color: var(--dark);
        transition:  background-color 0  ;

    }
    .menu-item:hover .item-text {
        transform: translateX(8px);

   }
   .is_expanded .menu-item:hover .item-icon {
        transform: translateX(-12px);
   }

   .item-text  {
        overflow: hidden;
        white-space:nowrap;
        transition:transform 0.2s ease-in ;
   }
   .is_expanded .item-text{
        white-space:normal;
   }

   .item-icon  {
        display: flex;
        justify-content: center;
        padding-top: 8px;
        padding-bottom: 12px;
        transition: transform 0.2s ease-in;
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

   .item-child:hover .fa-angle-double-left{
        transform:translateX(-6px);
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
   .fa-angle-double-left{
    padding-top: 10px;
    font-size: 11px;
    transition: transform 0.2s ease-in-out;
   }
   .item-child-clicked .fa-angle-double-left{
        transform:translateX(-6px);
        color:chartreuse;
   }
   .item-child-clicked a{
    color:chartreuse;
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

