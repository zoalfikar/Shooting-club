@extends('appLayouts.app')
@section('styles')
<style>

</style>

@endsection
@section('content')
    <setting></setting>
@endsection


@section('scripts')
    <script>
           function init() {
                $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });

                }
            $(document).ready(function() {
                init()
            });
    </script>
@endsection
