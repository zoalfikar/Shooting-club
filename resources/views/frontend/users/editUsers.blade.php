@extends('appLayouts.app')
@section('styles')
<style>
 .errore{
    display: none;
 }
 form {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(4, 100px);
    grid-gap: 10px;
}
.grid-item:first-child {
  grid-column: 1 / 3; /* span from grid column line 1 to 3 (i.e., span 2 columns) */
  grid-row: 1 / 3;    /* same concept, but for rows */
}
.grid-item {
  justify-content: center;
  align-items: center;
  font-size: 1.5em;
}
select{
    width: 100%;
    background:rgb(238, 228, 213);
}
</style>

@endsection
@section('content')
<div class="arabic-form" style="margin-top: -40px">
    <h1 class="text-center"> مستخدم جديد  </h1>
    <form action="{{url('/users')}}" method="post">
        @csrf
        <div class="mb-3 grid-item">
            <label for="user" class="form-label">المستخدم</label>
            <select name="user" id="user">
                <option disabled selected value="-1"></option>
                @foreach ($users as $user)
                    <option  value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('users'))
                <div class="bg-danger mt-2 p-3 text-white">
                    @foreach ($errors->get('name') as $errore)
                        {{str_replace("name","الاسم",$errore)}}
                    @endforeach

                </div>
            @endif
            <div id="nameError" class="bg-danger mt-2 p-3 text-white errore">
            </div>
        </div>
        <div class="mb-3 grid-item">
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
        <div class="mb-3 grid-item">
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
        <div class="mb-3 grid-item">
            <label for="role" class="form-label">الصلاحيات</label>
            <select name='role'>
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
            <div class="mb-3 grid-item">
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
        <div class="mb-3 grid-item">
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
            <button id="delete" type="submit" class="btn btn-danger w-25">حذف</button>
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
                    $("#user").change(function (e) { 
                        e.preventDefault();
                        $.ajax({
                            type: "get",
                            url: "/users/"+$('#user').val(),
                            success: function (response) {
                                $("input[name='name']").val(response.user.name)
                                $("input[name='email']").val(response.user.email)
                                $("input[name='password']").val(response.user.password)
                                $("input[name='passwordConfirme']").val(response.user.password)
                                $("input[select='role']").val(response.user.role)
                            }
                        });
                    });
                    $("#delete").click(function (e) { 
                        var id = $('#user').val();
                        e.preventDefault();
                        $.ajax({
                            method: "delete",
                            url: "/users/"+$('#user').val(),
                            success: function (response) {
                                $('#user option').filter(function(){return this.value == id}).remove();
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
                    $("#submit").click(function (e) { 
                        e.preventDefault();
                        $('.errore').css('display', 'none');
                        $.ajax({
                            method: "PUT",
                            url: "/users/"+$('#user').val() ,
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
