<template>
    <div class="wrapper" >
        <div class="boards-header-wrapper" style="position:relative">
            <header  class="boards-header" :style="`padding-right: ${userRole !== 'acountant'? '0px':''}`">
                <div v-if="userRole == 'acountant'" class="hall-navigation">
                    <div class="navigations-title">
                        <h4>نقطة البيع :</h4>
                    </div>
                    <button value="" class="naviga-link-start"><span href=""><i class="fa fa-angle-right"></i></span></button>
                    <div class="navigations-links">
                        <button @click="(event)=>{bringHalls(event)}" v-for="(salePoint,index) in allSalePoints" :key="salePoint.id" :value="salePoint.id" class="naviga-link"  :style=" `background-color:${ salePoint.id == currentButtun ? 'rgb(199, 176, 146)':'rgb(90, 117, 65)'} `"><span>{{index + 1 }}</span></button>
                    </div>
                    <button value="" class="naviga-link-end"><span href=""><i class="fa fa-angle-left"></i></span></button>
                </div>
                <div  class="current-nav-val">
                    <h1>{{currentSalePointName}}</h1>
                </div>
            </header>
            <div  @click="toggleHeader" class="toggle-boards-header"><span><i class="fa fa-angle-double-up"></i></span></div>
        </div>
        <div v-if="!currentSalePointActive" class="container"
        style="text-align:center !important;font-size:50px;padding-top:15px;display:block">
            هذه النقطة غير مفعلة حاليا
        </div>
        <sale-point-content v-else></sale-point-content>
    </div>
</template>

<script>
import store from '../../../store'
export default {
    data (){
        return{
            headerFolded : false ,
            currentButtun:0,
        }
    },
    computed:{
        userRole:()=>store.state.role,
        allSalePoints: ()=>store.state.salePoints,
        currentSalePoint: ()=> store.state.currentSalePoint,
        currentSalePointName: ()=> store.state.currentSalePointName,
        currentSalePointActive: ()=> store.state.currentSalePointActive,
        loading:()=>store.state.ordersLoading,
        header: function () {
                    return this.$el.querySelector(".boards-header")
                },
        headerIsExpended: ()=> true,
    },
    watch:{
        loading:function(n,o){
            if (!n) {
                this.showSalePointName()
            }
        }
    },
    methods:{
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
        bringHalls:function (event) {
            event.preventDefault();
            var target = event.target ;
            if (target.tagName == 'SPAN') {
                target = event.target.parentElement
            }
            sessionStorage.setItem('currentSalePoint',target.value);
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
                store.dispatch("getSalePoint",target.value)
            }, 300);
        },
        showSalePointName:function(){
            this.$el.querySelector(".current-nav-val").animate([
                { clipPath  : "inset(0% 0% 0% 100%)" },
                { clipPath  : "inset(0% 0% 0% 0%)", }
                ],
                {
                    duration: 300,
                    fill: 'forwards'
            })
        },
    },
   mounted:function () {
        Echo.channel('sale-point-channel').listen('salePointChanged', (e) =>
        {
            if (e.salePoint.id == this.currentSalePoint) {
                store.dispatch('bringAllSalePoints')
            }
        })
        Echo.channel('sale-point-channel').listen('salePointDeleted', (e) =>
        {
            if (e.salePoint.id == this.currentSalePoint) {
                window.location.replace('/logout');
            }
        })
        store.dispatch("bringAllSalePoints")
        store.dispatch('bringAllSalePointMenuItems')
        ///
        var role = this.userRole
        $(document).ready(function () {
            if (role == "acountant") {
                if (sessionStorage.currentSalePoint) {
                    setTimeout(() => {
                        $('.naviga-link').filter(function(){return this.value == parseInt(sessionStorage.getItem('currentSalePoint'))}).click();
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
            }
        });
    }
}
</script>

<style scoped>
    .wrapper{
        margin-top: 20px;
        margin-bottom: 50px;
        background-color: hsl(0, 52%, 6%);
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

    .container{
        width: 1160px;
        min-height: 70vh ;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows:auto;
        padding-top: 0px !important;
        border: 2px solid black;
    }
</style>
