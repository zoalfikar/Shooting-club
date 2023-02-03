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
            display: grid;
            grid-template-areas: "grid-form" "grid-table";
            grid-template-columns: auto auto ;
            grid-gap: 40px;
        }
        .manyItemsChoice{
            display: none;
            width: 0px;
            clip-path  : inset(100% 0% 0% 0%);
        }
        td,th{
            text-align: center;
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
                                  <option selected value= "{{$section->id}}"  selected>{{$section->name}}</option>
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
                          <input class="form-check-input" type="checkbox"  id="active" name="active" checked>
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
                          <input class="form-check-input" type="checkbox"  id="fragmentable" name="fragmentable" >
                          <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="fragmentable">
                              الواحدة قابلة للتجزئة مثال (كغ)
                          </label>
                        </div>
                      @error('fragmentable')
                          <p class="text-red-500 text-xl italic">
                              {{str_replace("active","الجاهزية",$message)}}
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
                  <div class="w-full  md:w-1/1 px-3 m-auto" style="margin-top: 40px !important">
                      {{-- <button type="submit" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                          تم !
                      </button> --}}
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
        <table class="table table-striped">
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
            </thead>
            <tbody>
                <tr>
                    <td>شيش طاووق مشوي</td>
                    <td>حلويات</td>
                    <td>1223000</td>
                    <td>رطل</td>
                    <td>مفعل غير</td>
                    <td>مجزئةغير</td>
                    <td>1203</td>
                </tr>
                <tr>
                    <td>شيش طاووق مشوي</td>
                    <td>حلويات</td>
                    <td>1223000</td>
                    <td>رطل</td>
                    <td>مفعل غير</td>
                    <td>مجزئةغير</td>
                    <td>1203</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection


@section('scripts')
    <script>
           function init() {
                var ease =Power1.easeInOut;
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
                        $.ajax({
                            type: "post",
                            url: "add-new-menu-section",
                            data: {
                                "name" : $("#name").val(),
                                "options" : $("#options").val(),
                                "active" : $("#active").prop("checked")==true ? 1 :0,
                                "descriptions" : $("description").val(),
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

                    });
                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection

