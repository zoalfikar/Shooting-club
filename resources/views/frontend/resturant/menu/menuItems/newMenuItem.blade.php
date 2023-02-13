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
            clip-path  : inset(100% 0% 0% 0%);
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
    </style>

@endsection


@section('content')
<div class="beautifull-grid">
    <div class="grid-form">
        <form class="w-full max-w-lg" action="{{url('add-new-menu-item')}}" method="POST">
            @csrf
              <div class="flex flex-wrap -mx-3 mb-6">
                  <div class="w-full md:w-1/2 px-3">
                      <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="title">
                          اسم المادة
                      </label>
                      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="title" name="title" type="text" placeholder="اسم المادة الجديدة" >
                      @error('title')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("title","اسم المادة",$message)}}
                          </p>
                      @enderror
                  </div>
                  <div class="w-full md:w-1/2 px-3">
                      <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="section">
                          الصنف
                      </label>
                      <div class="relative">
                          <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="section" name="section">
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
                      {{-- <div id="tablesCountErrore" class="text-red-500 mb-0 text-xl italic errore">
                      </div> --}}
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
                          <input class="appearance-none block w-full ml-10 bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="pace" name="pace" type="number" disabled placeholder="  لتسهيل ملىء الطلب (إختياري)" min="0.001" step="0.01"> &nbsp; <span class="unit"></span>
                      </div>
                      @error('pace')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("pace","الخطوة ",$message)}}
                          </p>
                      @enderror
                      {{-- <div id="tablesCountErrore" class="text-red-500 mb-0 text-xl italic errore">
                      </div> --}}
                  </div>
                  <div class="w-full  md:w-1/1 px-3 m-auto options" style="margin-top: 40px !important">
                      <!-- <button type="submit" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                          تم !
                      </button>  -->
                        <button id="done" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            تم !
                        </button>
                        <button id="addManyItems" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            إضافة عدة مواد
                        </button>
                        <button id="add" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            أضف &nbsp; <i class="fa fa-plus"></i>
                        </button>
                        <button id="cancel" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            إلغاء
                        </button>
                  </div>
              </div>
        </form>
    </div>
    <div class="grid-table manyItemsChoice" id="manyItemsChoice">
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
    </div>
</div>

@endsection


@section('scripts')
    <script type='module'>
           function init() {
                const addNewItemButton = document.getElementById('add');
                var ease =Power1.easeInOut;
                var items = [];
                var table = document.getElementById('itemsTable');
                var manyItemsMode = false;
                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
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
                            $(".unit").css("visibility", "hidden");

                        }

                    });
                    $("#addManyItems").click(function (e) {
                        e.preventDefault();
                        manyItemsMode=true;
                        $(".manyItemsChoice").css("display", "block");
                        $(".manyItemsChoice").css("width", "100%");
                        TweenLite.fromTo($(".manyItemsChoice"), 1 ,{ width:"0px" }, {width:getComputedStyle(document.getElementById('manyItemsChoice')).width, ease});
                        setTimeout(() => {

                            document.getElementById('manyItemsChoice').animate([
                                { clipPath  : "inset(0% 100% 0% 0%)" },
                                { clipPath  : "inset(0% 0% 0% 0%)" }
                            ],
                            {
                                duration: 1000,
                                fill: 'forwards'
                        })
                        }, 1000);
                        setTimeout(() => {
                            $("#addManyItems").css("display", "none");
                            $("#add").css("display", "block");
                            $("#cancel").css("display", "block");
                        }, 2000);
                    });
                    $("#cancel").click(function (e) {
                        e.preventDefault();
                        manyItemsMode=false;
                        // $("#addManyItems").css("display", "block");
                        $("#add").css("display", "none");
                        $("#cancel").css("display", "none");
                        TweenLite.fromTo($(".manyItemsChoice"), 1 ,{width:getComputedStyle(document.getElementById('manyItemsChoice')).width}, {width:"0px", ease});
                        setTimeout(() => {
                            // $("#manyItemsChoice").css("clipPath", "inset(0% 100% 0% 0%)");

                        //     document.getElementById('manyItemsChoice').animate([
                        //         { clipPath  : "inset(0% 0% 0% 0%)" },
                        //         { clipPath  : "inset(0% 100% 0% 0%)" }
                        //     ],
                        //     {
                        //         duration: 1000,
                        //         fill: 'forwards'
                        // })
                        $("#manyItemsChoice").css("display", "none");
                        $("#addManyItems").css("display", "block");

                        }, 1000);
                        // setTimeout(() => {
                        //     $("#addManyItems").css("display", "block");
                        // }, 2000);

                    });
                    $("#done").click(function (e) {
                        e.preventDefault();
                        if (!manyItemsMode) {
                            $.ajax({
                            type: "post",
                            url: "add-new-menu-item",
                            data: {
                                "title" : $("#title").val(),
                                "section" : $("#section").val(),
                                "price" : $("#price").val(),
                                "unit" : $("#unit").val(),
                                "pace" : $("#pace").val(),
                                "fragmentable" : $("#fragmentable").prop("checked") == true ? 1 : 0,
                                "active" : $("#active").prop("checked") == true ? 1 : 0,
                                "descriptions" : $("#description").val()
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
                            }
                        });

                        } else {
                            $.ajax({
                            type: "post",
                            url: "add-new-menu-items",
                            data: {
                                "items" : items,
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
                            }
                        }); 
                        }
                      
                    });
                    addNewItemButton.addEventListener('click',(e)=>{
                        let newItem= {};
                        newItem.uniqeNumber= npmDependencies.uuidv4();
                        newItem.title = document.getElementById('title').value;
                        newItem.section= document.getElementById('section').value;
                        newItem.sectionName= $("#section option:selected").text();
                        newItem.unit= document.getElementById('unit').value;
                        newItem.price= document.getElementById('price').value;
                        newItem.active= document.getElementById('active').checked  ? 1 : 0;
                        newItem.fragmentable= document.getElementById('fragmentable').checked ? 1 : 0;
                        newItem.description= document.getElementById('description').value;
                        newItem.pace= document.getElementById('pace').value ?document.getElementById('pace').value:1;
                        //
                        var tr = document.createElement("tr");
                        tr.setAttribute('id',`${newItem.uniqeNumber}`);
                        tr.innerHTML=`<td>${newItem.title}</td><td>${newItem.sectionName}</td><td>${newItem.price}</td><td>${newItem.unit}</td><td>${newItem.active ? 'مغعل':'لا'}</td><td>${newItem.fragmentable ? 'نعم':'لا'}</td><td>${newItem.pace?newItem.pace : 1}</td>
                        <td class="optionTD">
                            <button class="editItem" title="تعديل"></button>
                            <button class="deleteItem" title="حذف"></button>
                        </td>`
                        table.lastChild.appendChild(tr);
                        //
                        items.push(newItem)
                        document.querySelectorAll('.editItem').forEach(element => {
                            element.addEventListener('click', editItem)
                        }); 
                        document.querySelectorAll('.deleteItem').forEach(element => {
                            element.addEventListener('click', deleteItem)
                        }); 
                    })
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

                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection
