@extends('appLayouts.app')
@section('styles')
    <style>
        /* body::before {
            content: "";
            background-image: url("images/resturantHall.jpg");
            background-size: cover;
            opacity: 0.4;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: fixed;
            z-index: -10;
        } */
        .relative2{
            display: flex;
        }
        #toggleSectionsMenu{
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
    <form class="w-full max-w-lg" action="{{url('add-new-menu-section')}}" method="POST">
      @csrf
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3">
                <label on class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="section">
                    الصنف
                </label>
                    <div class="relative2">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="toggleSectionsMenu" data-bs-toggle="collapse" data-bs-target="#items" >
                            </button>
                            <div class="dropdown-menu collapse"  id="items">
                                @foreach ($sections as $section)
                                    <li class="bg-gray-300 text-gray-700 font-bold "  data-item-id="{{$section->id}}">
                                        {{$section->name}}
                                    </li>
                                @endforeach
                            </div>
                        </div>
                        <input class="appearance-none  w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="name" name="name" type="text" placeholder="اسم الصنف الجديد" >
                    </div>
                @error('section')
                <p class="text-red-500 text-xl italic">
                    {{str_replace("section","الصنف",$message)}}
                </p>
                @enderror
                <div id="sectionErrore" class="text-red-500 text-xl italic errore">
                </div>
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="options">
                    مخصص
                </label>
                <div class="relative">
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="options" name="options">
                    <option selected value= "resturant"  selected>مطعم</option>
                    <option value= "free-point" > مبيع حر</option>
                    <option value= "both" >كلاهما</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center  text-gray-700">
                        <v-icon color="black" >mdi-chevron-down</v-icon>
                    </div>
                    @error('options')
                        <p class="text-red-500 text-xl italic">
                            {{str_replace("options","مخصصة",$message)}}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="w-full md:w-1/5 px-3 mt-10">
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
            <div class="w-full md:w-1/1 px-3 mt-10">
                <div class="mb-3">
                    <label for="description" class="form-label inline-block mb-2 text-gray-700">
                        الوصف
                    </label>
                    <textarea
                      class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                      id="description" name="description"  rows="3" placeholder=" أدخل وصفا حول هذا الصنف (إختياري)" style=" resize: none; width:100% !important;">
                    </textarea>
                  </div>
                    @error('description')
                        <p class="text-red-500 text-xl italic">
                            {{str_replace("description","الوصف",$message)}}
                        </p>
                    @enderror
            </div>
            <div class="w-full md:w-1/2 px-3" style="margin-top: 40px !important">
                {{-- <button type="submit" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    تم !
                </button> --}}
                <button id="done" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    تعديل !
                </button>
                <button id="delete" type="button" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    حذف !
                </button>
            </div>
        </div>
    </form>
@endsection


@section('scripts')
    <script>
           function init() {
                document.addEventListener('click', function(event) {
                    var settingMenu = document.getElementById('items');
                    var ClickedOnSettimgMenu = settingMenu.contains(event.target);
                    if (!ClickedOnSettimgMenu) {
                        settingMenu.classList.remove("show");
                    }
                });
                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    var currentSection = null;
                    var currentListItem = null;
                    $('.dropdown-menu li').click(function (e) {
                        e.preventDefault();
                        currentSection = this.dataset.itemId;
                        currentListItem = this;
                        $(".dropdown-menu li").removeClass('bg-gray-800');
                        $(this).addClass('bg-gray-800');
                        $.ajax({
                            type: "get",
                            url: "get-menu-section",
                            data: {
                                "id" : this.dataset.itemId ,
                            },
                            success: function (response) {
                                $("#name").val(response.section.name),
                                $("#options").val(response.section.options)
                                if (String(response.section.active) === '1') {
                                    $("#active").attr("checked",true)
                                } else {
                                    $("#active").attr("checked",false)
                                }
                                $("#description").val(response.section.description)
                            }
                        });
                    })
                    $("#done").click(function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: "post",
                            url: "update-menu-section",
                            data: {
                                "id" : currentSection,
                                "name" : $("#name").val(),
                                "options" : $("#options").val(),
                                "active" : $("#active").prop("checked")==true ? 1 :0,
                                "description" : $("#description").val(),
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
                                $(currentListItem).html($("#name").val());
                            }
                        });

                    });
                    $("#delete").click(function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: "post",
                            url: "/delete-menu-section",
                            data: {
                                "id" : currentListItem.dataset.itemId ,
                            },
                            success: function (response) {
                                $(".dropdown-menu").find(currentListItem).remove();
                                currentSection = null;
                                currentListItem = null;
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
                                $("#name").val(''),
                                $("#options").val('')
                                $("#active").attr("checked",true)
                                $("#description").val("");
                            }
                        });
                    });
                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection
