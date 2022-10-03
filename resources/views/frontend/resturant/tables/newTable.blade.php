@extends('appLayouts.app')
@section('styles')

@endsection


@section('content')
    <form class="w-full max-w-lg" action="{{url('add-new-table')}}" method="POST">
      @csrf
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="table-number">
                رقم الطاولة
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="table-number" name="tableNumber" type="number" placeholder="ادخل رقم الطاولة" readonly  value="{{$TableNumber}}">
                @error('tableNumber')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("table number","رقم الطاولة",$message)}}
                    </p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
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
                            {{str_replace("hall number","قم الصالة",$message)}}
                        </p>
                    @enderror
                </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="max-capacity">
                    السعة القصوى
                </label>
                <input value="10" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="max-capacity" name="maxCapacity" type="number" min="1" placeholder="عدد الكراسي">
                @error('maxCapacity')
                    <p class="text-red-500 text-xl italic">
                        {{str_replace("max capacity","سعة الطاولة",$message)}}
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
            <div class="w-full md:w-1/2 px-3 mt-6">
                <button type="submit" class="bg-gray-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    تم !
                </button>
            </div>
        </div>
    </form>

@endsection


@section('scripts')
    <script>
            $(document).ready(function() {
                $("#hall-number").change(function() {
                    var hallNumber = $("#hall-number").val();
                    $.ajax({
                        type: "get",
                        url: "show-new-table-form",
                        data: {
                            'hallNumber':hallNumber
                        },
                        success: function (response) {
                            $("#table-number").val(response.TableNumber);
                        }
                    });
                });
        });
    </script>
@endsection
