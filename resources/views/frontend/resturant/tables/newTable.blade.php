@extends('appLayouts.app')
@section('styles')
<style>
    .noHalls{
        background-color: red;
        color: white;
        width: 700px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
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

        .manyTablesChoice{
            overflow: hidden;
            height: 0px;
        }
        .manyTablesChoice , #cancelManyTables{
            display: none;
        }
        #tables-count , #tablesStateGroup{
            clip-path  : inset(0% 100% 0% 0%)
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
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-12 md:mb-6 -mt-12 manyTablesChoice">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="tables-count">
                 عدد الطاولات
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="tables-count" name="tablesCount" type="number" placeholder="ادخل عدد الطاولات" min="1" max="{{$maxTablesNumbers}}" value="">
                {{-- @error('tableCount')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("table count","عدد الطاولات",$message)}}
                    </p>
                @enderror --}}
                {{-- <div id="tablesCountErrore" class="text-red-500 mb-0 text-xl italic errore">
                </div> --}}
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 -mt-12 manyTablesChoice">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="tables-state">
                 تخصيص (تغيير القيم الافتراضية)
                </label>
                <div id="tablesStateGroup" class="relative tablesStateGroup">
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="tables-state" name="tablesState">
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                        <v-icon color="black" >mdi-chevron-down</v-icon>
                    </div>
                </div>
                @error('tablesState')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("table state","تخصيص الطاولات",$message)}}
                    </p>
                @enderror
                <div id="tableStateErrore" class="text-red-500 text-xl italic errore">
                </div>
            </div>
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0  defaultChoice">
                  <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="table-number">
                  رقم الطاولة
                  </label>
                  <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="table-number" name="tableNumber" type="number" placeholder="ادخل رقم الطاولة" readonly  value="{{$TableNumber}}">
                  @error('tableNumber')
                      <p class="text-red-500 text-xl italic">
                          {{str_replace("table number","رقم الطاولة",$message)}}
                      </p>
                  @enderror
                  <div id="tableNumberErrore" class="text-red-500 text-xl italic errore">
                  </div>
              </div>
              <div class="w-full md:w-1/2 px-3  defaultChoice">
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
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-4 defaultChoice">
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
              <div class="w-full md:w-1/2 px-3 mt-4 defaultChoice">
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
              <div class="w-full md:w-1/3 px-3 mt-6 defaultChoice">
                  {{-- <button type="submit"  class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                      تم !
                  </button> --}}
                  <button id="addManyTables" class="bg-teal-600 hover:bg-blue-400 text-white font-bold py-2 px-2  border-b-4 border-blue-700 hover:border-blue-500 rounded">
                        أضف عدة طاولات
                    </button>
                    <button id="cancelManyTables" class="bg-red-800 hover:bg-black-200 text-white font-bold py-2 px-4  border-b-4 border-blue-700 hover:border-blue-500 rounded">
                        إلغاء
                    </button>
              </div>

              <div class="w-full md:w-1/3 px-3 mt-6 -mr-3 defaultChoice">
                  <button id="submit" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 mr-3 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    تم !
                </button>
              </div>
          </div>
      </form>
    @endif

@endsection


