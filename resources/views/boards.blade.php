@extends('appLayouts.app')
@section('content')
<div class="container">
    <div class="d-flex flex-row flex-wrap justify-content-center">
        <div id="1" style="overflow: hidden;order:301" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="1" style="animation-delay: 0.1s"  class="animate-fade-in-down"></board></div>
        <div id="2" style="overflow: hidden;order:302" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="2" style="animation-delay: 0.2s"  class="animate-fade-in-down"></board></div>
        <div id="3" style="overflow: hidden;order:303" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="3" style="animation-delay: 0.3s"  class="animate-fade-in-down"></board></div>
        <div id="4" style="overflow: hidden;order:304" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="4" style="animation-delay: 0.4s"  class="animate-fade-in-down"></board></div>
        <div id="5" style="overflow: hidden;order:305" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="5" style="animation-delay: 0.5s"  class="animate-fade-in-down"></board></div>
        <div id="6" style="overflow: hidden;order:306" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="6" style="animation-delay: 0.6s"  class="animate-fade-in-down"></board></div>
        <div id="7" style="overflow: hidden;order:307" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="7" style="animation-delay: 0.7s"  class="animate-fade-in-down"></board></div>
        <div id="8" style="overflow: hidden;order:308" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="8" style="animation-delay: 0.8s"  class="animate-fade-in-down"></board></div>
        <div id="9" style="overflow: hidden;order:309" class="col-lg-3 col-md-4">   <board status="taken" tablenumber="9" style="animation-delay: 0.9s"  class="animate-fade-in-down"></board></div>
        <div id="10" style="overflow: hidden;order:310" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="10" style="animation-delay: 1.0s"  class="animate-fade-in-down"></board></div>
        <div id="11" style="overflow: hidden;order:311" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="11" style="animation-delay: 1.1s"  class="animate-fade-in-down"></board></div>
        <div id="12" style="overflow: hidden;order:312" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="12" style="animation-delay: 1.2s"  class="animate-fade-in-down"></board></div>
        <div id="13" style="overflow: hidden;order:313" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="13" style="animation-delay: 1.3s"  class="animate-fade-in-down"></board></div>
        <div id="14" style="overflow: hidden;order:314" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="14" style="animation-delay: 1.4s"  class="animate-fade-in-down"></board></div>
        <div id="15" style="overflow: hidden;order:315" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="15" style="animation-delay: 1.5s"  class="animate-fade-in-down"></board></div>
        <div id="16" style="overflow: hidden;order:316" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="16" style="animation-delay: 1.6s"  class="animate-fade-in-down"></board></div>
        <div id="17" style="overflow: hidden;order:317" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="17" style="animation-delay: 1.7s"  class="animate-fade-in-down"></board></div>
        <div id="18" style="overflow: hidden;order:318" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="18" style="animation-delay: 1.8s"  class="animate-fade-in-down"></board></div>
        <div id="19" style="overflow: hidden;order:319" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="19" style="animation-delay: 1.9s"  class="animate-fade-in-down"></board></div>
        <div id="20" style="overflow: hidden;order:320" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="20" style="animation-delay: 2.0s"  class="animate-fade-in-down"></board></div>
        <div id="21" style="overflow: hidden;order:321" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="21" style="animation-delay: 2.1s"  class="animate-fade-in-down"></board></div>
        <div id="22" style="overflow: hidden;order:322" class="col-lg-3 col-md-4">  <board status="taken" tablenumber="22" style="animation-delay: 2.2s"  class="animate-fade-in-down"></board></div>
</div>
</div>
@endsection
@section('styles')
<style >
    :root{
    }
    .container {
        min-width: 700px;
    }
    .d-flex {
        overflow: hidden;
        clip-path: inset(0 0 0 0);

    }
    .col-lg-3{
    }
</style>

@endsection

