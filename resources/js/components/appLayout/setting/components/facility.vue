<template>
    <div>
        <input class="input" v-model="facilityName" type="text" name="facility">

        <button class="btn btn-dark" @click="saveName()">حفظ</button>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data:function(){
      return{
        facilityName:null
      }
    },
    methods:{
        saveName:function(){
            axios.post('/save-facility-name' ,{'newName':this.facilityName}).then((res)=>{
                if (res.data.done) {
                    window.location.replace('/setting')
                }
            })
        }
    },
   mounted:function(){
       axios.get('/get-facility-name').then((res)=>{
        this.facilityName = res.data.name;
    })
   }
}
</script>

<style scoped>
input{
    height: 40px;
    padding-right: 20px;
    background-color: bisque;
}
div{
    padding:40px;
    display: flex;
    flex-direction : column;
    gap:40px;
}
</style>
