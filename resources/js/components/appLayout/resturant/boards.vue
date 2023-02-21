<template>
    <div class="container">
      <header class="boards-header">
          <div class="toggle-boards-header"><span><i class="fa fa-angle-double-up"></i></span></div>
          <div class="hall-navigation">
              <div class="navigations-title">
                  <h4>الصالة :</h4>
              </div>
              <button value="" class="naviga-link-start"><span href=""><i class="fa fa-angle-right"></i></span></button>
              <div class="navigations-links">
                  <button @click="(event)=>{bringHalls(event)}" v-for="hall in halls" :key="hall.hallNumber" :value="hall.hallNumber" class="naviga-link"  :style=" `background-color:${ hall.hallNumber == currentButtun ? 'rgb(199, 176, 146)':'rgb(90, 117, 65)'} `"><span>{{hall.hallNumber}}</span></button>
              </div>
              <button value="" class="naviga-link-end"><span href=""><i class="fa fa-angle-left"></i></span></button>
          </div>
          <div  class="current-nav-val">
              <h1>{{currentHallName}}</h1>
          </div>
      </header>
    <div v-if="noHalls" class="noHalls">
        <h1>لاتوجد صالات حتى الان</h1>
        <v-btn onClick="navigatTo(event,this)" href="show-new-hall-form" dark>أدخل بيانات صالة</v-btn>
    </div>
    <div v-if="loading" class="flex justify-center">تحميل ...</div>
      <div v-else class="d-flex flex-row flex-wrap justify-content-center">
        <div v-if="noBoards" class="noHalls">
            <h1>لاتوجد طاولات في هذه الصالة حتى الان</h1>
            <v-btn dark onClick="navigatTo(event,this)" href="show-new-table-form" >أضف طاولات جديدة</v-btn>
        </div>
        <div v-if="!currentHallActive" class="flex justify-center col-lg-12 col-md-12">هذه الصالة للعرض فقط (غير جاهة)</div>
          <div  v-for="(board,index) in boards"
              v-bind:key="`${'h:'+currentHall+'t:'+board.tableNumber}`"
              :id="`${'h:'+currentHall+'t:'+board.tableNumber}`"
              :style=" `order:${currentHallActive? board.active ? board.order : orderHelper *10+ board.tableNumber : board.order}`"
              :class="`${'col-lg-3 col-md-4 h'+currentHall}`">
                  <board
                        :index="index"
                      :active="currentHallActive ? board.active : 0"
                      :status="board.status"
                      :tablenumber="board.tableNumber"
                      :style="`animation-delay: ${(index) * 0.1}s`"
                      class="animate-fade-in-down"
                      @statusChanged="(data)=>moveitem(data)" >
                  </board>
          </div>
      </div>
      <board-modal></board-modal>
      <info-modal  @statusChanged="(data)=>moveitem(data)"></info-modal>
  </div>
  </template>

