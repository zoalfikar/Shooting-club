<template>
    <v-app-bar app color="#2F4F4F" dark>
        <div class="links-bar">
            <span :style="`display:${userRole =='salePoint' ?'none':''}`" class="nav-bar-button" @click="setActiveLink(this)" onClick="navigatTo(event,this)" :href="`${url}`+'/resturant'">مطعم</span>
            <div :style="`display:${userRole =='salePoint' ?'none':''}`" class="links-divider"><v-divider vertical></v-divider></div>
            <span class="nav-bar-button" onClick="navigatTo(event,this)" :href="`${url}`+'/sale-points'">نقطة مبيع</span>
            <div class="links-divider"><v-divider vertical></v-divider></div>
            <span class="nav-bar-button">حول البرنامج  &nbsp; <i class="fa fa-circle-question"></i></span>
        </div>
        <h1> {{navbarTitle}}</h1>
        <div class="userInfo"><span>{{ userName }}</span>&nbsp;&nbsp;&nbsp;<span>( {{ role }} )</span></div>
        <v-btn icon id="setting-menu-toggle" data-bs-toggle="collapse" data-bs-target="#setting-menu">
            <v-icon>
                mdi-menu
            </v-icon>
        </v-btn>
        <div class="collapse" id="setting-menu" >
            <li>
                <a :href="`${url}`+'/logout'" onClick="navigatTo(event,this)" class="setting-link logout" @click="logout">  تسجيل خروج  </a><i class="fa fa-sign-out" aria-hidden="true"></i>
            </li>
            <li :style="`display:${userRole !=='acountant' ?'none':''}`">
               <a :href="`${url}`+'/setting'" onClick="navigatTo(event,this)" class="setting-link"> الأعدادات </a><i class="fa fa-cog" aria-hidden="true"></i>
            </li>
        </div>
    </v-app-bar>
</template>
<script>
    export default {
        props:['url','navbarTitle' , 'userName' , 'userRole'],
        data:function(){
            return{
                activeLink:null
            }
        },
        computed:{
            role:function () {
                switch (this.userRole) {
                    case 'acountant':
                        return 'محاسب عام'
                        break;
                    case 'waiter':
                        return 'نادل'
                        break;
                    case 'hallAcountant':
                        return 'محاسب صالة'
                        break;
                    case 'salePoint':
                        return 'محاسب مبيع حر'
                        break;
                    default:
                        break;
                }
            }
        },
        methods:{
            logout:function () {
                window.location.reload();
            },
            setActiveLink:function (Link) {
               this.activeLink=Link;
            }
        },
        mounted : function () {
            document.addEventListener('click', function(event) {
                var settingMenu = document.getElementById('setting-menu');
                var ClickedOnSettimgMenu = settingMenu.contains(event.target);
                if (!ClickedOnSettimgMenu) {
                    settingMenu.classList.remove("show");
                }
            });
            document.querySelectorAll('.nav-bar-button').forEach((e)=>{
                e.addEventListener('click', function(event) {
                    $('.nav-bar-button').removeClass('link-active');
                    event.target.classList.add('link-active');
                });
            })
        }

    }
</script>
<style scoped>
    .links-bar{
        display: flex;
        margin-right: 1.5rem;
        align-items: center;
        height: 80%;
        gap: 1.2rem;
    }
    .setting-link{
        text-decoration:none;
        color:rgb(255, 255, 255)
    }
    .links-bar .nav-bar-button{
        box-sizing: border-box;
        padding: 10px;
        border-radius: 30px;
        cursor: pointer;
    }
    .links-bar .nav-bar-button:hover{
        background-color :rgb(145, 65, 65);
        /* border:2px solid rgb(224, 212, 212); */
    }
    .link-active{
        background-color :rgb(65, 59, 59);
        border:2px solid rgb(224, 212, 212);
    }
    .links-divider{
        height: 40%;
    }
    #setting-menu-toggle{
        margin-left: 22px;
    }
    #setting-menu{
        background-color: rgb(126, 126, 126);
        width: 240px;
        position: absolute;
        top: 44px;
        left:20px;
        color:rgb(255, 255, 255);
        z-index: 9999;
        clip-path: polygon(100% 100%, 100% 100%, 100% 5.25%, 21.88% 5.25%, 17.89% 0%, 13.89% 5.25%, 0% 5.25%, 0% 100%);
    }
    #setting-menu li{
        list-style-type: none;
        padding: 15px;
        padding-left: 18px;
        padding-right: 18px;
        border-bottom: 2px ridge  rgb(255, 255, 255);
    }
    li:first-of-type{
        margin-top: 5px;
    }
    li:last-of-type{
        border-bottom: 0 solid black !important;
    }
    .fa{
        margin-top: 5px;

        float: left;
    }
    h1{
        height: 100%;
        padding-left:40px ;
        padding-right:40px ;
        border-radius: 20px;
        background-color:rgb(12, 77, 71) ;
        margin: auto;
        transform: translateX(2.5rem);
    }
</style>
