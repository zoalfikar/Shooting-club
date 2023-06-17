<template>
    <div class="Image-container">
        <div class="options">
            <button @click="saveImage" class="btn btn-dark">حفظ</button>
            <button class="btn btn-dark" onclick="document.querySelector('input[type=file]').click()">اختيار صورة</button>
            <input style="visibility: hidden;" class="input" type="file" accept="image/*" @change="setImage">
        </div>
        <img src="" alt="لم يتم تحديد صورة" class="" @load="setCroper">
    </div>
</template>

<script>
import axios from 'axios';
import Cropper from 'cropperjs';
import './cropper.css';
export default {
    data:function(){
      return{
            cropper:null,
        }
    },
    computed:{
        img:function(){return this.$el.querySelector('img')},
    },
    methods:{
      setCroper:function(e){
            this.cropper = new Cropper(e.target, {
                aspectRatio: 1 / 1
            });

      },
      setImage:function(e){
        this.img.src = URL.createObjectURL(e.target.files[e.target.files.length - 1]);
      },
      saveImage:function(){
            this.cropper.getCroppedCanvas().toBlob((blob) => {
                const formData = new FormData();
                formData.append('logo',blob,'logo.png');
                axios.post('/save-logo',formData).then((res)=>{
                    if (res.data.done) {
                        window.location.replace('/setting')
                    }
                })
            }, 'image/png');
        }
    },
    mounted:function(){

    }
}
</script>

<style scoped>
    .image-container{
        max-width: 600px;
        max-height: 600px;
    }
    .options{
        padding: 25px;
        display:flex;
        gap:40px;
    }
</style>
