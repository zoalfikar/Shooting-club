<template>
    <div class="board-modal">
        <div class="board-modal-content">
            <div class="modal-title">
                <center><h1>رقم الطاولة</h1> </center>
            </div>
            <div class="modal-navigate">
                <router-link :to="{name:'home'}">الطلبات</router-link> <button>الحالة</button>
            </div>
            <div class="modal-grid">
                <router-view/>
                <div class="options">
                    <button>أضف طلب</button>
                    <button>حذف طلب</button>
                    <button>تعديل طلب</button>
                </div>
                <div class="display-content">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                            <th scope="col">اسم الطلب</th>
                            <th scope="col">السعر</th>
                            <th scope="col">الكمية</th>
                            <th scope="col">المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>بيبسي</td><td>10 ل.س</td><td>3</td><td>30 ل.س</td>
                            </tr>
                            <tr>
                                <td>فروج</td><td>60 ل.س</td><td>1</td><td>60 ل.س</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btns">
                <button @click="done">
                    تم!
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  data () {
    return {
    }
  },
  methods:{
        done : () =>{
            document.querySelector(".board-modal").style.display = "none" ;
        }

  },
  mounted : function() {
    document.querySelector(".board-modal").addEventListener("click" , ()=>{
        var modal = document.querySelector(".board-modal-content");
        if ( !modal.contains(event.target)) {
            modal.classList.add("animat-alter-modal");
            modal.addEventListener('animationend', () => {
                modal.classList.remove("animat-alter-modal");
            });
        }
    })
  }
}
</script>
<style scoped>
    .board-modal{
        display :none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999999;
        background-color: rgb(0, 0, 0,45%);
        overflow: auto;
        padding-top: 127px;
    }
    .board-modal-content{
        color: aliceblue;
        margin: auto;
        width: 750px;
        background-color: rgb(102, 102, 102);
        min-height: 400px;
        border-radius: 13px;
        position: relative;
    }
    .modal-title{
        padding: 15px;
        padding-bottom: 10px;
    }
    .modal-navigate{
        display: flex;
        padding-right: 20px;
        flex-direction: row;
        gap: 25px;
        border-bottom: 2px solid rgb(255, 208, 208);
        /* row-gap: 10px; */

    }
    .modal-grid{
        padding-left: 15px;
        padding-right: 15px;
        display: grid;
        grid-template-areas: "options display-content" ;
        grid-template-columns: 20% 80%;
    }
    /* .display-content{

    } */
    .options{
        align-items: flex-start;
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 15px;

    }
    .btns{
        padding: 20px;
        width: 100%;
        border-top: 2px solid rgb(255, 208, 208);
        position: absolute;
        bottom: 0;
    }

    @keyframes animat-alter-modal {
        0%{transform: scale(1);}
        50%{transform: scale(1.03);}
        100%{transform: scale(1);}
    }
    @keyframes animat-show-modal {
        from{transform: scale(0);}
        to{transform: scale(1);}
    }
    .animat-alter-modal{
        animation: animat-alter-modal;
        animation-duration: 0.4s;
        animation-timing-function: ease-in-out;
    }
    .animat-show-modal{
        animation: animat-show-modal;
        animation-duration: 0.4s;
        animation-timing-function: ease-in-out;
    }
</style>
