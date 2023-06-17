@extends('appLayouts.app')
@section('styles')
    <style>
        .unit{
            visibility:hidden;
        }
        #add , #cancel {
            display: none;
        }
        .beautifull-grid
        {
            justify-content: center;
            width: 100%;
            display: grid;
            grid-template-areas: "grid-form" "grid-table";
            grid-template-columns: auto auto ;
            grid-gap: 20px;
        }
        .manyItemsChoice{
            padding-left:5px;
            display: none;
            width: 0%;
            clip-path  : inset(0% 100% 0% 0%);
        }
        table{
            min-width:500px;
            max-width:100%;
        }
        tr{
            max-width: 100%;
        }
        table , thead , tbody{
            width:100%;
        }
        td,th{
            text-align: center;
        }
        .options{
            display: flex;
            gap:15px;
        }
        .editItem{
            background-color: blue;
        }
        .deleteItem{
            background-color: red;
        }
        .editItem , .deleteItem {
             height: 10px;
             width: 10px;
             border-radius:4px;
        }
        .relative2{
            display: flex;
        }
        #toggleItemsMenu{
            height: 54px;
            box-shadow: none;
        }
        .dropdown-menu{
            position: absolute;
            inset:54px 0 0 0;
            padding-top: 0% !important;
            padding-bottom: 0% !important;
            width: 224px !important;
            min-height: 200px;
            max-height: 272px;
            overflow: auto;
        }
        .dropdown-menu::-webkit-scrollbar{
            background-color: aqua;
        }
        .dropdown-menu li {
            width: 100% !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            text-align: right;
            padding-right: 15px;
            border-bottom:  1px solid rgb(177, 177, 177);
        }
        .dropdown-menu li:hover {
            background-color: rgb(175, 175, 175);
        }
    </style>

@endsection


@section('content')
<div class="beautifull-grid">
    <div class="grid-form">
        <form class="w-full max-w-lg" action="{{url('add-new-menu-item')}}" method="POST">
            @csrf
              <div class="flex flex-wrap -mx-3 mb-6">
                  <div class="w-full md:w-1/2 px-3">
                      <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="section">
                          الصنف
                      </label>
                      <div class="relative">
                          <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="section" name="section">
                            <option disabled selected value= "-1">اختر صنف</option>
                              @foreach ($sections as $section)
                                  <option  value= "{{$section->id}}">{{$section->name}}</option>
                              @endforeach
                          </select>
                          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                              <v-icon color="black" >mdi-chevron-down</v-icon>
                          </div>
                          @error('section')
                              <p class="text-red-500 text-xl italic">
                                  {{str_replace("section","الصنف",$message)}}
                              </p>
                          @enderror
                            <div id="sectionErrore" class="text-red-500 text-xl italic errore">
                            </div>
                      </div>
                  </div>
                  <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="title">
                        اسم المادة
                    </label>
                    <div class="relative2">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="toggleItemsMenu" data-bs-toggle="collapse" data-bs-target="#allitems" >
                            </button>
                            <div class="dropdown-menu collapse" id="allitems">
                            </div>
                        </div>
                        <input class="appearance-none  w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="title" name="title" type="text" placeholder="اسم المادة" >
                    </div>
                    @error('title')
                        <p class="text-red-500 text-xl italic">
                            {{str_replace("title","اسم المادة",$message)}}
                        </p>
                    @enderror
                    <div id="titleErrore" class="text-red-500 text-xl italic errore">
                      </div>
                    </div>
                  <div class="w-full md:w-1/2 px-3">
                      <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="unit">
                          الواحدة
                      </label>
                      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="unit" name="unit" type="text" placeholder=" مثال : (كغ : قابل للتجزئة - عبوة : غير قابل للتجزئة) " >
                      @error('unit')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("unit"," الواحدة",$message)}}
                          </p>
                      @enderror
                        <div id="unitErrore" class="text-red-500 text-xl italic errore">
                        </div>
                  </div>
                  <div class="w-full md:w-1/2 px-3  md:mb-6 ">
                      <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="price">
                       السعر (ل.س)
                      </label>
                      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="price" name="price" type="number" placeholder="السعر" min="1">
                      @error('price')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("price"," السعر",$message)}}
                          </p>
                      @enderror
                        <div id="priceErrore" class="text-red-500 text-xl italic errore">
                        </div>
                  </div>
                  <div class="w-full md:w-1/5 px-3 mt-2">
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox"  id="active" name="active" checked value="1">
                          <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="active">
                              مفعل
                          </label>
                        </div>
                      @error('active')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("active","الجاهزية",$message)}}
                          </p>
                      @enderror
                        <div id="activeErrore" class="text-red-500 text-xl italic errore">
                        </div>
                  </div>
                  <div class="w-full md:w-3/5 px-3 mt-2">
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox"  id="fragmentable" name="fragmentable" value="1">
                          <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="fragmentable">
                              الواحدة قابلة للتجزئة مثال (كغ)
                          </label>
                        </div>
                      @error('fragmentable')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("fragmentable","قابل للتجزئة",$message)}}
                          </p>
                      @enderror
                        <div id="fragmentableErrore" class="text-red-500 text-xl italic errore">
                        </div>
                  </div>
                  <div class="w-full md:w-1/1 px-3 mt-2">
                      <div class="mb-3">
                          <label for="description" class="form-label inline-block mb-2 text-gray-700">
                              الوصف
                          </label>
                          <textarea
                            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0
                              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            id="description" name="description"  rows="3" placeholder=" أدخل وصفا حول هذه المادة  (سيظهر الوصف في القائمة)" style=" resize: none; width:100% !important;">
                          </textarea>
                        </div>
                          @error('description')
                              <p class="text-red-500 text-xl italic">
                                  {{str_replace("description","الوصف",$message)}}
                              </p>
                          @enderror
                  </div>
                  <div class="w-full md:w-1/1 px-3  mb-12 md:mb-6 ">
                      <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="pace">
                       الزيادة بمقدار (الخطوة)
                      </label>
                      <div class="flex">
                          <input class="appearance-none block w-full ml-10 bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="pace" name="pace" type="number" disabled placeholder="  لتسهيل ملىء الطلب (إختياري)" min="0.001" step="0.001"> &nbsp; <span class="unit"></span>
                      </div>
                      @error('pace')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("pace","الخطوة ",$message)}}
                          </p>
                      @enderror
                        <div id="paceErrore" class="text-red-500 text-xl italic errore">
                        </div>
                  </div>
                  <div class="w-full  md:w-1/1 px-3 m-auto options" style="margin-top: 40px !important">
                      <!-- <button type="submit" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                          تم !
                      </button>  -->
                        <button id="done" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            تعديل !
                        </button>
                        <button id="delete" type="button" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            حذف !
                        </button>
                        {{-- <button id="addManyItems" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            إضافة عدة مواد
                        </button>
                        <button id="add" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            أضف &nbsp; <i class="fa fa-plus"></i>
                        </button>
                        <button id="cancel" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            إلغاء
                        </button> --}}
                  </div>
              </div>
        </form>
    </div>
    {{-- <div class="grid-table manyItemsChoice" id="manyItemsChoice">
        <table class="table table-striped" id='itemsTable' >
            <thead class="table-Primary">
                <th>
                    المادة
                </th>
                <th>
                    النوع
                </th>
                <th>
                     السعر (ل.س)
                </th>
                <th>
                    الواحدة
                </th>
                <th>
                    مفعل
                </th>
                <th>
                    واحدة مجزئة
                </th>
                <th>
                     خطوة
                </th>
                <th>
                     تعديل
                </th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div> --}}
