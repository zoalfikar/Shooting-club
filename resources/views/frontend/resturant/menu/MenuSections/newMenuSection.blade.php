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
    </style>
@endsection


@section('content')
    <form class="w-full max-w-lg" action="{{url('add-new-menu-section')}}" method="POST">
      @csrf
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="name">
                    اسم الصنف
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="name" name="name" type="text" placeholder="اسم الصنف الجديد" >
                @error('name')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("hall name","اسم الصنف",$message)}}
                    </p>
                @enderror
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
                    تم !
                </button>
            </div>
        </div>
    </form>
@endsection


@section('scripts')
    <script>
           function init() {
                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
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
