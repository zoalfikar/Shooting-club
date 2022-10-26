<template>
  <div class="modal-grid">
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
</template>

<script>
export default {

}
</script>

<style scoped>
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
</style>
