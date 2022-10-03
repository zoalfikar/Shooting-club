<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!--bootstap 5 -->
    <link href="{{asset('assets\bootstrap5\css\bootstrap5.css')}}" rel="stylesheet" >
    <!--vue.js style-->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <!-- style -->
    <link href="{{asset('assets/custom/appLayout/style.css')}}" rel="stylesheet" >
    <!--extended style-->
    @yield('styles')
</head>
<body>
    <div id="app"  v-cloak>
        <div class="navbar">
            <navbar></navbar>
        </div>
        <div class="app-grid">
                <div class="sidebar">
                    <sidebar url={{ url('/') }} src={{asset("images/logo.png")}}></sidebar>
                </div>
                <div class="app-container">
                    @yield('content')
                </div>
        </div>
    </div>

    <!--bootstrap 5 -->
    <script src="{{ asset('assets\bootstrap5\js\bootstrap5.js') }}"></script>
    <!--jquery 5 -->
    <script src="{{ asset('assets\JQuery\jquery.js') }}"></script>
    <!--vue.js-->
    <script src="{{ mix('/js/app.js') }}"></script>
    <!--scripts-->
    <script src="{{ asset('assets/custom/appLayout/scripts.js') }}"></script>
    <!--extended scripts-->
    @yield('scripts')
</body>


</html>
