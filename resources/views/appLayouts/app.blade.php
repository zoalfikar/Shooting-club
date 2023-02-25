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
    @if (Auth::user()->role !== 'acountant')
        <style>
            .sidebar 
            {
                width: 0% !important;
            }
            .footer 
            {
                width: 100% !important;
            }
        </style>
    @endif
</head>
<body>
    <div id="app" v-cloak>
        <div class="navbar">
            <navbar navbar-title="{{$facility}}" url={{ url('/') }}></navbar >
        </div>
        <div class="app-grid">
            <div id="sidebar" class="sidebar">
                @if (Auth::user()->role == 'acountant')
                    <sidebar url={{ url('/') }} src={{asset("images/logo.png")}}></sidebar>
                @endif
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
    <!--EPOS printer-->
    <script  src="{{ asset('assets/printer/epos-2.23.0.js') }}"></script>
    <!--extended scripts-->
    <div class="extendedScripts">
        @yield('scripts')
    </div>
    <script>
        // printer
        var ePosDev = new epson.ePOSDevice();
        function connect() {
            var ipAddress = '192.168.192.168';
            var port = '8008';
            ePosDev.connect(ipAddress, port, callback_connect);
        }
        function callback_connect(resultConnect){
            alert("ok")
            var deviceId = 'local_printer';
            var options = {'crypto' : false, 'buffer' : false};
            if ((resultConnect == 'OK') || (resultConnect == 'SSL_CONNECT_OK')) {
            //Retrieves the Printer object
            ePosDev.createDevice(deviceId, ePosDev.DEVICE_TYPE_PRINTER, options, 
            callback_createDevice);
            }
            else {
                alert(resultConnect)
            //Displays error messages
            }
            var keyboard = null;
            function callback_createDevice(deviceObj, errorCode){
            if (deviceObj === null) {
            //Displays an error message if the system fails to retrieve the Keyboard object
            return;
            }
            keyboard = deviceObj;
            //Registers the key press event
            keyboard.onkeypress = function(response){
            if (response.keycode !== 0) {
            //Displays received messages
            }
            };
            }
        }
        // connect()
        // callback_connect()


    </script>
</body>


</html>

