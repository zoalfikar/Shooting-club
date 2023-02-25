<template>
    <div class="wrapper">
        <div class="title">
            <h1>الاعدادات</h1>
        </div>
        
    </div>
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
        text-decoration:none;
        color:rgb(255, 255, 255)
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
