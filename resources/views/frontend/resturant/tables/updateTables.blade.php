@extends('appLayouts.app')
@section('styles')
<style>
    /* .noHalls{
        background-color: red;
        color: white;
        width: 700px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    } */



        /* .manyTablesChoice{
            overflow: hidden;
            height: 0px;
        }
        .manyTablesChoice , #cancelManyTables{
            display: none;
        }
        #tables-count , #tablesStateGroup{
            clip-path  : inset(0% 100% 0% 0%)
        } */
         body::before {
            content: "";
            background-image: url("images/resturantTable.jpg");
            background-size: cover;
            opacity: 0.4;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: fixed;
            z-index: -10;
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
        .edit ,.delete ,.both{
            display: none;
        }
</style>

@endsection


@section('content')
    @if (!$hallNumbers)
        <div class="noHalls">
            <h1>
                لاتوجد صالات
            </h1>
        </div>
    @else
    <form class="w-full max-w-lg" action="{{url('add-new-table')}}" method="POST">
        @csrf
        <div class="globalFram text-gray-700 ">
            <div>
                <center><h1 class="explanation"></h1></center>
            </div>
          <div class="flex flex-wrap -mx-3 mb-6 wrapper">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0   delete">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="tables-count">
                 عدد الطاولات
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="tables-count" name="tablesCount" type="number" placeholder="ادخل عدد الطاولات" min="0" max="{{count($tables)}}" value="">
                @error('tableCount')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("table count","عدد الطاولات",$message)}}
                    </p>
                @enderror
                <div id="tablesCountErrore" class="text-red-500 mb-0 text-xl italic errore">
                </div>
            </div>

              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0  edit">
                  <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="table-number">
                  رقم الطاولة
                  </label>
                  <div class="relative">
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="table-number" name="tableNumber">
                        <option disabled selected value={{-1}}>اختر طاولة</option>
                        @foreach ($tables as $table)
                            <option value={{$table->tableNumber}}>الطاولة رقم {{$table->tableNumber}}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                        <v-icon color="black" >mdi-chevron-down</v-icon>
                    </div>
                </div>
                  @error('tableNumber')
                      <p class="text-red-500 text-xl italic">
                          {{str_replace("table number","رقم الطاولة",$message)}}
                      </p>
                  @enderror
                  <div id="tableNumberErrore" class="text-red-500 text-xl italic errore">
                  </div>
              </div>
              <div class="w-full md:w-1/2 px-3 both">
                      <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="hall-number">
                          الصالة
                      </label>
                      <div class="relative">
                          <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="hall-number" name="hallNumber">
                              @foreach ($hallNumbers as $hallNumber)
                                  <option value={{$hallNumber}}  {{$hallNumber == '1'?'selected':''}} >الصالة رقم {{$hallNumber}}</option>
                              @endforeach
                          </select>
                          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                              <v-icon color="black" >mdi-chevron-down</v-icon>
                          </div>
                      </div>
                      @error('hallNumber')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("hall number","رقم الصالة",$message)}}
                          </p>
                      @enderror
                      <div id="hallNumberErrore" class="text-red-500 text-xl italic errore">
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0  delete manyTablesChoice"  style="margin-top: 28px !important">
                    <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="tables-deleted">
                    الطاولات التي سيتم حذفها
                    </label>
                    <div id="tablesDeleted" class="relative">
                        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="tables-deleted" name="tablesDeleted">
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                            <v-icon color="black" >mdi-chevron-down</v-icon>
                        </div>
                    </div>
                    @error('tablesDeleted')
                        <p class="text-red-500 text-xl italic">
                            {{str_replace("tables Deleted"," الطاولات المحذوفة",$message)}}
                        </p>
                    @enderror
                    <div id="tablesDeletedErrore" class="text-red-500 text-xl italic errore">
                    </div>
                </div>
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-4 edit" style="margin-top: 28px !important">
                  <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="max-capacity">
                      السعة القصوى
                  </label>
                  <input value="10" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="max-capacity" name="maxCapacity" type="number" min="1" placeholder="عدد الكراسي">
                  @error('maxCapacity')
                      <p class="text-red-500 text-xl italic">
                          {{str_replace("max capacity","سعة الطاولة",$message)}}
                      </p>
                  @enderror
                  <div id="maxCapacityErrore" class="text-red-500 text-xl italic errore">
                </div>
              </div>
              <div class="w-full md:w-1/2 px-3 mt-4 edit" style="margin-top: 28px !important">
                  <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="active">
                      الجاهزية
                  </label>
                  <div class="relative">
                      <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="active" name="active">
                      <option selected value= 1  selected>في الخدمة</option>
                      <option value= 0 >خارج الخدمة</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                          <v-icon color="black" >mdi-chevron-down</v-icon>
                      </div>
                      @error('active')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("active","الجاهزية",$message)}}
                          </p>
                      @enderror
                      <div id="activeErrore" class="text-red-500 text-xl italic errore">
                    </div>
                  </div>
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
            {{-- <button id="done" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                تم !
            </button> --}}
        </div>
        </div>
      </form>
    @endif

