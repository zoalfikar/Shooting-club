@extends('appLayouts.app')
@section('styles')
<style>
 .errore{
    display: none;
 }
</style>

@endsection
@section('content')
<div class="arabic-form" style="margin-top: -40px">
    <h1 class="text-center"> مستخدم جديد  </h1>
    <form action="{{url('/users')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" id="name" value="{{old('name') ? old('name') : ''}}">
            @if ($errors->has('name'))
                <div class="bg-danger mt-2 p-3 text-white">
                    @foreach ($errors->get('name') as $errore)
                        {{str_replace("name","الاسم",$errore)}}
                    @endforeach

                </div>
                @endif
            <div id="nameError" class="bg-danger mt-2 p-3 text-white errore">
            </div>
          </div>
        <div class="mb-3">
          <label for="email" class="form-label">الايميل</label>
          <input type="email" name="email" class="form-control" id="email" value="{{old('email') ? old('email') : ''}}">
            @if ($errors->has('email'))
                <div class="bg-danger mt-2 p-3 text-white">
                    @foreach ($errors->get('email') as $errore)
                        {{str_replace("email","الايميل",$errore)}}
                    @endforeach
                </div>
            @endif
            <div id="emailError" class="bg-danger mt-2 p-3 text-white errore">
            </div>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">الصلاحيات</label>
            <select name='role' style="width: 100%; background:rgb(238, 228, 213);height: 40px ">
                <option value="-1" disabled></option>
                <option value="acountant">محاسب</option>
                <option value="waiter">نادل</option>
                <option value="salePoint">نقطة مبيع</option>
            </select>
              @if ($errors->has('email'))
                  <div class="bg-danger mt-2 p-3 text-white">
                      @foreach ($errors->get('email') as $errore)
                          {{str_replace("email","الايميل",$errore)}}
                      @endforeach
                  </div>
              @endif
              <div id="roleError" class="bg-danger mt-2 p-3 text-white errore">
            </div>
          </div>
            <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control" id="password" value="{{old('password') ? old('password') : ''}}">
            @if ($errors->has('password'))
                <div class="bg-danger mt-2 p-3 text-white">
                    @foreach ($errors->get('password') as $errore)
                        {{str_replace("password","كلمة المرور",$errore)}}
                    @endforeach
                </div>
            @endif
            <div id="passwordError" class="bg-danger mt-2 p-3 text-white errore">
            </div>
        </div>
        <div class="mb-3">
            <label for="passwordConfirme" class="form-label">تاكيد كلمة المرور </label>
            <input type="password" name="passwordConfirme" class="form-control" id="passwordConfirme" value="{{old('passwordConfirme') ? old('passwordConfirme') : ''}}">

            @if(session()->has('errore'))
                <div class="alert alert-danger mt-1">
                    {{ session()->get('errore') }}
                </div>
            @endif
            <div id="passwordConfirmeError" class="bg-danger mt-2 p-3 text-white errore">
            </div>
            
        </div>
        <div>
            <button id="submit" type="submit" class="btn btn-primary w-25">إرسال</button>
        </div>
      </form>
</div>
@endsection


@section('scripts')
    <script>
           function init() {
                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $("#submit").click(function (e) { 
                        e.preventDefault();
                        $('.errore').css('display', 'none');
                        $.ajax({
                            type: "post",
                            url: "/users",
                            data: {
                                name:$("input[name='name']").val(),
                                email:$("input[name='email']").val(),
                                password:$("input[name='password']").val(),
                                passwordConfirme:$("input[name='passwordConfirme']").val(),
                                role:$("select[name='role']").val(),
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
                            },
                            error:function (response) {
                                if (response.responseJSON.passwordError) {
                                    if (response.responseJSON.passwordError) {
                                        $("#passwordConfirmeError").html(response.responseJSON.passwordError);
                                        $("#passwordConfirmeError").css("display", "block");
                                    }
                                }
                                if(response.responseJSON.errors){
                                    if (response.responseJSON.errors.name) {
                                        $("#nameError").html(String(response.responseJSON.errors.name[0]).replace('name',' الاسم'));
                                        $("#nameError").css("display", "block");
                                    }
                                    if (response.responseJSON.errors.email) {
                                        $("#emailError").html(String(response.responseJSON.errors.email[0]).replace('email','الايميل'));
                                        $("#emailError").css("display", "block");
                                    }
                                    if (response.responseJSON.errors.role) {
                                        $("#roleError").html(String(response.responseJSON.errors.role[0]).replace('role',' الصلاحيات'));
                                        $("#roleError").css("display", "block");
                                    }
                                    if (response.responseJSON.errors.password) {
                                        $("#passwordError").html(String(response.responseJSON.errors.password).replace('password',' كلمة المرور'));
                                        $("#passwordError").css("display", "block");
                                    }
                                };
                            },
                        });
                    });
                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection
