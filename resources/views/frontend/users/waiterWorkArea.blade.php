@extends('appLayouts.app')
@section('styles')
<style>
    .app-container{
        display: block !important;
    }
    .wrapper{
        margin: auto;
        margin-top: 20px;
        width: 80%;
        background-color: rgb(88, 88, 88);
        display: grid;
        grid-template-areas:
        'filter filter'
        'waiter halls'
        'tables tables';
        grid-template-columns: 25% 75% ;
        align-items: start;
        color: white;
    }
    .filter{
        grid-area: filter ;
        border-bottom: 2px solid rgba(153, 108, 108 , 0.5);
        display: flex;
        height: 170px;
        flex-grow: 1;
    }
    .filter .waiterFilter , .filter .tablesFilter{
        width: 50%;
    }
    .filter .waiterFilter {
        padding-right:40px; 
        padding-left:40px; 
    }
    #filterName , #filterDate{
        width: 40%;
        margin:auto; 
    }

     .nameFilter, .dateFilter , .waiterNumber{
        margin-top:15px; 
        display: flex;
        align-items: center;
    }
    .nameFilter, .dateFilter{
        gap:20px;
        justify-content: space-between !important;
    }
    .waiterNumber{
        height: 40px;
        gap: 20px;
    }
    .waiter , .hall{
        min-height: 100px;
    }
    .waiter{
        grid-area: waiter ;
        display: block;
        /* min-width: 50px; */
        /* background-color: cadetblue; */
    }
    .waiter select{
        height: 40px;
        background-color: rgb(22, 22, 22);
        width: 90%;
        padding-right: 20px;
        margin: auto;
        margin-top: 15px;
        color: aqua
    }

    .hall{
        border-right: 2px solid rgba(153, 108, 108 , 0.5) ;
        
        grid-area: halls ;
        /* background-color: rgb(0, 76, 78); */
    }
    .tables{
        border-top: 2px solid rgba(218, 208, 208, 0.5) ;
        grid-area: tables ;
        /* background-color: rgb(0, 216, 0); */
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .waiter select{
        display: block;
        /* width: 100%; */
    }
    /* radio */
    .radio {
        position: relative;
        cursor: pointer;
        line-height: 20px;
        font-size: 14px;
        margin: 5px;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .radio:nth-child(2n) {
        background-color: rgba(53, 53, 53, 0.7);
        color:white;
    }
    .radio:nth-child(2n+1) {
        background-color: rgba(34, 25, 25, 0.7);
        color:white;
        
    }
    .radio .label {
        position: relative;
        display: block;
        float: left;
        width: 20px;
        height: 20px;
        border: 2px solid #c8ccd4;
        border-radius: 100%;
        -webkit-tap-highlight-color: transparent;
    }
    .label {
        margin-right: 10px;
    }
    .radio .label:after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        background: #225cff;
        transform: scale(0);
        transition: all 0.2s ease;
        opacity: 0.08;
        pointer-events: none;
    }
    .radio:hover .label:after {
        transform: scale(3.6);
    }
    input[type="radio"]:checked + .label {
        border-color: #225cff;
    }
    input[type="radio"]:checked + .label:after {
        transform: scale(1);
        transition: all 0.2s cubic-bezier(0.35, 0.9, 0.4, 0.9);
        opacity: 1;
    }
    .cntr {
        display: flex;
        gap: 0px;
        flex-wrap: wrap;
        justify-content: space-evenly;
        top: calc(50% - 10px);
        left: 0;
        width: 100%;
        flex-grow: 1;
        margin-bottom: 15px;
    }
    .hidden {
        display: none;
    }
    
    .radio{
        border-radius: 10px;
        padding:10px; 
        width: 160px !important;
        height: 40px !important;
        overflow: hidden  !important;
        white-space: nowrap;
    }
    /* checkbox */
    .checkbox {
        margin: 15px;
        width: 70px;
    }
    
    ul {
        list-style-type: none;
    }
    
    label {
        font-family: Helvetica;
        letter-spacing: 1px;
    }
    
    .checkbox-flip{
        display: none;
    }
    
    .checkbox-flip + label span {
        display: inline-block;
        width: 25px;
        height: 19px;
        margin: 0 5px -4px 0;
    /*layout relationship between check and label*/
    }
    .checkbox-flip + label span:before, .checkbox-flip + label span:after {
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        content: "";
        position: absolute;
        z-index: 1;
        width: 1rem;
        height: 1rem;
        background: transparent;
        border: 2px solid #ff4040;
    }
    .checkbox-flip + label span:after{
        z-index: 0;
        border: none;
    }
    
    .checkbox-flip:checked + label span:before {
        -webkit-transform: rotateY(180deg);
        -moz-transform: rotateY(180deg);
        -ms-transform: rotateY(180deg);
        -o-transform: rotateY(180deg);
        transform: rotateY(180deg);
        background: #ff4040;
    }
    .subtitle{
        width: 100%;
        text-align: center;
        font-size: 20px;
        margin-top: 13px
    }
    .tables .subtitle{
        margin-top: 10px;
    }
    .tables .option{
        width: 100%;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        margin-top: 10px;
        margin-bottom: 20px;
        flex-grow: 1;
    }
    .tables .option .neitherNor , .tables .option .fromTo{
        width: 200px;
    }

    select{
        height: 40px;
        background-color: rgb(22, 22, 22);
        width: 90%;
        padding-right: 20px;
        margin: auto;
        margin-top: 20px;
        color: aqua;
        border-radius:10px; 
    }
    input[type='number']{
        text-align: center;
        width: 60px;
        background: rgb(136, 136, 136);
        border-radius: 10px;
        color: cyan
    }
    input[type='text']{
        height: 40px;
        width: 90%;
        color: cyan;
        background: rgb(114, 114, 105);
        border-radius: 10px;
    }
    button{
        border: 2px solid black;
        border-radius: 10px;
        padding: 5px;
        background: rgba(0, 0, 0, 0.4)
    }
    button:hover{
        background: rgba(0, 0, 0, 0.7)
    }
    button:active{
        color: chartreuse;
        background: rgba(0, 0, 0, 0.7)
    }
    
    
    </style>

@endsection
@section('content')
<div class="wrapper">
    {{-- <form action=""> --}}
        <div class="filter">
            <div class="waiterFilter">
                <div class="subtitle"> فلتر النادل</div>
                <div class="dateFilter">
                    <label for="filterDate">حسب الوقت</label>
                    <select name="filterDate" id="filterDate">
                        <option value="all" selected>الكل</option>
                        <option value="hour">اخر ساعة </option>
                        <option value="day">اخر 24 ساعة</option>
                        <option value="week"> اخر اسبوع</option>
                        <option value="month">اخر شهر</option>
                        <option value="year">اخر سنة</option>
                    </select>
                </div>
                <div class="nameFilter">
                    <label for="filterName">حسب الاسم</label>
                    <input type="text" name="filterName" id="filterName">
                </div>
            </div>
            <div class="tablesFilter">
                <div class="subtitle"> فلتر الطاولات</div>
                <div class="waiterNumber">
                    <label for="waiterNumber">
                        حسب عدد النادلين على كل طاولة
                    </label>
                    <input type="number" name="waiterNumber" id="waiterNumber">
                </div>
            </div>
            
        </div>
        <div class="waiter">
            <div class="subtitle">النادل</div>
            <select name="waiter" id="waiter">
                <option value="-1"  disabled selected>حدد نادل</option>
                @foreach ($waiters as $waiter)
                    <option value="{{$waiter->id}}">{{$waiter->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="hall">
            <div class="subtitle">القاعة</div>
            <div class="cntr">
                @foreach ($halls as $hall)
                    <label for="{{$hall->hallNumber}}" class="radio">
                        <input disabled type="radio" name="hall" value="{{$hall->hallNumber}}"  id="{{$hall->hallNumber}}" class="hidden halls"/>
                        <span class="label"></span>{{$hall->hallName}}
                    </label>
                @endforeach
            </div>
        </div>
        <div class="tables">
            <div class="subtitle">الطاولات</div>
            <div class="option">
                <button id="selectAllTables">تحديد الكل</button>
                <button id="resetAllTables"> إزالة التحدد عن الكل</button>
                <div class="fromTo">
                    <label for="from">من</label><input id="from" type="number">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="to">الى</label><input id="to" type="number">
                </div>
                <div class="neitherNor">
                    <label for="neither">ماعدا</label><input id="neither" type="number">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="nor">الى</label><input id="nor" type="number">
                </div>
            </div>
            <div id="tablesSection" class="tables">
                  
            </div>
        </div>
       
        <button id="submit" class="btn btn-primary">تم</button>
    {{-- </form> --}}
</div>
@endsection


@section('scripts')
    <script>
           
            var allHalls = {{ Js::from($halls) }};
            function init() {
                var currentInforamtion = null;
                var currentHall = null;
                var currentHallTables = [];
                var currentTables = [];
                let tablesSection = document.getElementById("tablesSection");

                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    function initHallRequest(){
                        tablesSection.innerHTML = '';
                        currentTables=[];
                        $('#from').val(null)
                        $('#to').val(null)
                        $('#neither').val(null)
                        $('#nor').val(null)
                    }
                    function initTablesRequest(){
                        tablesSection.innerHTML = '';
                        currentTables=[];
                        $('#from').val(null)
                        $('#to').val(null)
                        $('#neither').val(null)
                        $('#nor').val(null)
                    }
                    function initWaiterRequest(){
                        $('.halls').prop("checked",false)
                        $('#filterName').val('');
                        $('#filterDate').val('all');
                        $('#waiterNumber').val('');
                        tablesSection.innerHTML = '';
                        currentTables=[];
                    }
                    $('#waiter').change(function (e) { 
                        e.preventDefault();
                        initWaiterRequest()
                        $.ajax({
                            type: "get",
                            url: "/get-waiter-hall-tables",
                            data: {
                                "userId": $(this).val()
                            },
                            success: function (response) {
                                if (response.information) {
                                    currentInforamtion = response.information;
                                    $('.halls').filter(function (index) {
                                        $(this).attr("disabled" ,false) 
                                        return  $(this).attr("id") == response.information.hall;
                                    }).click();
                                }
                            }
                        });
                    });
                    $('.halls').click(function (e) { 
                        // e.preventDefault();
                        currentHall = $(this).val();
                        initHallRequest();
                        $.ajax({
                            type: "get",
                            url: `boards/${$(this).val()}`,
                            data: "data",
                            success: function (response) {
                                if (response.tables) {
                                    currentHallTables = response.tables;
                                    $.each(response.tables, function (i, e) { 
                                         var newEl = document.createElement("div");
                                         newEl.classList.add("checkbox");
                                         newEl.innerHTML = 
                                         `
                                        <input class="tables-checkbox checkbox-flip"  type="checkbox" value = "${e.tableNumber}"
                                         id="t${e.tableNumber}"
                                         ${
                                        currentInforamtion ?
                                        currentInforamtion.tables ?
                                        currentInforamtion.hall == currentHall ?
                                        currentInforamtion.tables.includes(String(e.tableNumber))? 'checked' : 'none' 
                                        :'none'
                                        :'none'
                                        :'none'
                                        }/>
                                        <label for="t${e.tableNumber}"><span></span>${e.tableNumber}</label>
                                        `
                                        $(tablesSection).append(newEl);
                                    });
                                }

                            }
                        });
                    });
                    $("#submit").click(function (e) { 
                        e.preventDefault();
                        var tablesToSet = [];
                        $('.tables-checkbox').filter(function (i,e) { 
                             if ($(e).prop("checked")) {
                                tablesToSet.push($(e).val())
                            }
                        })
                        var hallToSet = $("input:radio[name=hall]:checked").val();
                        var user_id = $("#waiter").val();
                        $.ajax({
                            type: "post",
                            url: "/set-user-hall-tables",
                            data: {
                                "user_id":user_id,
                                "hallToSet":hallToSet,
                                "tablesToSet":tablesToSet,
                            },
                            success: function (response) {
                                swal({
                                    text: response.message,
                                    icon:"success",
                                    button: {
                                        text: "حسنا",
                                        value: true,
                                        visible: true,
                                        className: "",
                                        closeModal: true,
                                    },
                                });
                            },
                            error:function (response) {
                                if (response.responseJSON.passwordError) {
                                    if (response.responseJSON.passwordError) {
                                        $("#passwordConfirmeError").html(response.responseJSON.passwordError);
                                        $("#passwordConfirmeError").css("display", "block");
                                    }
                                }
                                if(response.responseJSON.errors){
                                    if (response.responseJSON.errors.name) {
                                        $("#nameError").html(String(response.responseJSON.errors.name[0]).replace('name',' الاسم'));
                                        $("#nameError").css("display", "block");
                                    }
                                    if (response.responseJSON.errors.email) {
                                        $("#emailError").html(String(response.responseJSON.errors.email[0]).replace('email','الايميل'));
                                        $("#emailError").css("display", "block");
                                    }
                                    if (response.responseJSON.errors.role) {
                                        $("#roleError").html(String(response.responseJSON.errors.role[0]).replace('role',' الصلاحيات'));
                                        $("#roleError").css("display", "block");
                                    }
                                    if (response.responseJSON.errors.password) {
                                        $("#passwordError").html(String(response.responseJSON.errors.password).replace('password',' كلمة المرور'));
                                        $("#passwordError").css("display", "block");
                                    }
                                };
                            },
                        });
                    });
                    $('#selectAllTables').click(()=>{
                        $('.tables-checkbox').attr('checked',true);
                    })
                    $('#resetAllTables').click(()=>{
                        $('.tables-checkbox').attr('checked',false);
                    })
                    $('#from').on('input', function(){ 
                        if ($('#to').val()) {
                            var from = parseInt($(this).val()) ;
                            var to = parseInt($('#to').val());
                            var array = [];
                            var condition1 = to >= from ;
                            var condition2 = to <= currentHallTables.length;
                            if (condition1 && condition2) {
                                for (let i = from; i <= to; i++) {
                                    array.push(i)
                                } 
                                $('.tables-checkbox').each(function (i, e) {
                                    if (array.includes(parseInt($(e).val()))) {
                                        $(e).attr('checked',true)
                                    }
                                    else
                                    {
                                        $(e).attr('checked',false)
                                    }
                                });
                            }
                        }
                    });
                    $('#to').on('input', function(){ 
                        if ($('#from').val()) {
                            var to = parseInt($(this).val());
                            var from =  parseInt($('#from').val());
                            var array = [];
                            var condition1 = to >= from ;
                            var condition2 = to <= currentHallTables.length;
                            if (condition1 && condition2) {
                                for (let i = from; i <= to; i++) {
                                    array.push(i)
                                } 
                                $('.tables-checkbox').each(function (i, e) {
                                    if (array.includes(parseInt($(e).val()))) {
                                        $(e).attr('checked',true)
                                    }
                                    else
                                    {
                                        $(e).attr('checked',false)
                                    }
                                });
                            }
                        }
                    });
                    $('#neither').on('input', function(){ 
                        if ($('#nor').val()) {
                            var neither = parseInt($(this).val());
                            var nor =  parseInt($('#nor').val());
                            var array = [];
                            var condition1 = nor >= neither ;
                            var condition2 = nor <= currentHallTables.length;
                            if (condition1 && condition2) {
                                for (let i = neither; i <= nor; i++) {
                                    array.push(i)
                                } 
                                $('.tables-checkbox').each(function (i, e) {
                                    if (array.includes(parseInt($(e).val()))) {
                                        $(e).attr('checked',false)
                                    }
                                    else
                                    {
                                        $(e).attr('checked',true)
                                    }
                                });
                            }
                        }
                    });
                    $('#nor').on('input', function(){ 
                        if ($('#neither').val()) {
                            var nor =  parseInt($(this).val());
                            var neither = parseInt($('#neither').val());
                            var array = [];
                            var condition1 = nor >= neither ;
                            var condition2 = nor <= currentHallTables.length;
                            if (condition1 && condition2) {
                                for (let i = neither; i <= nor; i++) {
                                    array.push(i)
                                } 
                                $('.tables-checkbox').each(function (i, e) {
                                    if (array.includes(parseInt($(e).val()))) {
                                        $(e).attr('checked',false)
                                    }
                                    else
                                    {
                                        $(e).attr('checked',true)
                                    }
                                });
                            }
                        }
                    });
                    $('#filterDate').change(function (e) {
                        $('#waiter').html('');
                        e.preventDefault;
                        $.ajax({
                            type: "get",
                            url: "/get-waiters-by-date",
                            data: {
                                filterDate:$(this).val()
                            },
                            success: function (response) {
                                if (response.waiters) {
                                    $("#waiter").append('<option value=' + (-1) + '> حددد نادل</option>');
                                    for (var i in response.waiters) {
                                        $("#waiter").append('<option value=' + response.waiters[i].id + '> ' + response.waiters[i].name + '</option>');
                                    }
                                }
                            }
                        });
                    })
                    $('#filterName').change(function (e) { 
                        e.preventDefault();
                        $('#waiter').html('');
                        if ($(this).val() == '') $('#filterDate').trigger('change');
                        else $.ajax({
                            type: "get",
                            url: "/get-waiters-by-name",
                            data: {
                                filterName:$(this).val()
                            },
                            success: function (response) {
                                if (response.waiters) {
                                    $("#waiter").append('<option value=' + (-1) + '> حددد نادل</option>');
                                    for (var i in response.waiters) {
                                        $("#waiter").append('<option value=' + response.waiters[i].id + '> ' + response.waiters[i].name + '</option>');
                                    }
                                }
                            }
                        });
                    });
                    $('#waiterNumber').change(function (e) { 
                        e.preventDefault();
                        initTablesRequest();
                        if ($(this).val() == '') $('#filterDate').trigger('change');
                        else{
                            $.ajax({
                            type: "get",
                                url: "/get-tables-by-waiters-number",
                                data: {
                                    hallNumber:currentHall,
                                    waiterNumber:$(this).val()
                                },
                                success: function (response) {
                                    if (response.tables) {
                                        currentHallTables = response.tables;
                                        $.each(response.tables, function (i, e) { 
                                            var newEl = document.createElement("div");
                                            newEl.classList.add("checkbox");
                                            newEl.innerHTML = 
                                            `
                                            <input class="tables-checkbox checkbox-flip"  type="checkbox" value = "${e.tableNumber}"
                                            id="t${e.tableNumber}"
                                            ${
                                            currentInforamtion ?
                                            currentInforamtion.tables ?
                                            currentInforamtion.hall == currentHall ?
                                            currentInforamtion.tables.includes(String(e.tableNumber))? 'checked' : 'none' 
                                            :'none'
                                            :'none'
                                            :'none'
                                            }/>
                                            <label for="t${e.tableNumber}"><span></span>${e.tableNumber}</label>
                                            `
                                            $(tablesSection).append(newEl);
                                        });
                                    }
                                }
                            });
                        }
                    });
                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection
