<template>
    <div class="wrapper">
        <div class="title">
            <h1>الاعدادات</h1>
        </div>
        <div class="container">
            <div class="nav-links">
                <v-btn depressed   class="naveB"  @click="showFacilityNameForm()">اسم المنشأة</v-btn>
                <v-btn depressed   class="naveB"  @click="showLogoForm()">الشعار</v-btn>
            </div>
            <div class="content">
                <router-view/>
            </div>
        </div>
    </div>
</template>
<script>
import router from '../../../routes';
    export default {
        props:['url'],
        data(){
            return {
                // facilty: this.$parent.$props.navbarTitle
            }
        },
        methods:{
            showFacilityNameForm:function(){
                router.push({
                    name:"facility",
                });
            },
            showLogoForm:function(){
                router.push({
                    name:"logo",
                });
            },
        },
        mounted : function () {
        }

    }
</script>
<style scoped>
    .wrapper{
        min-width: 1000px;
        min-height: 600px;
    }
    .title{
        padding:20px;
        text-align: center;
    }
    .container{
        width:100%;
        min-height: 600px;
        display:grid;
        grid-template-areas: '.nav-links .content';
        grid-auto-columns: 30% 70% ;
    }
    .nav-links{
        padding: 15px;
        padding-top: 50px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
</style>