<script>
import store from '../../../store';
      export default {
          emits:['statusChanged'],
          data(){
              return{
                currentButtun:0,
                boxes:[],
                nodes:'',
                total:0,
                orderHelper:0,
              }
          },

         computed: {
                layoutWorker:()=> new Worker("assets/custom/appLayout/resturant/boards/workers/layoutWorker.js"),
                halls: ()=> store.state.halls,
                currentHall: ()=> store.state.currentHall,
                currentHallName: ()=> store.state.currentHallName,
                currentHallActive: ()=> store.state.currentHallActive,
                noHalls: ()=> store.state.noHalls,
                boards: ()=> store.state.boards,
                noBoards: ()=> store.state.noBoards,
                loading : ()=>store.state.boardsLoading,
                header: function () {
                    return this.$el.querySelector(".boards-header")
                },
                headerIsExpended: ()=> true,
                group: function () {
                    return this.$el.querySelector(".d-flex")
                },
                rectContainer : function () {
                    return this.$el.getBoundingClientRect()
                },
                containerPadding: function () {
                    return  (getComputedStyle(this.$el).padding).replace('px','')
                },
                ease: ()=> Power1.easeInOut ,

          },
        watch: {
            boards(newVal, oldVal) {
                this.showHallName();
                this.getNewBoards(newVal).then((value) => {

                    
                    this.nodes = this.group.querySelectorAll(".h"+this.currentHall);
                    // this.layoutWorker.postMessage({ cmd: 'doDomStuff', data: this.group.style });
                    this.total= this.nodes.length;
                    this.orderHelper= Math.pow (10 , parseInt( String(this.total).length));
                    return this.getNewNods(this.nodes).then((value) => {
                        this.initBoardsPositions ();
                    });
                });
            },
        },
          methods:{

            getNewBoards:function(boards){
                return new Promise((resolve, reject) => {
                    resolve(boards);
                });
            },
            getNewNods:function(nodes){
                return new Promise((resolve, reject) => {
                    resolve(nodes);
                });
            },
            bringHalls:function (event) {
                    event.preventDefault();
                    var target = event.target ;
                    if (target.tagName == 'SPAN') {
                        target = event.target.parentElement
                    }
                    this.currentButtun = target.value;

                    this.$el.querySelector(".current-nav-val").animate([
                    { clipPath  : getComputedStyle(this.$el.querySelector(".current-nav-val")).clipPath },
                    { clipPath  : "inset(0% 0% 0% 100%)", }
                    ],
                    {
                        duration: 300,
                        fill: 'forwards'
                    })

                        setTimeout(() => {
                            store.dispatch("changeCurrentHallNumber",target.value)
                            store.dispatch("pringAllBoardsInThisHall",target.value)
                        }, 300);

            },
            showHallName:function(){
                this.$el.querySelector(".current-nav-val").animate([
                    { clipPath  : "inset(0% 0% 0% 100%)" },
                    { clipPath  : "inset(0% 0% 0% 0%)", }
                    ],
                    {
                        duration: 300,
                        fill: 'forwards'
                })
            },

            numberOfElementsInRows: function () {
                  if (this.total == 0) throw new Error("no elements"); ;
                  var count = 1;

                  for (var i = 0; i < this.total - 1; i++) {
                      if (this.nodes[i].offsetTop !== this.nodes[i+1].offsetTop){
                          if (i+1==this.total-1) {
                              break;
                          };
                          continue;
                          }
                      count++;
                      if (this.nodes[i+1].offsetTop !== this.nodes[i+2].offsetTop){
                          break;
                      }
                  }
                  return count;
            },
            layout:function(orderChanged) {
                var numberOfElementsInRow = this.numberOfElementsInRows();
                if (!numberOfElementsInRow) return 0 ;
                for (var i = 0; i < this.total; i++) {
                    var box = this.boxes[i];
                    var isEdge = false;
                    var positionReplaced = false ;
                    var moveUp = false;
                    var rect = box.node.getBoundingClientRect();
                    var lastX = box.x;
                    var lastY = box.y;
                    var ease = this.ease;
                    box.x = box.node.offsetLeft;
                    box.y = box.node.offsetTop;
                    if (lastX === box.x && lastY === box.y) continue;
                    if (orderChanged.includes(parseInt(box.node.style.order))) positionReplaced = true;
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
                        var duration ;
                        if (!isEdge) {
                            duration = parseInt(Math.round(parseInt(Math.abs(x))/parseInt(rect.width)));
                            TweenLite.fromTo(box.node, duration, { x:x, y:y }, { x: 0, y: 0 , ease }).delay();
                        }
                        else
                        {
                            this.group.appendChild(substitutional);
                            var substitutionalRect = substitutional.getBoundingClientRect();
                            var delay ;
                            var distanceOFedgeSubstitutionalRect;
                            var distanceSubstitutionalRect;
                            var distance;
                            var durationSubstitutional ;
                            if (moveUp) {
                            distance = parseInt(rect.right) - parseInt(this.rectContainer.left);
                            duration = parseInt(Math.round(parseInt(distance)/parseInt(rect.width)))
                            distanceSubstitutionalRect=parseInt(this.rectContainer.right) - parseInt(substitutionalRect.left);
                            durationSubstitutional=parseInt(Math.round(parseInt(distanceSubstitutionalRect)/parseInt(substitutionalRect.width)));
                            distanceOFedgeSubstitutionalRect =parseInt(this.rectContainer.right) - parseInt(substitutionalRect.right);
                            delay = (parseInt(durationSubstitutional)*parseInt(distanceOFedgeSubstitutionalRect)) / parseInt(distanceSubstitutionalRect);
                            TweenLite.fromTo(substitutional, durationSubstitutional, { x:0 },{ x: (distanceSubstitutionalRect) , display:'none',ease});
                            TweenLite.fromTo(box.node, duration, { x: -(distance) ,y:0}, { x: 0, y: 0 ,ease }).delay(delay);
                            }
                            else  {
                            distance = parseInt(this.rectContainer.right) - parseInt(rect.left);
                            duration = parseInt(Math.round(parseInt(distance)/parseInt(rect.width)));
                            distanceSubstitutionalRect=parseInt(substitutionalRect.right)-parseInt(this.rectContainer.left) ;
                            durationSubstitutional=parseInt(Math.round(parseInt(distanceSubstitutionalRect)/parseInt(substitutionalRect.width)))
                            distanceOFedgeSubstitutionalRect =parseInt(substitutionalRect.left)-parseInt(this.rectContainer.left) ;
                            delay = (parseInt(durationSubstitutional)*parseInt(distanceOFedgeSubstitutionalRect)) / parseInt(distanceSubstitutionalRect);
                            TweenLite.fromTo(substitutional, durationSubstitutional, { x:0},{ x:-(distanceSubstitutionalRect),display:'none',ease });
                            TweenLite.fromTo(box.node, duration, { x: (distance) ,y:0}, { x: 0, y: 0 ,ease }).delay(delay);


                            }
                        }
                    } else {
                        duration = parseInt(Math.round(parseInt(Math.abs(y))/parseInt(rect.height))*0.2 + 1);
                        TweenLite.fromTo(box.node, duration , { x:x, y:y , zIndex:-9 }, { x: 0, y: 0 ,zIndex:0, ease });
                    }

                }
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve('');

                    }, (numberOfElementsInRow * 1000));  //longest animation
                })
            },
            initBoardsPositions : function () {
                for (var i = 0; i < this.total; i++) {
                    var node = this.nodes[i];
                    TweenLite.set(node, { x: 0 , y:0});
                        this.boxes[i] = {
                            transform: node._gsTransform,
                            x: node.offsetLeft,
                            y: node.offsetTop,
                            order: node.style.order,
                            node
                        };
                }
            },
            removeTemporaryAlternatives:function () {
                var temporaryAlternativesNodes = this.$el.querySelectorAll(".temporary-alternative");
                for (var i = 0; i < temporaryAlternativesNodes.length; i++) {
                    if (temporaryAlternativesNodes[i].getBoundingClientRect().right <=temporaryAlternativesNodes[i].parentElement.getBoundingClientRect().left || temporaryAlternativesNodes[i].getBoundingClientRect().left >=temporaryAlternativesNodes[i].parentElement.getBoundingClientRect().right) {
                        temporaryAlternativesNodes[i].remove();
                    }
                }
            },
            moveitem: function (data) {
                var array=[];
                var e = document.getElementById('h:'+this.currentHall+'t:'+data.tableNumber);
                // var newOrder = data.order * Math.pow (10 , parseInt( String(this.total).length)) + parseInt(data.tableNumber);
                var newOrder = data.order * this.orderHelper + parseInt(data.tableNumber);
                // document.getElementById('h:'+this.currentHall+'t:'+data.tableNumber).style.order =  newOrder;
                e.style.order =  newOrder;
                array.push(newOrder)
                this.layout(array).then(()=>{this.removeTemporaryAlternatives()});
            }
          },
          mounted: function () {
            window.addEventListener('resize',(e)=>{ this.initBoardsPositions()}  );
            $(document).ready(function () {

                store.dispatch("pringAllHalls")
                store.dispatch("bringAllMenuItems")
                const scrollLef = ()=>{
                document.querySelector('.navigations-links').scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
                }
                const scrollRigh = ()=>{
                document.querySelector('.navigations-links').scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
                }
                $('.naviga-link-end').click(function (e) {
                e.preventDefault();
                scrollLef();
                });
                $('.naviga-link-start').click(function (e) {
                e.preventDefault();
                scrollRigh();

                });
            });
            // setTimeout(() => {
            //     if (this.boards == null) {
            //         $( ".naviga-link" ).first().trigger('click');
            //     }
            // }, 2000);
          }
      }
  </script>

  <style scoped >
      /* :root{
      } */
      .container {
          align-self :stretch;
          min-width: 700px;
      }
      .boards-header{
          box-sizing: border-box !important;
          position: relative;
          margin-top: 10px;
          min-height: 70px;

          display:  flex;
          align-items: center;
          background-color: hsla(120, 100%, 13%, 0.4);
          transition: height 10s ease-in-out;
          flex-grow: 1;
      }
      @keyframes animate-header{
          from{height:unset ;}
          to{height:0 ;}
      }
      .hide-header{
          animation: animate-header 0.3s ease-in-out ;
          animation-fill-mode: forwards;
      }
      .toggle-boards-header{
          right: 10px;
          bottom: 5px;
          position: absolute;
          height: 20px;
          width:  20px;
          transition: transform 0.2s ease-in-out ;
          overflow: visible;
          color:white;
          transform: rotate(0);
      }
      .rotate-toggle-boards-header{
          transform: rotate(180deg);
      }
      /* .boards-header-collapse .toggle-boards-header{
          transform: rotate(180deg);
      } */
      .toggle-boards-header:hover{
          transform: translateY(-4px)
      }
      .rotate-toggle-boards-header.toggle-boards-header:hover{
          color: blue;
          transform: rotate(180deg);
      }

      .hall-navigation{
        padding-right: 100px;
          overflow: hidden;
          height: 70px;
          align-items: center;
          flex-grow: 1;
          display: flex;
          justify-content: center;
          width:80%;
      }

      .navigations-links{
          height: 70px;
          position: relative;
          display: flex;
          padding-left:10px;
          padding-right:10px;
          gap: 10px;
          align-items: center;
          width: 210px;
          overflow: scroll ;
      }
      .navigations-links::-webkit-scrollbar{
        display: none;
      }


      .naviga-link{
          border-radius: 100%;
          color: beige;
          min-width: 40px;
          height: 40px;
          display: flex;
          transition: transform 0.2s ease-in-out , background-color  0.3s ease-out;
      }
      .naviga-link-end , .naviga-link-start{
          border-radius: 20%;
          background-color: rgb(65, 77, 54);
          color: beige;
          width: 40px;
          height: 30px;
          display: flex;
          padding-bottom: 3px;
          transition: transform 0.2s ease-in-out;
      }
      .naviga-link:hover,.naviga-link-end:hover ,.naviga-link-start:hover{
          transform: scale(1.2) ;
          cursor: pointer;
      }
      /* .naviga-link:active{
        transform: translateY(-4px)
      } */
      .naviga-link span , .naviga-link-start span,.naviga-link-end span{
          margin: auto;
      }
      .navigations-title{
          position: relative;
          overflow: hidden;
          padding-top: 3px;
          margin-left: 10px;
          color:hsl(0, 9%, 27%);

      }
      .current-nav-val{
        white-space: nowrap;
          overflow: hidden;
          position: relative;
          height: inherit;
          font-weight: bold;
          color:hsl(0, 9%, 27%);
          flex-grow: 1;
          text-align:center;
          width:20%;
    }
    .noHalls{
        background-color: red;
        color: white;
        width: 100%;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }
      .d-flex {
          overflow: hidden;
          clip-path: inset(0 0 0 0);
      }
  </style>