@endsection


@section('scripts')
    <script>
        var allTables = {{ Js::from($tables) }};
        var updatedTables = [] ;
        var deletedTables = [] ;
        var updateB = document.getElementById("update");
        var deleteB = document.getElementById("delete");
        var model = document.getElementsByClassName("wrapper");
        var updateMode = null ;
        function findCurrentTable(){
            var currentTable = parseInt($('#table-number').val());
            return allTables.find((t) => {return t.tableNumber == currentTable})
        }
        $('#table-number').change(function (e) {
            e.preventDefault();
            $("#max-capacity").val(findCurrentTable().maxCapacity);
            $("#active").val(findCurrentTable().active);
        });
        $("#hall-number").change(function() {
            updatedTables = [];
            deletedTables = [];
            $("#tables-count").val(0);
            $("#tables-deleted").html(null);
            var hallNumber = $("#hall-number").val();
            $.ajax({
                type: "get",
                url: "show-update-tables-form",
                data: {
                    'hallNumber': hallNumber,
                    'hallNumberChanged': true
                },
                success: function (response) {
                    allTables=response.tables
                    $("#tables-count").attr("max", allTables.length);
                    $("#table-number option").each(function() {
                        if (parseInt($(this).val())  == -1)
                        $(this).prop("selected", true)
                        else
                        $(this).remove();
                    });
                    for (var i in allTables) {
                        $("#table-number").append('<option value=' + allTables[i].tableNumber + '> الطاولة رقم ' + allTables[i].tableNumber + '</option>');
                    }
                }
            });
        });
        $("#max-capacity").change(function (e) {
            e.preventDefault();
            var table = findCurrentTable();
            var index = updatedTables.findIndex((t) =>  t.tableNumber == table.tableNumber);
            table.maxCapacity=  parseInt($("#max-capacity").val());
            if (index >= 0) {
                updatedTables[index].maxCapacity = table.maxCapacity;
            } else {
                updatedTables.push(table);
            }
        });
        $("#tables-count").change(function (e) {
            e.preventDefault();
            var length =  allTables.length;
            var tablesCount = parseInt($("#tables-count").val());
            $("#tables-deleted").html(null);
            deletedTables=[];
            for (let index = length; index > length - tablesCount; index--) {
                $("#tables-deleted").append(`<option>${index}</option>`);
                deletedTables.push(index);
            }
        });
        $("#active").change(function (e) {
            e.preventDefault();
            var table = findCurrentTable();
            var index = updatedTables.findIndex((t) =>  t.tableNumber == table.tableNumber);
            table.active=  parseInt($("#active").val());
            if (index >= 0) {
                updatedTables[index].active = table.active;
            } else {
                updatedTables.push(table);
            }
        });
        $("#update").click(function (e) {
                        e.preventDefault();
                        if (updateMode == 1) {
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
                            $(".both").css("display", 'block');
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
            if (updateMode == 2) {
                return 0;
            }
            updateMode=2;
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
                $(".both").css("display", 'block');
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
            $(document).ready(function() {


                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $("#done").click(function(e) {
                        e.preventDefault();
                        if (updateMode==1) {
                            $.ajax({
                                method: "post",
                                url: "/update-tables",
                                data: {
                                    'hallNumber': $('#hall-number').val(),
                                    'tables': updatedTables,
                                },
                                success: function (response) {
                                    swal("تم" ,response.message, "success");
                                }
                            });
                        } else {
                            $.ajax({
                                method: "post",
                                url: "/delete-tables",
                                data: {
                                    'hallNumber': $('#hall-number').val(),
                                    'deletedTables':deletedTables,
                                },
                                success: function (response) {
                                    swal("تم" ,response.message, "success");
                                    // if (response.hallNumber == 0) {
                                    //     setTimeout(() => {
                                    //         $(".explanation").text("لاتوجد صالات");
                                    //     }, 300);
                                    //     $(".wrapper").css("display", "none");
                                    //     $(".controllButon").css("display", "none");
                                    // }
                                    // $("#hall-number").val(response.hallNumber);
                                }
                            });


                        }

                    });


            });
    </script>
@endsection
