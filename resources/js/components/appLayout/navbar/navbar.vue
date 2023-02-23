<template>
    <v-app-bar app color="#2F4F4F" dark>
        <div class="links-bar">
            <span class="nav-bar-button" onClick="navigatTo(event,this)" href="/resturant">مطعم</span> 
            <div class="links-divider"><v-divider vertical></v-divider></div>
            <span>نقطة مبيع</span>
            <div class="links-divider"><v-divider vertical></v-divider></div>
            <div>حول البرنامج  &nbsp; <i class="fa fa-circle-question"></i></div>
        </div>
        <h1> {{navbarTitle}}</h1>
        <v-btn icon id="setting-menu-toggle" data-bs-toggle="collapse" data-bs-target="#setting-menu">
            <v-icon>
                mdi-menu
            </v-icon>
        </v-btn>
        <div class="collapse" id="setting-menu" >
            <li>
                  تسجيل خروج <i class="fa fa-sign-out" aria-hidden="true"></i>
            </li>
            <li>
               <a :href="`${url}`+'/show-setting-view'" class="setting-link"> الأعدادات </a><i class="fa fa-cog" aria-hidden="true"></i>
            </li>
        </div>
    </v-app-bar>
</template>
<script>
    export default {
        props:['url','navbarTitle'],
        mounted : function () {
            document.addEventListener('click', function(event) {
                var settingMenu = document.getElementById('setting-menu');
                var ClickedOnSettimgMenu = settingMenu.contains(event.target);
                if (!ClickedOnSettimgMenu) {
                    settingMenu.classList.remove("show");
                }
            });
        }

    }
</script>
<style scoped>
    .links-bar{
        display: flex;
        margin-right: 1.5rem;
        align-items: center;
        height: 80%;
        gap: 1.5rem;
    }
    .setting-link{
        appearance:none;
    }
    .links-bar .nav-bar-button:hover{
        background-color :blue;
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
        margin: auto;
        transform: translateX(2.5rem);
    }
</style>
