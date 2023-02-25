@extends('appLayouts.defaultLayout')
@section('style')
<style>
    body{
        position: relative !important;
    }
    .message{
        position: absolute;
        width:600px;
        height: 400px;
        text-align: center;
        padding-top: 30px;
        background-color: aqua;
        inset: auto auto auto auto;
    }
</style>

@endsection
 <div class="message">
    {{$message}}
 </div>
@section('content')


@endsection

@section('scripts')

@endsection
