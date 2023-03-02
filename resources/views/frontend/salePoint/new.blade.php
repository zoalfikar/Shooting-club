@extends('appLayouts.app')
@section('styles')
    <style>
      
    </style>
@endsection


@section('content')
    <form class="w-full max-w-lg">
      @csrf
        <div class="flex flex-wrap -mx-3 mb-6 space-y-5">
            <div class="w-full md:w-1/2 px-3" style="margin-top: 20px !important">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="sale-point-name">
                    اسم نقطةالبيع
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="sale-point-name" name="salePointName" type="text" placeholder=" اسم  نقطة البيع  مثال - نقطة البيع الاولى-" >
            </div>
            <div class="w-full md:w-1/2 px-3 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="max-employees-number">
                    عدد الموظفين
                </label>
                <input value="1" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="max-employees-number" name="maxEmployeesNumber" type="number" min="1" placeholder="عدد الموظفين">
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
                </div>
            </div>
            <div class="px-3" style="margin-top: 40px !important; display:block; width:100%">
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
                    $("#done").click(function(e) {
                        e.preventDefault();
                        $.ajax({
                            method: "POST",
                            url: '/add-new-sale-point-form',
                            data: {
                                'name':$('#sale-point-name').val(),
                                'active':  $('#active').val(),
                                'maxEmployeesNumber':$('#max-employees-number').val(),
                            },
                            success: function (response) {
                                swal("تم" ,response.message, "success");
                            }
                        })
                    });
                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection
