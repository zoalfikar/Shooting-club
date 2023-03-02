@extends('appLayouts.app')
@section('styles')
    <style>
        .noSalePoint{
            background-color: red;
            color: white;
            width: 700px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .rapper{}
        .globalFram{
            min-height: 400px;
            position: relative;
        }
        .explanation{
            padding-bottom: 30px;
        }
        .controllButon{
            position: absolute !important;
            bottom: 0;
        }
        #update , #delete {
            opacity: 0.3;
        }
        .edit ,.delete{
            display: none;
        }
    </style>
@endsection

@section('content')
    @if($salePoints == [])
        <div class="noSalePoint">
            <h1>
                لاتوجد نقاط بيع
            </h1>
        </div>
    @else
        <form class="w-full max-w-lg" action="" method="POST">
            @csrf
            <div class="globalFram text-gray-700 ">
                <div>
                    <center><h1 class="explanation"></h1></center>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6 space-y-7 wrapper">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 delete">
                        <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="sale-point">
                             نقطة البيع
                        </label>
                        <div class="relative">
                            <select  class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="sale-point" name="salePoint">
                                <option disabled selected value={{-1}}>اختر نقطة البيع</option>
                                @foreach ($salePoints as $salePoint)
                                    <option value={{$salePoint->id}}>نقطة المبيع رقم {{$salePoint->name}}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                                <v-icon color="black" >mdi-chevron-down</v-icon>
                            </div>
                        </div>                    </div>
                    <div class="w-full md:w-1/2 px-3 edit">
                        <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="sale-point">
                            نقطة المبيع
                        </label>
                        <div class="relative">
                            <select  class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="salePoint" name="salePoint">
                                <option disabled selected value={{-1}}>اختر نقطة البيع</option>
                                @foreach ($salePoints as $salePoint)
                                    <option value={{$salePoint->id}}>نقطة المبيع رقم {{$salePoint->name}}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                                <v-icon color="black" >mdi-chevron-down</v-icon>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 edit">
                        <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="max-employees-number">
                          عدد الموظفين
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="max-employees-number" name="maxEmployeesNumber" type="number" min="1" placeholder="عدد الموظفين">
                    </div>
                    <div class="w-full md:w-1/2 px-3 edit">
                        <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="active">
                            الجاهزية
                        </label>
                        <div class="relative">
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="active" name="active">
                            <option  value= 1  >في الخدمة</option>
                            <option value= 0 >خارج الخدمة</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                                <v-icon color="black" >mdi-chevron-down</v-icon>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 edit">
                        <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="name">
                            اسم نقطة المبيع
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="name" name="name" type="text" placeholder=" اسم نقطة المبيع مثال -نقطة المبيع الاولى-" >
                    </div>
                </div>
                <div class="w-full md:w-1/1 px-3 mt-12 space-x-10 space-y-10 controllButon">
                    <button id="update"  class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                        تعديل &nbsp; <i class="fa fa-edit" aria-hidden="true"></i>
                    </button>
                    <button id="delete" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                        حذف &nbsp; <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <button id="done" type="submit" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                        تم !
                    </button>
                </div>
            </div>
        </form>
    @endif

@endsection


