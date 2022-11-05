@extends('appLayouts.app')
@section('content')
    <boards></boards>
@endsection
@section('styles')

@endsection

@section('scripts')
    <script>
            const header = document.querySelector(".boards-header");
            var headerIsExpended=true;
            var group = document.querySelector(".d-flex");
            var nodes = document.querySelectorAll(".col-lg-3");
            var total = nodes.length;
            var orderHelper =  Math.pow (10 , parseInt( String(total).length)) ;
            var ease  = Power1.easeInOut;
            var boxes = [];
            var containerPadding = 12; //px
            window.addEventListener('resize', initBoardsPositions);
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
                    if (temporaryAlternativesNodes[i].getBoundingClientRect().right <=temporaryAlternativesNodes[i].parentElement.getBoundingClientRect().left || temporaryAlternativesNodes[i].getBoundingClientRect().left >=temporaryAlternativesNodes[i].parentElement.getBoundingClientRect().right) {
                        temporaryAlternativesNodes[i].remove();
                    }
                }
            }
            function initBoardsPositions() {
                for (var i = 0; i < total; i++) {
                var node = nodes[i];
                    boxes[i] = {
                        transform: node._gsTransform,
                        x: node.offsetLeft,
                        y: node.offsetTop,
                        order: node.style.order,
                        node
                    };
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
            $(".toggle-boards-header").click(function (e) {
                e.preventDefault();
                $('.boards-header').toggleClass('hide-header');
                $(".toggle-boards-header").toggleClass("rotate-toggle-boards-header")
            });

    </script>
@endsection
