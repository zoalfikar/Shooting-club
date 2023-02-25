<template>
    <div class="wrapper">
        <div class="title">
        </div>
        <div class="container">
            <dir class="nav-links">
                <v-btn depressed   class="naveB"  @click="showFacilityNameForm()">اسم المنشأة</v-btn>
                <v-btn depressed   class="naveB"  @click="showLogoForm()">الشعار</v-btn>
            </dir>
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
   
</style>