@section('scripts')
    <script>
           function init() {
                var updateB = document.getElementById("update");
                var deleteB = document.getElementById("delete");
                var model = document.getElementsByClassName("wrapper");
                var updateMode = null ;
                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $("#update").click(function (e) {
                        e.preventDefault();
                        if (updateMode) {
                            return 0;
                        }
                        updateMode=1;
                        updateB.animate([
                            {opacity: getComputedStyle(updateB).opacity},

                            {opacity:1}
                            ],
                            {
                                duration:300,
                                fill:"forwards",
                            }

                        );
                        deleteB.animate([
                            {opacity: getComputedStyle(deleteB).opacity},

                            {opacity:0.3}
                            ],
                            {
                                duration:300,
                                fill:"forwards",
                            }

                        )
                        model[0].animate(
                            [
                                {clipPath: getComputedStyle(model[0]).clipPath },
                                { clipPath:"inset(0% 0% 100% 0%)" }
                            ]
                            ,
                            {
                                duration:300,
                                fill:"forwards",
                            }
                        )
                        setTimeout(() => {
                            $(".edit").css("display", 'block');
                            $(".delete").css("display", 'none');
                        }, 300);
                        setTimeout(() => {
                            $(".explanation").text("وضع التعديل");
                            model[0].animate(
                                [
                                    {clipPath: getComputedStyle(model[0]).clipPath },
                                    { clipPath:"inset(0% 0% 0% 0%)" }
                                ]
                                ,
                                {
                                    duration:300,
                                    fill:"forwards",
                                }
                            )
                        }, 600);


                    });
                    $("#delete").click(function (e) {
                        e.preventDefault();
                        if (!updateMode) {
                            return 0;
                        }
                        updateMode=0;
                        deleteB.animate([
                            {opacity: getComputedStyle(deleteB).opacity},

                            {opacity:1}
                            ],
                            {
                                duration:300,
                                fill:"forwards",
                            }

                        );
                        updateB.animate([
                            {opacity: getComputedStyle(updateB).opacity},

                            {opacity:0.3}
                            ],
                            {
                                duration:300,
                                fill:"forwards",
                            }

                        )
                        model[0].animate(
                            [
                                {clipPath: getComputedStyle(model[0]).clipPath },
                                { clipPath:"inset(0% 0% 100% 0%)" }
                            ]
                            ,
                            {
                                duration:300,
                                fill:"forwards",
                            }
                        )
                        setTimeout(() => {
                            $(".delete").css("display", 'block');
                            $(".edit").css("display", 'none');
                        }, 300);
                        setTimeout(() => {
                            $(".explanation").text("وضع الحذف");
                            model[0].animate(
                                [
                                    {clipPath: getComputedStyle(model[0]).clipPath },
                                    { clipPath:"inset(0% 0% 0% 0%)" }
                                ]
                                ,
                                {
                                    duration:300,
                                    fill:"forwards",
                                }
                            )
                        }, 600);

                    });

                    $("#done").click(function(e) {
                        e.preventDefault();
                        if (updateMode) {
                            $.ajax({
                                method: "post",
                                url: "/update-sale-point",
                                data: {
                                    'id': $('#salePoint').val(),
                                    'active':  $('#active').val(),
                                    'maxEmployeesNumber':$('#max-employees-number').val(),
                                    'name':$('#name').val(),
                                },
                                success: function (response) {
                                    swal("تم" ,response.message, "success");
                                    $(`#salePoint option[value='${$('#salePoint').val()}']`).text(response.name);
                                    $(`#sale-point option[value='${$('#salePoint').val()}']`).text(response.name);
                                }
                            });
                        } else {
                            $.ajax({
                                method: "post",
                                url: "/delete-sale-point",
                                data: {
                                    'id': $('#sale-point').val(),
                                },
                                success: function (response) {
                                    swal("تم" ,response.message, "success");
                                    // if (response.name == 0) {
                                    //     setTimeout(() => {
                                    //         $(".explanation").text("لاتوجد صالات");
                                    //     }, 300);
                                    //     $(".wrapper").css("display", "none");
                                    //     $(".controllButon").css("display", "none");
                                    // }
                                    var html = ''
                                    response.salePoints.forEach(sp => {
                                        html = html + `<option value=${sp.id}>${sp.name}</option>`
                                    });
                                    $(`#sale-point , #salePoint`).html(html);
                                }
                            });


                        }

                    });
                    $("#salePoint").change(function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: "get",
                            url: "/get-salePoint-data/"+$(this).val(),
                            success: function (response) {
                                $("#max-employees-number").val(response.salePoint.maxEmployeesNumber);
                                $("#active").val(response.salePoint.active);
                                $("#name").val(response.salePoint.name);
                            }
                        });
                    });
                    setTimeout(() => {
                        $("#update").trigger("click");
                    }, 1000);
                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection
