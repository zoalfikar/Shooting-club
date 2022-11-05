<template>
    <div class="info-modal">
        <div class="info-model-content">
            <form id="myform" action="" method="" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">اسم الزبون</label>
                        <input type="text" class="form-control" name="name" placeholder=" (اختياري)">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="slug">معرف خاص</label>
                        <input type="text" class="form-control" name="slug" placeholder="(اجباري)ادخل معرف خاص في حال تشابه الاسماء">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description">معلومات اضافية</label>
                        <textarea name="description"  class="form-control"  style="resize: none;" placeholder="(اختياري)"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <v-btn dark block @click="showOtherTable">اضافة طاولات اخرى</v-btn>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="other-boards" >
                            <v-chip-group column multiple class="pl-2">
                                <v-chip v-for="board in  aviliableBoards" :key="board.tableNumber" filter outlined color="black" text-color="black">{{board.tableNumber}}</v-chip>
                            </v-chip-group>
                        </div>
                    </div>
                    <input @click="$emit('infoDone')"  value="حفظ" class="btn btn-primry saveInfo">
                </div>

                </form>
        </div>
    </div>
</template>

<script>
import store from '../../../store';

export default {
    emits: ['infoDone'],

    computed: {
        aviliableBoards: ()=> store.state.aviliabeBoards,
        },
    methods:{
        showOtherTable:()=>{
            $('.other-boards').toggle("other-boards-hide");
        }
    },
    mounted:function () {
        store.dispatch("getAviliableBoards");
        $('.saveInfo').click(function (e) {
            e.preventDefault();
            $(".info-modal").css("display", "none");
        });

    }

}
</script>

<style>
    .info-modal{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
        background-color: rgb(0, 0, 0,30%);
        overflow: auto;
        padding-top: 30px;
    }
    .info-model-content{
        padding: 20px;
        color: aliceblue;
        margin: auto;
        width: 750px;
        min-height: 400px;
        border-radius: 13px;
        position: relative;
        background-color: rgb(209, 209, 209);
    }
    .other-boards{
        overflow: auto;
        height: 150px;
        border: 2px outset black;
    }
    .other-boards-hide{
        height: 0;
        transition:height 0.2s ease-in-out ;
    }
</style>
