@extends('appLayouts.app')
@section('content')
<div class="container">
    <div class="d-flex flex-row flex-wrap justify-content-center">
        <div id="1" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="1"  style="animationDelay : 0.1s" class="animate-fade-in-down"></board></div>
        <div id="2" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="2"  style="animationDelay : 0.2s" class="animate-fade-in-down"></board></div>
        <div id="3" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="3"  style="animationDelay : 0.3s" class="animate-fade-in-down"></board></div>
        <div id="4" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="4"  style="animationDelay : 0.4s" class="animate-fade-in-down"></board></div>
        <div id="5" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="5"  style="animationDelay : 0.5s" class="animate-fade-in-down"></board></div>
        <div id="6" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="6"  style="animationDelay : 0.6s" class="animate-fade-in-down"></board></div>
        <div id="7" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="7"  style="animationDelay : 0.7s" class="animate-fade-in-down"></board></div>
        <div id="8" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="8"  style="animationDelay : 0.8s" class="animate-fade-in-down"></board></div>
        <div id="9" style="order:1" class="col-lg-3 col-md-4">   <board  tablenumber="9"  style="animationDelay : 0.9s" class="animate-fade-in-down"></board></div>
        <div id="10" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="10"  style="animationDelay : 1.0s" class="animate-fade-in-down"></board></div>
        <div id="11" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="11"  style="animationDelay : 1.1s" class="animate-fade-in-down"></board></div>
        <div id="12" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="12"  style="animationDelay : 1.2s" class="animate-fade-in-down"></board></div>
        <div id="13" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="13"  style="animationDelay : 1.3s" class="animate-fade-in-down"></board></div>
        <div id="14" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="14"  style="animationDelay : 1.4s" class="animate-fade-in-down"></board></div>
        <div id="15" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="15"  style="animationDelay : 1.5s" class="animate-fade-in-down"></board></div>
        <div id="16" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="16"  style="animationDelay : 1.6s" class="animate-fade-in-down"></board></div>
        <div id="17" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="17"  style="animationDelay : 1.7s" class="animate-fade-in-down"></board></div>
        <div id="18" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="18"  style="animationDelay : 1.8s" class="animate-fade-in-down"></board></div>
        <div id="19" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="19"  style="animationDelay : 1.9s" class="animate-fade-in-down"></board></div>
        <div id="20" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="20"  style="animationDelay : 2.0s" class="animate-fade-in-down"></board></div>
        <div id="21" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="21"  style="animationDelay : 2.1s" class="animate-fade-in-down"></board></div>
        <div id="22" style="order:1" class="col-lg-3 col-md-4">  <board  tablenumber="22"  style="animationDelay : 2.2s" class="animate-fade-in-down"></board></div>
</div>
</div>
@endsection
@section('styles')
<style >
    .container {

    }
</style>

@endsection

@section('scripts')
    <script>
var group = document.querySelector(".d-flex");
var nodes = document.querySelectorAll(".col-lg-3");
var total = nodes.length;
var ease  = Power1.easeInOut;
var boxes = [];

for (var i = 0; i < total; i++) {

  var node = nodes[i];
  TweenLite.set(node, { x: 0});

  boxes[i] = {
    transform: node._gsTransform,
    x: node.offsetLeft,
    y: node.offsetTop,
    node
  };
}

function layout() {


  for (var i = 0; i < total; i++) {

    var box = boxes[i];

    var lastX = box.x;
    var lastY = box.y;

    box.x = box.node.offsetLeft;
    box.y = box.node.offsetTop;

    if (lastX === box.x && lastY === box.y) continue;

    var x = box.transform.x + lastX - box.x;
    var y = box.transform.y + lastY - box.y;
    var delay = parseInt('0.' +  (9*(parseInt(box.node.style.order) % 10)));
    TweenLite.fromTo(box.node, 1, { x, y }, { x: 0, y: 0 , ease }).delay(delay);
  }
}




        function moveitem(order , tableNumber) {
            document.getElementById(tableNumber).style.order =  order * Math.pow (10 , parseInt( String(total).length)) + parseInt(tableNumber);
            order * Math.pow (10 , parseInt( String(total).length))
            layout();
        }
    </script>

@endsection