@section('scripts')
    <script>
            $(document).ready(function() {
                var manyTables = false;
                var ease =Power1.easeInOut;
                var manyTablesArray = [];
                var tableNumberInit = $("#table-number").val();
                var initMaxCapacity = $("#tables-count").attr("max");
                var tablesAlreadyChanged=[];
                var first = true;
                function init() {
                    manyTablesArray=[];
                    $("#tables-state").html(null);
                    var start =  tableNumberInit
                    var end = ( parseInt($("#tables-count").val())+parseInt(tableNumberInit))

                    for (let index = start; index < end; index++) {
                        var t={};
                        t.tableNumber = index;
                        t.hallNumber = parseInt($("#hall-number").val());
                        if (t.tableNumber==tableNumberInit && first) {
                            t.maxCapacity=$("#max-capacity").val();
                            t.active=$("#active").val();
                            first = false;
                            tablesAlreadyChanged.push(t)
                        } else {
                            var index2 = tablesAlreadyChanged.findIndex((v) =>  v.tableNumber == t.tableNumber)
                            if (index2>=0 && tablesAlreadyChanged.length>0) {
                                t.maxCapacity=tablesAlreadyChanged[index2].maxCapacity
                                t.active=tablesAlreadyChanged[index2].active
                            } else {
                                t.maxCapacity = 10;
                                t.active=1;
                            }
                        }
                        manyTablesArray.push(t)
                        $("#tables-state").append(`<option  value="${t.tableNumber}">${t.tableNumber}</option>`);
                    }
                }

                function showSpecificTable(val)
                {
                    var t = manyTablesArray.find((e) => {return e.tableNumber == val})
                    $("#table-number").val(t.tableNumber);
                    $("#hall-number").val(t.hallNumber);
                    $("#max-capacity").val(t.maxCapacity);
                    $("#active").val(t.active);
                }
                function setCapacity(val,val2) {
                    var index = tablesAlreadyChanged.findIndex((v) =>  v.tableNumber == val2);

                    manyTablesArray.map((t) =>{
                        if (t.tableNumber==val2)
                        t.maxCapacity=val;
                        if (index>=0) {
                        tablesAlreadyChanged[index].maxCapacity=val;
                    } else {
                        tablesAlreadyChanged.push(t);
                    }
                    })
                }
                function setActive(val,val2) {
                    var index = tablesAlreadyChanged.findIndex((v) =>  v.tableNumber == val2);
                    manyTablesArray.map((t) =>{
                        if (t.tableNumber==val2)
                        t.active=val;
                    if (index>=0) {
                        tablesAlreadyChanged[index].active=val;
                    } else {
                        tablesAlreadyChanged.push(t);

                    }
                    })
                }

                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                $("#hall-number").change(function() {
                    $("#tables-state").html(null);
                    $("#tables-count").val(null);
                    manyTablesArray=[];
                    var hallNumber = $("#hall-number").val();
                    $.ajax({
                        type: "get",
                        url: "show-new-table-form",
                        data: {
                            'hallNumber': hallNumber,
                            'hallNumberChanged': true
                        },
                        success: function (response) {
                            tableNumberInit=response.TableNumber
                            $("#table-number").val(response.TableNumber);
                            initMaxCapacity = response.maxTablesNumbers;
                            $("#tables-count").attr("max", response.maxTablesNumbers);
                        }
                    });
                });
                $("#submit").click(function (e) {
                    e.preventDefault();
                    $('#tableNumberErrore').text(null);
                    $('#hallNumber').text(null);
                    $('#maxCapacityErrore').text(null);
                    $('#activeErrore').text(null);
                    var hallNumber = $("#hall-number").val();
                    if (!manyTables) {
                        var tableNumber = $("#table-number").val();
                        var maxCapacity = $("#max-capacity").val();
                        var active = $("#active").val();
                        $.ajax({
                            type: "post",
                            url: "add-new-table",
                            data: {
                                'hallNumber': hallNumber,
                                'tableNumber': tableNumber,
                                'maxCapacity': maxCapacity,
                                'active': active,
                            },
                            success: function (response) {
                                swal("تم" ,response.success, "success");
                                $("#table-number").val(response.aviliableTableNumber);
                                tableNumberInit=response.aviliableTableNumber;
                            },
                            error:function (response) {
                                if (response.responseJSON.errors) {
                                    if (response.responseJSON.errors.tableNumber) {

                                        $('#tableNumberErrore').text(String(response.responseJSON.errors.tableNumber[0]).replace('table number','رقم الطاولة'));
                                    }
                                    if (response.responseJSON.errors.hallNumber) {
                                        $('#hallNumberErrore').text(String(response.responseJSON.errors.hallNumber[0]).replace('hall number','رقم الصالة'));
                                    }
                                    if (response.responseJSON.errors.maxCapacity) {
                                        $('#maxCapacityErrore').text(String(response.responseJSON.errors.maxCapacity[0]).replace('hallNumber','رقم الصالة').replace('max capacity','السعة القصوى'));
                                    }
                                    if (response.responseJSON.errors.active) {
                                        $('#activeErrore').text(String(response.responseJSON.errors.active[0]).replace('active','الجاهزية'));
                                    }
                                }

                            }
                        });

                    } else {
                        if (! manyTablesArray.length > 0) {
                            swal({
                                text: "لم يتم إدخال عدد الطاولات",
                                icon:"error",
                                button: {
                                    text: "حسنا",
                                    value: true,
                                    visible: true,
                                    className: "",
                                    closeModal: true,
                                },
                            });
                            return 0;
                            // $('#tablesCountErrore').text("لم يتم تحديد عدد الطاولات");

                        }
                        $.ajax({
                            type: "post",
                            url: "add-many-new-tables",
                            data: {
                                'manyTables': manyTablesArray,
                                'hallNumber': hallNumber,
                            },
                            success: function (response) {
                                swal("تم" ,response.success, "success");
                                $("#tables-state").html(null);
                                $("#tables-count").val(null);
                                manyTablesArray=[];
                                tableNumberInit=response.availableTableNumber;
                            },
                            error:function (response) {
                                if (response.responseJSON.erroreInTable) {
                                var table = response.responseJSON.erroreInTable;
                                $("#table-number").val(table.tableNumber);
                                $("#max-capacity").val(table.maxCapacity);
                                $("#active").val(table.active);
                                $("#tables-state").val(table.tableNumber);
                                }

                                if (response.responseJSON.errors) {
                                    if (response.responseJSON.errors.manyTables) {
                                        swal({
                                            text: String(response.responseJSON.errors.manyTables).replace('many tables',' عدد الطاولات'),
                                            icon:"error",
                                            button: {
                                                text: "حسنا",
                                                value: true,
                                                visible: true,
                                                className: "",
                                                closeModal: true,
                                            },
                                        });
                                    }
                                    if (response.responseJSON.errors.tableNumber) {

                                        $('#tableNumberErrore').text(String(response.responseJSON.errors.tableNumber[0]).replace('table number','رقم الطاولة'));
                                    }
                                    if (response.responseJSON.errors.hallNumber) {
                                        $('#hallNumberErrore').text(String(response.responseJSON.errors.hallNumber[0]).replace('hall number','رقم الصالة'));
                                    }
                                    if (response.responseJSON.errors.maxCapacity) {
                                        $('#maxCapacityErrore').text(String(response.responseJSON.errors.maxCapacity[0]).replace('hallNumber','رقم الصالة').replace('max capacity','السعة القصوى'));
                                    }
                                    if (response.responseJSON.errors.active) {
                                        $('#activeErrore').text(String(response.responseJSON.errors.active[0]).replace('active','الجاهزية'));
                                    }
                                }

                            }
                        });
                    }

                });
                $("#addManyTables").click(function (e) {
                    e.preventDefault();
                    manyTables=true;
                    $("#table-number").prop('disabled', true);
                    $("#table-number").toggleClass("bg-gray-200");
                    $("#table-number").toggleClass("bg-blue-400");
                    $(".manyTablesChoice").css("display", "block");
                    TweenLite.fromTo($(".manyTablesChoice"), 0.5 ,{ height:"0px" }, { height:"90.156px" , ease});
                    TweenLite.fromTo($(".manyTablesChoice"), 0.8, { opacity:0 }, { opacity:1  }).delay(0.5);
                    setTimeout(() => {
                        document.getElementById('tables-count').animate([
                            { clipPath  : "inset(0% 100% 0% 0%)" },
                            { clipPath  : "inset(0% 0% 0% 0%)" }
                        ],
                        {
                            duration: 500,
                            fill: 'forwards'
                    })
                    document.getElementById('tablesStateGroup').animate([
                        { clipPath  : "inset(0% 100% 0% 0%)" },
                        { clipPath  : "inset(0% 0% 0% 0%)" }
                        ],
                        {
                            duration: 500,
                            fill: 'forwards'
                    })

                    }, 1200);
                    setTimeout(() => {
                        $("#addManyTables").css("display", "none");
                        $("#cancelManyTables").css("display", "block");
                    }, 1700);
                });
                $("#cancelManyTables").click(function (e) {
                    e.preventDefault();
                    manyTablesArray=[];
                    tablesAlreadyChanged=[];
                    manyTables=false;
                    first = true;
                    $("#table-number").val(tableNumberInit);
                    $("#tables-count").val(null);
                    $("#tables-state").html(null);
                    $("#table-number").prop('disabled', false);
                    $("#table-number").toggleClass("bg-blue-400");
                    $("#table-number").toggleClass("bg-gray-200");
                    document.getElementById('tables-count').animate([
                            { clipPath  : "inset(0% 0% 0% 0%)" },
                            { clipPath  : "inset(0% 100% 0% 0%)" }
                        ],
                        {
                            duration: 300,
                            fill: 'forwards'
                    })
                    document.getElementById('tablesStateGroup').animate([
                            { clipPath  : getComputedStyle(document.getElementById('tablesStateGroup')).clipPath },
                            { clipPath  : "inset(0% 100% 0% 0%)" }
                        ],
                        {
                            duration: 300,
                            fill: 'forwards'
                    })
                    TweenLite.fromTo($(".manyTablesChoice"), 0.5, { opacity:1 }, { opacity:0 }).delay(0.3);
                    TweenLite.fromTo($(".manyTablesChoice"), 0.5 ,{ height:"90.156px" }, { height:0 ,display:'none' ,ease }).delay(0.8);
                    setTimeout(() => {
                        $("#addManyTables").css("display", "block");
                        $("#cancelManyTables").css("display", "none");
                    }, 1200);


                });
                $("#tables-count").change(function (e) {
                    e.preventDefault();
                    if ($(this).val()> parseInt(initMaxCapacity)) {
                        $(this).val( parseInt(initMaxCapacity))
                    }
                    init();
                });
                $("#tables-state").change(function (e) {
                    e.preventDefault();
                    showSpecificTable(e.target.value);
                });
                $("#maxCapacity").change(function (e) {
                    e.preventDefault();
                    if (manyTables) {
                        var val = $("#maxCapacity").val();
                        var val2=$("#table-number").val();
                        setCapacity(val,val2)
                    }
                });
                $("#max-capacity").change(function (e) {
                    e.preventDefault();
                    if (manyTables) {
                        var val = $("#max-capacity").val();
                        var val2=$("#table-number").val();
                        console.log(val);
                        console.log(val2);
                        setCapacity(val,val2)
                    }
                });
                $("#active").change(function (e) {
                    e.preventDefault();
                    if (manyTables) {
                        var val = $("#active").val();
                        var val2=$("#table-number").val();
                        setActive(val,val2)
                    }
                });

            });
    </script>
@endsection
