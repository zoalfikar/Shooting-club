<template>
    <div class="container">
        <div class="boards-header-wrapper" style="position:relative">
            <header  class="boards-header">
                <div class="filter">
                    <div @click="showAll" title="عرض الكل" class="showAll stateFilter stateFilterSelected"></div>
                    <div @click="showEmpty" title="عرض الطاولات المتاحة" class="empty stateFilter"></div>
                    <div  @click="showActive" title="عرض الطاولات المشغولة" class="active stateFilter"></div>
                    <div  @click="showReserved" title="عرض الطاولات المحجوزة" class="reserved stateFilter"></div>
                </div>
                <div class="filter2">
                        <div class="customer-name-filter"><input v-model="currentCustomerNameFilter" type="text"  name="" id="" placeholder="اسم الزبون"><i @click="resetCustonmerNameInput" class="fa fa-close close"></i></div>
                        <div class="table-number-filter"><input v-model="currentTableNameFilter" type="number" placeholder=" الطاولة"></div>
                </div>
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
            <div  @click="toggleHeader" class="toggle-boards-header"><span><i class="fa fa-angle-double-up"></i></span></div>
        </div>
       <div  v-if="noHalls" class="noHalls">
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
            <div   v-for="(board,index) in boards"
            v-bind:key="`${'h:'+currentHall+'t:'+board.tableNumber}`"
            :id="`${'h:'+currentHall+'t:'+board.tableNumber}`"
            :style=" 
            `order:${currentHallActive? board.active ? board.order : orderHelper *10+ board.tableNumber : board.order};
            display:${ board.extra.filterShow ? 'block' : 'none' }`
            "
            :class="`${'col-lg-3 col-md-4 h'+currentHall} boardContainter`">
                <board
                    :currentHallActive="currentHallActive" 
                    :table-number="board.tableNumber"
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
                headerFolded : false ,
                currentButtun:0,
                boxes:[],
                nodes:'',
                total:0,
                orderHelper:0,
                currentFilterVal:"all",
                currentCustomerNameFilter:"",
                currentTableNameFilter:null,
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
                    this.total= this.nodes.length;
                    this.orderHelper= Math.pow (10 , parseInt( String(this.total).length));
                    return this.getNewNods(this.nodes).then((nodes) => {
                        this.initBoardsPositions ();
                        this.filter()
                    });
                });
            },
            currentFilterVal:
            {
                immediate:true,
                handler:function(newVal, oldVal){
                this.filter()
                }
            },
            currentCustomerNameFilter:
            {
                immediate:true,
                handler:function(newVal, oldVal){
                this.filter()
                }
            },
            currentTableNameFilter:
            {
                immediate:true,
                handler:function(newVal, oldVal){
                this.filter()
                }
            },
        },
        methods:{
        //test
            // switchArrayPistion:function(index1,index2){
            //     store.dispatch('switchArrayPistion' , {"index1":index1,"index2":index2});
            // },
            // addElement:function(index1){
            //     store.dispatch('addElement' , {"x":index1});

            // },
        //
        
            toggleHeader:function(){
                var  animationProps = 
                [
                    { clipPath: "inset(0px 0px 0px 0px)" , minHeight: '70px' , height : '70px'},
                    { clipPath: "inset(0px 0px 100% 0px)" , minHeight: '0' , height : '0'}
                ];
                $('.toggle-boards-header').toggleClass('rotate-toggle-boards-header');
                if (this.headerFolded) {
                    this.headerFolded = false;
                    document.querySelector('.boards-header').animate( animationProps, 
                        {
                            duration: 500,
                            iterations: 1,
                            fill:'forwards',
                            direction:'reverse'
                        }
                    )
                } else {
                    this.headerFolded = true;
                    document.querySelector('.boards-header').animate( animationProps, 
                        {
                            duration: 500,
                            iterations: 1,
                            fill:'forwards',
                            direction:'normal'
                        }
                    )
                }
             
            },
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
            showAll:function(e){
                $('.stateFilter').removeClass('stateFilterSelected');
                $(e.target).addClass('stateFilterSelected');
                this.currentFilterVal='all'
            },
            showEmpty:function(e){
                $('.stateFilter').removeClass('stateFilterSelected');
                $(e.target).addClass('stateFilterSelected');
                this.currentFilterVal=''
            },
            showActive:function(e){
                $('.stateFilter').removeClass('stateFilterSelected');
                $(e.target).addClass('stateFilterSelected');
                this.currentFilterVal='active'
            },
            showReserved:function(e){
                $('.stateFilter').removeClass('stateFilterSelected');
                $(e.target).addClass('stateFilterSelected');
                this.currentFilterVal='taken'
            },
            bringHalls:function (event) {
                event.preventDefault();
                var target = event.target ;
                if (target.tagName == 'SPAN') {
                    target = event.target.parentElement
                }
                sessionStorage.setItem('currentResturantHall',target.value);
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
            },
            resetCustonmerNameInput:function() {
                this.currentCustomerNameFilter = "";
            },
            filter:function(){
                return this.boards.map((board) =>{
                    var condition =   
                    ( this.currentTableNameFilter == board.tableNumber ||
                    ( !this.currentTableNameFilter  &&
                    (( String( board.customerInfo.customerName).indexOf(this.currentCustomerNameFilter) == 0 && this.currentCustomerNameFilter !== '')  || 
                    ( this.currentCustomerNameFilter == '' && 
                    ( this.currentFilterVal == 'all' || 
                    this.currentFilterVal == board.status )))))
                    board.extra.filterShow = condition
                })
            },
        },

        mounted: function () {
                Echo.channel('board-status')
                .listen('BoardChangeStatus', (e) => {
                    if (e.hall == this.currentHall) {
                        store.commit('setBoardStateRealTimeTest',{'tableNumber':e.board , "status": e.status})
                    }
                })
        window.addEventListener('resize',(e)=>{ this.initBoardsPositions()}  );
        $(document).ready(function () {

            store.dispatch("pringAllHalls")
            store.dispatch("bringAllMenuItems")
            if (sessionStorage.currentResturantHall) {
                setTimeout(() => {
                    $('.naviga-link').filter(function(){return this.value == parseInt(sessionStorage.getItem('currentResturantHall'))}).click();
                }, 1000);
                    
            }
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
        padding-right: 220px;
          box-sizing: border-box !important;
          position: relative;
          margin-top: 10px;
          min-height: 70px;
          display:  flex;
          justify-content: space-evenly;
          align-items: center;
          background-color: hsla(120, 100%, 13%, 0.4);
          transition: height 10s ease-in-out;
      }
      .toggle-boards-header{
            display: flex;
            justify-content: center;
            align-items: center;
            right: 10px;
            bottom: 5px;
            position: absolute;
            height: 20px;
            width:  20px;
            overflow: visible;
            color:white;
            transform: rotate(0);
            transition: transform 0.2s ease-in-out , bottom 0.7s ease-in-out ;
            z-index:4;
      }
      .toggle-boards-header:hover{
            color: rgb(77, 255, 115);
            border-radius: 100%;
            background: rgba(0, 0, 0 , 0.4);
            transform: translateY(-4px)
        }
        .rotate-toggle-boards-header{
            bottom: -10px;
            transform: rotate(180deg);
        }
      .rotate-toggle-boards-header.toggle-boards-header:hover{
          color: rgb(77, 255, 115);
          transform:  rotate(180deg) translate(0px, -4px);
        }        

      .hall-navigation{
            overflow: hidden;
            height: 70px;
            align-items: center;
            display: flex;
            justify-content: center;
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
            height: 70%;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
            font-weight: bold;
            color:hsl(0, 9%, 27%);
            text-align:center;
            width: 310px;
            background-color: rgba(200,200, 200, 0.7);
            border-radius: 10px;
            padding-right: 13px;
            padding-left: 13px;
        }
        .current-nav-val h1{
            margin: auto;
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
    .filter{
        display:flex;
        position:absolute;
        width:125px;
        height:30px;
        justify-content: space-between;
        align-items:top;
        inset:7px 53px auto auto ;
    }
    .filter2{
        display:flex;
        position:absolute;
        width:130px;
        height:30px;
        justify-content: space-between;
        align-items:top;
        inset:auto 50px 2px auto ;
    }
    .filter2 input{
       background-color:rgba(200,200,200,0.7);
       border-radius:5px;
       box-shadow: 0px 1px  4px black;

    }
    .filter2 input[type=text]{
        width:80px;
        padding-right:4px;
    }
    .filter2 input[type=text]::-webkit-input-placeholder {
        font-size: 14px;
    }
    .filter2 input[type=number]{
        width:40px;
    }
    .filter2 input[type=number]::-webkit-input-placeholder {
        font-size: 14px;
    }
    .filter2 input[type=number]::-webkit-inner-spin-button
    {
        appearance: none;
    }
    .customer-name-filter i {
        display:none;
        transform: translateX(calc(100% + 4px));
    }
    .customer-name-filter:hover i {
        display:inline-block;
    }
    .reserved ,.active  ,.empty , .showAll{
        width:20px;
        height:20px;
        border-radius:3px;
        box-shadow: 0px 1px  2px black;
    }
    .reserved:hover ,.active:hover  ,.empty:hover ,.showAll:hover{
        transform:scale(1.3);
        outline-style:solid ;
        outline-offset: 2px;
        outline-color: rgb(100, 100, 70);
        outline-width: 1px;
    }
    .filter-clicked{
        outline-style:solid ;
        outline-offset: 0px;
        outline-color: rgba(60, 50, 70 ,0.5);
        outline-width: 4px;
    }
    .showAll{
        background-color: rgb(215, 172, 102)
    }
    .showAll:hover{
        background-color: rgb(200, 150, 90)
    }
    .active {
        background-color: rgb(119, 82, 82)
    }
    .active:hover {
        background-color: rgb(110, 70, 70)
    }
    .reserved {
        background-color: rgb(66, 21, 21)
    }
    .reserved:hover {
        background-color: rgb(50, 10, 10)
    }
    .empty{
        background-color:  rgb(151, 130, 151)
    }
    .empty:hover{
        background-color:  rgb(131, 120, 140)
    }
    .stateFilterSelected{
        border:2px solid rgba(255, 225, 225, 0.7);
    }
    @media only screen and (max-device-width: 1024px) and (orientation:landscape) {
        .boards-header{
            box-sizing: border-box !important;
            width: 100%;
            position: relative;
            margin-top: 10px;
            min-height: 70px;
  
            display:  flex;
            align-items: center;
            background-color: hsla(120, 100%, 13%, 0.4);
            transition: height 10s ease-in-out;
            flex-grow: 1;
        }
        .container {
            max-width: 100% !important;
            width: 100%;
            align-self :stretch;
            min-width: 700px;
        }

        .boardContainter{
            width: 25% !important;
            max-width: 25% !important;
        }
    }
  </style>
