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

          <!-- <v-col cols="12" sm="4">
            <v-card-text class="pt-0">
              <v-btn v-for="icon in icons" :key="icon" class="mx-1 white--text" icon>
                <v-icon size="24px">
                  {{icon}}
                </v-icon>
              </v-btn>
            </v-card-text>
            <v-card-text class="grey--text mt-14">
              Payment Methods:

            </v-card-text>
            <v-toolbar color="transparent" flat >
              <v-spacer></v-spacer>
              <v-icon large>fab fa-cc-visa</v-icon>
              <v-icon class="mx-2" large>fab fa-cc-paypal</v-icon>
            </v-toolbar>
          </v-col> -->
        </v-row>
      </v-card>
    </v-footer>
  </template>

  <script>
  export default {
  data:()=>({
    icons:[
      'mdi-facebook',
      'mdi-twitter',
      'mdi-linkedin',
      'mdi-instagram'
    ]
  })
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
