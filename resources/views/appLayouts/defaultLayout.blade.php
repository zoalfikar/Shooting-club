<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- fonts -->
    <link href="{{asset('assets/fonts/fonts.css')}}" rel="stylesheet" >
    <!-- bootstrap-5 Css -->
    <link href="{{asset('assets/bootstrap5/css/bootstrap5.css')}}" rel="stylesheet" >
    <!-- app Css -->
    <link href="{{asset('assets/custom/defaultLayout/style.css')}}" rel="stylesheet" >
    <!-- components style -->
    @yield('style')
</head>
<body>
    <div class="container">

        @yield('content')

    </div>

    @yield('scripts')

</body>
</html>