@section('scripts')
    <script>
        var group = document.querySelector(".d-flex");
        var nodes = document.querySelectorAll(".col-lg-3");
        var total = nodes.length;
        var orderHelper =  Math.pow (10 , parseInt( String(total).length)) ;
        var ease  = Power1.easeInOut;
        var boxes = [];
        var containerPadding = 12; //px

        function numberOfElementsInRows() {
            if (total == 0) throw new Error("no elements"); ;
            var count = 1;

            for (var i = 0; i < total - 1; i++) {
                if (nodes[i].offsetTop !== nodes[i+1].offsetTop){
                    if (i+1==total-1) {
                        break;
                    };
                    continue;
                    }
                count++;
                if (nodes[i+1].offsetTop !== nodes[i+2].offsetTop){
                    break;
                }
            }
            return count;
        }

        function layout(orderChanged) {
            var numberOfElementsInRow = numberOfElementsInRows();
            if (!numberOfElementsInRow) return 0 ;
            for (var i = 0; i < total; i++) {
                var box = boxes[i];
                var isEdge = false;
                var positionReplaced = false ;
                var moveUp = false;
                var rect = box.node.getBoundingClientRect();
                var lastX = box.x;
                var lastY = box.y;
                box.x = box.node.offsetLeft;
                box.y = box.node.offsetTop;
                if (lastX === box.x && lastY === box.y) continue;
                if (box.node.style.order == orderChanged) positionReplaced = true;
                if (lastY !== box.y) {
                    isEdge = true;
                    var substitutional = box.node.cloneNode(true);
                    substitutional.style.position='absolute';
                    substitutional.firstChild.classList.remove("animate-fade-in-down");
                    substitutional.classList.add("temporary-alternative");
                    substitutional.style.top = parseInt(lastY)+'px';
                    substitutional.style.left = parseInt(lastX)+'px';
                    substitutional.style.width= rect.width;
                    substitutional.style.height= rect.height;
                    if (parseInt(box.y) < parseInt(lastY)) moveUp = true;
                }
                var x = box.transform.x + lastX - box.x;
                var y = box.transform.y + lastY - box.y;
                if (!positionReplaced && numberOfElementsInRow > 1) {

                    if (!isEdge) {
                        TweenLite.fromTo(box.node, 1, { x, y }, { x: 0, y: 0 , ease }).delay();
                    }
                    else
                    {
                        group.appendChild(substitutional);
                        var delay = (1*containerPadding) / (parseInt(rect.width) +(containerPadding*2))
                        if (moveUp) {
                            TweenLite.fromTo(substitutional, 1, { x:0 },{ x: (rect.width + 12) , display:'none',ease});
                            TweenLite.fromTo(box.node, 1, { x: -(rect.width + 12) ,y:0}, { x: 0, y: 0 ,ease }).delay(delay);
                        }
                        else  {
                            TweenLite.fromTo(substitutional, 1, { x:0},{ x:-(rect.width + 12),display:'none',ease });
                            TweenLite.fromTo(box.node, 1, { x: (rect.width + 12) ,y:0}, { x: 0, y: 0 ,ease }).delay(delay);
                        }
                    }
                } else {
                    TweenLite.fromTo(box.node, 1, { x, y , zIndex:-99 }, { x: 0, y: 0 ,zIndex:0, ease });
                }


            }
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    resolve('');
                }, 1000);  //longest animation is 1s ;
            })
        }
        function removeTemporaryAlternatives() {
            var temporaryAlternativesNodes = document.querySelectorAll(".temporary-alternative");
            for (var i = 0; i < temporaryAlternativesNodes.length; i++) {
                temporaryAlternativesNodes[i].remove();
            }
        }

        for (var i = 0; i < total; i++) {

        var node = nodes[i];
        TweenLite.set(node, { x: 0});


            boxes[i] = {
                transform: node._gsTransform,
                x: node.offsetLeft,
                y: node.offsetTop,
                order: node.style.order,
                node
            };
        }

        function moveitem(order , tableNumber) {
            var newOrder = order * Math.pow (10 , parseInt( String(total).length)) + parseInt(tableNumber);
            document.getElementById(tableNumber).style.order =  newOrder;
            layout(newOrder).then(()=>{removeTemporaryAlternatives()});
        }
    </script>

@endsection
