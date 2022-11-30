@extends('appLayouts.app')
@section('styles')
    <style>
        body::before {
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
        }
    </style>
@endsection


@section('content')
    <form class="w-full max-w-lg" action="{{url('add-new-hall')}}" method="POST">
      @csrf
        <div class="flex flex-wrap -mx-3 mb-6 space-y-5">
            <div class="w-full md:w-1/2 px-3 md:mb-0" style="margin-top: 20px !important">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="hall-number">
                    رقم الصالة
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="hall-number" name="hallNumber" type="number" placeholder="ادخل رقم الصالة" readonly  value="{{$hallNumber}}">
                @error('hallNumber')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("hall number","رقم الصالة",$message)}}
                    </p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="hall-name">
                    اسم الصالة
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="hall-name" name="hallName" type="text" placeholder=" اسم الصالة مثال -الصالةالاولى-" >
                @error('hallName')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("hall name","اسم الصالة",$message)}}
                    </p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="max-capacity">
                     السعة القصوى (عدد الطاولات)
                </label>
                <input value="50" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="max-capacity" name="maxCapacity" type="number" min="1" placeholder="عدد الطاولات">
                @error('maxCapacity')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("max capacity","سعة الصالة",$message)}}
                    </p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
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
                </div>
            </div>
            <div class="w-full md:w-1/2 px-3" style="margin-top: 40px !important">
                <button type="submit" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    تم !
                </button>
                {{-- <button id="done" type="button" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    تم !
                </button> --}}
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
                    $("#done").click(function() {
                        $.ajax({
                            method: "POST",
                            url: $( 'form' ).attr( 'action' ),
                            data: {
                                'hallNumber': $('#hall-number').val(),
                                'hallName':$('#hall-name').val(),
                                'active':  $('#active').val(),
                                'maxCapacity':$('#max-capacity').val(),
                            },
                            success: function (response) {
                                swal("تم" ,"تم بنجاع ادخال صالة جديدة", "success");
                            }
                        }).then(()=>{
                            // $('.app-container').load(location.href + ' .app-container','', function (response, status, request) {
                            //     console.log(response);

                            // });
                            // setTimeout(() => {
                            // var app = new Vue(vueAppOptions).$mount('.app-container');
                            //     init();
                            // }, 2000);
                            // vueReMounteElement('.app-container');
                        });
                    });
                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection
