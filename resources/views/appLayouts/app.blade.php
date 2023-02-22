<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!--font Amiri-->
    <link  rel="stylesheet" href="{{ asset('/fonts/Amiri/Amiri.css') }}">
    <!--vue.js style-->
    <link  rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <!--bootstap 5 -->
    <link href="{{asset('assets/bootstrap5/css/bootstrap5.css')}}" rel="stylesheet" >
    <!-- style -->
    <link href="{{asset('assets/custom/appLayout/style.css')}}" rel="stylesheet" >
    <!--extended style-->
    <div class="extendedStyles">
        @yield('styles')
    </div>
</head>
<body>
    <div id="app" v-cloak>
        <div class="navbar">
            <navbar url={{ url('/') }}></navbar >
        </div>
        <div class="app-grid">
            <div id="sidebar" class="sidebar">
                <sidebar url={{ url('/') }} src={{asset("images/logo.png")}}></sidebar>
            </div>
            <div class="app-container">
                @yield('content')
            </div>
        </div>
        <div class="footer">
            <page-footer></page-footer>
        </div>
    </div>
    <!--bootstrap 5 -->
    <script  src="{{ asset('assets\bootstrap5\js\bootstrap5.js') }}"></script>
    <!--jquery 5 -->
    <script  src="{{ asset('assets\JQuery\jquery.js') }}"></script>
    <!--GSAP tween lite -->
    <script  src="{{ asset('assets\TweenLite\tweenLite.js') }}"></script>
    <!--vue.js-->
    <script  src="{{ mix('/js/app.js') }}"></script>
    <!--sweet alert-->
    <script  src="{{ asset('assets\sweetAlert\main.js') }}"></script>
    <!--scripts-->
    <script  src="{{ asset('assets/custom/appLayout/scripts.js') }}"></script>
    <!--extended scripts-->
    <div class="extendedScripts">
        @yield('scripts')
    </div>
</body>


</html>

