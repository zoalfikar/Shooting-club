<template>
    <div class="board-modal">
        <div class="board-modal-content"><h1>hi i am modal</h1>
        </div>
    </div>
  </template>
<script>
export default {
  data () {
    return {
    }
  },
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
        background-color: rgb(0, 0, 0,35%);
        overflow: auto;
        padding-top: 127px;
    }
    .board-modal-content{
        color: aliceblue;
        margin: auto;
        width: 750px;
        background-color: aquamarine;
        min-height: 400px;
        border-radius: 13px;
    }


</style>
