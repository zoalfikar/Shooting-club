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
        <h1 class="text-center">تسجيل الدخول</h1>
        <form action="{{url('login')}}" method="post">
            @csrf
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
            @if ($errors->has('error'))
                <div class=" bg-danger mt-2 p-3 text-white">
                    @foreach ($errors->all() as $errore)
                        {{$errore}}
                    @endforeach
                </div>
            @endif
            <div class="mt-2">
                <button type="submit" class="btn btn-primary w-25">سجل الدخول</button>
                <span id="go-login"> إذا كنت لا تملك حساب انشىء&nbsp; <a href="{{url('show-registeration')}}" > حساب</a> </span>
            </div>
          </form>
    </div>

@endsection

@section('scripts')

@endsection
