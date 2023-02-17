<template>
    <v-footer dark padless>
      <v-card flat tile class="black white--text py-4 px-5" width="100%">
        <v-row>
          <v-col cols="12" sm="3">
            <v-card-text class="white--text pt-0">
              <h5>م.م ذوالفقار ياسر السعد</h5>
            </v-card-text>
            <!-- <v-card-text class="grey--text pt-0">
            إدارة الاتمتة
            </v-card-text> -->
            <!-- <v-toolbar flat color="transparent">
              <h5>دليل</h5>
              <h5 class="ml-4">شروط الاستخدام</h5>
              <h5 class="ml-4">سياسة الخصوصية</h5>
            </v-toolbar> -->

          </v-col>
          <v-col cols="12" sm="3">
            <v-card-text class="white--text pt-0">
              <h5> إدارة الاتمتة</h5>
            </v-card-text>
            <!-- <v-card-text class="grey--text mt-n4">
            Order Status
            </v-card-text> -->
          </v-col>
          <v-col cols="12" sm="3">
            <v-card-text class="white--text pt-0">
              <h5>شروط الاستخدام</h5>
            </v-card-text>
            <!-- <v-card-text class="grey--text mt-n4">
            Careers
            </v-card-text> -->
          </v-col>
          <v-col cols="12" sm="3">
            <v-card-text class="white--text pt-0">
              <h5>&#169; 2022 - 2023</h5>
            </v-card-text>
            <!-- <v-card-text class="grey--text mt-n4">
            Careers
            </v-card-text> -->
          </v-col>
        </v-row>
      </v-card>
    </v-footer>
  </template>

  <script>
  
 
  export default {

  data:()=>({

  }),
  mounted : function(){
      switch (sessionStorage.expanded ==='true') {
          case true:
            document.querySelector('.footer').classList.remove('footer-expended');
            break;
            
            case false:
            document.querySelector('.footer').classList.add('footer-expended');
            break;
        }
      document.addEventListener('sidebarStatusChanged',(e)=>{
        switch (sessionStorage.expanded ==='true') {
          case true:
            document.querySelector('.footer').classList.remove('footer-expended');
            break;
            
            case false:
            document.querySelector('.footer').classList.add('footer-expended');
            break;
        }
      })
    }
  }
  </script>

  <style scoped>
    .v-card__text{
        text-align: center;
    }
    .row {
        margin: auto;
    }
  </style>