</div>

@endsection


@section('scripts')
    <script type='module'>

           function init() {
                document.addEventListener('click', function(event) {
                    var settingMenu = document.getElementById('allitems');
                    var ClickedOnSettimgMenu = settingMenu.contains(event.target);
                    if (!ClickedOnSettimgMenu) {
                        settingMenu.classList.remove("show");
                    }
                });
                // const addNewItemButton = document.getElementById('add');
                // var ease =Power1.easeInOut;
                // var items = [];
                // var table = document.getElementById('itemsTable');
                // var manyItemsMode = false;
                var allSectionItems = [];
                var currentListItemElement =null ;
                var currentItemId = null;
                var currentItem = null;
                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $("#section").change(function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: "get",
                            url: "get-menu-section",
                            data: {
                                "id" : $("#section").val() ,
                            },
                            success: function (response) {
                                $('.dropdown-menu').html('');
                                allSectionItems = response.section.items;
                                $.each(response.section.items, function (i, item) {
                                    $('.dropdown-menu').append(
                                        `<li class="bg-gray-300 text-gray-700 font-bold "  data-item-id="${item.id}">
                                            ${item.title}
                                        </li>`
                                    );
                                });
                                $('.dropdown-menu li').click(addEventToOptions)
                            }
                        });
                    });
                    function addEventToOptions() {
                        currentItemId = this.dataset.itemId;
                        currentListItemElement = this;
                        currentItem = allSectionItems.find((element)=>element.id==currentItemId);
                        $(".dropdown-menu li").removeClass('bg-gray-800');
                        $(this).addClass('bg-gray-800');
                        $("#title").val(currentItem.title)
                        $("#unit").val(currentItem.unit)
                        $("#price").val(currentItem.price)
                        $("#pace").val(currentItem.pace)
                        $("#descriptions").val(currentItem.descriptions)
                        if (String(currentItem.active) == 1) {
                            $("#active").attr("checked",true)
                        } else {
                            $("#active").attr("checked",false)
                        }
                        if (String(currentItem.fragmentable) == 1) {
                            $("#fragmentable").attr("checked",true)
                        } else {
                            $("#fragmentable").attr("checked",false)
                        }
                    }
                    $('#delete').click(function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: "post",
                            url: "delete-menu-item",
                            data: {
                                "id" : currentItemId ,
                            },
                            success: function (response) {
                                allSectionItems = allSectionItems.filter((element)=>{
                                    return element.id != currentItemId ;
                                })
                                currentItemId = null;
                                $(".dropdown-menu").find(currentListItemElement).remove();
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
                            }
                        });
                    });
                    $("#unit").change(function (e) {
                        e.preventDefault();
                        $(".unit").text($(this).val());
                    });
                    $("#fragmentable").click(function (e) {
                        // e.preventDefault();
                        if ($(this).prop("checked")==true) {
                            $("#pace").attr("disabled", false);
                            $(".unit").css("visibility", "visible");
                        } else {
                            $("#pace").attr("disabled", true);
                            $("#pace").val(1);
                            $(".unit").css("visibility", "hidden");

                        }

                    });
                    $("#done").click(function (e) {
                        e.preventDefault();
                        resetErrore();

                        if (!currentItem)
                            swal({
                                text:" لم يتم تحديد اي مادة",
                                button: {
                                    text: "حسنا",
                                    value: true,
                                    visible: true,
                                },
                            })
                        else
                            $.ajax({
                                type: "post",
                                url: "update-menu-item",
                                data: {
                                    "id" : currentItem.id,
                                    "title" : $("#title").val(),
                                    "price" : $("#price").val(),
                                    "unit" : $("#unit").val(),
                                    "pace" : $("#pace").val(),
                                    "fragmentable" : $("#fragmentable").prop("checked") == true ? 1 : 0,
                                    "active" : $("#active").prop("checked") == true ? 1 : 0,
                                    "description" : $("#description").val()
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
                                    $(currentListItemElement).html($("#title").val());
                                    resetItem() ;
                                    // resetInputs();
                                },
                                // error:function (response) {
                                //     if (response.responseJSON.errors) {
                                //         if (response.responseJSON.errors.title) {
                                //             $('#titleErrore').text(String(response.responseJSON.errors.title[0]).replace('title','المادة'));
                                //         }
                                //         if (response.responseJSON.errors.section) {
                                //             $('#sectionErrore').text(String("هذا الصنف غير موجود بالقائمة"));
                                //         }
                                //         if (response.responseJSON.errors.price) {
                                //             $('#priceErrore').text(String(response.responseJSON.errors.price[0]).replace('price',' السعر'));
                                //         }
                                //         if (response.responseJSON.errors.unit) {
                                //             $('#unitErrore').text(String(response.responseJSON.errors.unit[0]).replace('unit',' الواحدة'));
                                //         }
                                //         if (response.responseJSON.errors.pace) {
                                //             $('#paceErrore').text(String(response.responseJSON.errors.pace[0]).replace('pace','الخطوة'));
                                //         }
                                //         if (response.responseJSON.errors.fragmentable) {
                                //             $('#fragmentableErrore').text(String(response.responseJSON.errors.fragmentable[0]).replace('fragmentable',' قابل للتجزئة'));
                                //         }
                                //         if (response.responseJSON.errors.active) {
                                //             $('#activeErrore').text(String(response.responseJSON.errors.active[0]).replace('active','الجاهزية'));
                                //         }
                                //     }

                                // }
                            });
                    });
                    function editItem(e) {
                       let tr=e.target.parentNode.parentNode;
                       let item = items.find(element => element.uniqeNumber == tr.id);
                       table.lastChild.removeChild(tr);
                       items = items.filter((element)=>{
                            return element.uniqeNumber != tr.id;
                       })
                       document.getElementById('title').value = item.title;
                        document.getElementById('section').value= item.section
                        document.getElementById('unit').value= item.unit
                        document.getElementById('price').value = item.price
                        document.getElementById('active').checked  = item.active ;
                        document.getElementById('fragmentable').checked   =  item.fragmentable ;
                        document.getElementById('description').value = item.description
                        document.getElementById('pace').value = item.pace;
                    }
                    function deleteItem(e) {
                       let tr=e.target.parentNode.parentNode;
                       table.lastChild.removeChild(tr);
                       items = items.filter((element)=>{
                            return element.uniqeNumber != tr.id;
                       })
                    }
                    function resetInputs() {
                        $("#title").val(null);
                        $("#section").val(null);
                        $("#price").val(null);
                        $("#unit").val(null);
                        $("#pace").val(null);
                        // $("#fragmentable").setAttribute('cheked',true);
                        // $("#active").setAttribute('cheked',true);
                        $("#description").val(null);
                        // table.lastChild.innerHTML=null;
                        $(".dropdown-menu li").removeClass('bg-gray-800');
                        $("dropdown-menu").html(null);
                        resetErrore();
                    }
                    function resetErrore() {
                        $('.errore').each((index,el)=>{
                            $(el).html(null);
                        })
                        // items=[];
                    }
                    function resetItem() {
                        currentItem.title = $("#title").val();
                        currentItem.unit = $("#unit").val();
                        currentItem.price = $("#price").val();
                        currentItem.pace = $("#pace").val();
                        currentItem.description = $("#description").val();
                        currentItem.active =  $("#active").prop("checked") == true ? 1 : 0 ;
                        currentItem.fragmentable = $("#fragmentable").prop("checked") == true ? 1 : 0 ;
                    }
                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection

