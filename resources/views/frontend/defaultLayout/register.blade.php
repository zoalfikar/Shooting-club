@extends('appLayouts.defaultLayout')
@section('style')
<style>
    #go-login{
        margin-right: 20%;
    }
</style>

@endsection

@section('content')
    <div class="arabic-form">
        <h1 class="text-center"> التسجيل في البرنامج</h1>
        <form action="{{url('register')}}" method="post">
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
            </div>
            <div class="mb-3">
                <label for="passwordConfirme" class="form-label">تاكيد كلمة المرور </label>
                <input type="password" name="passwordConfirme" class="form-control" id="passwordConfirme" value="{{old('passwordConfirme') ? old('passwordConfirme') : ''}}">

                @if(session()->has('errore'))
                    <div class="alert alert-danger mt-1">
                        {{ session()->get('errore') }}
                    </div>
                @endif

            </div>

            <div>
                <button type="submit" class="btn btn-primary w-25">إرسال</button>
                <span id="go-login">إذا كان لديك حساب بالفعل &nbsp; <a href="{{url('show-login')}}" > سجل الدخول </a> </span>
            </div>
          </form>
    </div>

@endsection

@section('scripts')

@endsection
