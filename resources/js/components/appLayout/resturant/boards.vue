<template>
  <div class="container">
    <header class="boards-header">
        <div class="toggle-boards-header"><span><i class="fa fa-angle-double-up"></i></span></div>
        <div class="hall-navigation">
            <div class="navigations-title">
                <h4>الصالة :</h4>
            </div>
            <div class="navigations-links">
                <button value="" class="naviga-link-end"><span href=""><i class="fa fa-angle-right"></i></span></button>
                <button value="1" class="naviga-link" style="background-color: rgb(199, 176, 146)"><span href="">1</span></button>
                <button value="2" class="naviga-link"><span href="">2</span></button>
                <button value="3" class="naviga-link"><span href="">3</span></button>
                <button value="" class="naviga-link-end"><span href=""><i class="fa fa-angle-left"></i></span></button>
            </div>
        </div>
        <div class="current-nav-val">
            <h1>الصالة الاولى</h1>
        </div>
    </header>
    <div class="d-flex flex-row flex-wrap justify-content-center">
        <div  v-for="board in boards" v-bind:key="board.tableNumber" :id="board.tableNumber" :style="`order:${board.order}`"  class="col-lg-3 col-md-4">  <board :status="board.state" :tablenumber="board.tableNumber" :style="`animation-delay: ${board.tableNumber* 0.1}s`"  class="animate-fade-in-down"></board></div>
    </div>
    <board-modal></board-modal>
    <info-modal></info-modal>
</div>
</template>

<script>
    import store from '../../../store';
    export default {

       computed: {
            boards: ()=> store.state.boards,
        },
        methods:{

        },
        mounted: function () {
            $('.naviga-link').click(function (e) {
                e.preventDefault();
                store.dispatch("pringAllBoardsInThisHall",$(this).val())
                //
            });
            $( ".naviga-link" ).first().trigger('click');
        }
    }
</script>

<style scoped >
    /* :root{
    } */
    .container {
        min-width: 700px;
    }
    .boards-header{
        box-sizing: border-box !important;
        position: relative;
        margin-top: 10px;
        padding-top: 10px;
        padding-bottom: 10px;
        display:  flex;
        align-items: center;
        background-color: hsl(120, 73%, 75% , 40%);
        transition: height 10s ease-in-out;
    }
    @keyframes animate-header{
        from{height:unset ;}
        to{height:0 ;}
    }
    .hide-header{
        animation: animate-header 0.3s ease-in-out ;
        animation-fill-mode: forwards;
    }
    .toggle-boards-header{
        right: 10px;
        bottom: 5px;
        position: absolute;
        height: 20px;
        width:  20px;
        transition: transform 0.2s ease-in-out ;
        overflow: visible;
        color:white;
        transform: rotate(0);
    }
    .rotate-toggle-boards-header{
        transform: rotate(180deg);
    }
    /* .boards-header-collapse .toggle-boards-header{
        transform: rotate(180deg);
    } */
    .toggle-boards-header:hover{
        transform: translateY(-4px)
    }
    .rotate-toggle-boards-header.toggle-boards-header:hover{
        color: blue;
        transform: rotate(180deg);
    }

    .hall-navigation{
        overflow: hidden;
        height: inherit;
        align-items: center;
        flex-grow: 1;
        display: flex;
        justify-content: center;
    }
    .current-nav-val{
        overflow: hidden;
        position: relative;
        height: inherit;
        margin-left: 20px;
        font-weight: bold;
    }
    .navigations-links{
        position: relative;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .naviga-link{
        border-radius: 100%;
        background-color: rgb(90, 117, 65);
        color: beige;
        width: 40px;
        height: 40px;
        display: flex;
        transition: transform 0.2s ease-in-out;
    }
    .naviga-link-end{
        border-radius: 20%;
        background-color: rgb(65, 77, 54);
        color: beige;
        width: 40px;
        height: 30px;
        display: flex;
        padding-bottom: 3px;
        transition: transform 0.2s ease-in-out;
    }
    .naviga-link:hover,.naviga-link-end:hover{
        transform: scale(1.2) ;
        cursor: pointer;
    }
    .naviga-link span , .naviga-link-end span{
        margin: auto;
    }
    .navigations-title{
        position: relative;
        overflow: hidden;
        padding-top: 3px;
        margin-left: 10px;
    }
    .d-flex {
        overflow: hidden;
        clip-path: inset(0 0 0 0);
    }
</style>
