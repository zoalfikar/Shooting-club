<template>
    <v-card
      class="mx-auto"
      color="#2116da"
      dark
      max-width="400"
    >
      <v-card-title>
        <span class="text-h6 font-weight-light">الطاولة رقم 1</span>
      </v-card-title>
      <v-card-subtitle>الحالة : مشغولة / محجوزة / متوفرة</v-card-subtitle>
      <v-card-subtitle>محجوزة باسم:الاسم الثلاثي</v-card-subtitle>
      <v-card-subtitle>محجوزة بتاريخ : سنة / شهر / يوم</v-card-subtitle>
      <v-card-subtitle>الحالة الفنية : مفعلة / خارج الخدمة</v-card-subtitle>
      <v-card-actions>
      <v-btn
        text
        color="teal accent-4"
        @click="reveal = true"
      >
        Learn More
      </v-btn>
    </v-card-actions>

    <v-expand-transition>
      <v-card
        v-if="reveal"
        class="transition-fast-in-fast-out v-card--reveal"
        style="height: 100%;"
      >
        <v-card-text class="pb-0">
          <p class="text-h4 text--primary">
            Origin
          </p>
          <p>late 16th century (as a noun denoting a place where alms were distributed): from medieval Latin eleemosynarius, from late Latin eleemosyna ‘alms’, from Greek eleēmosunē ‘compassion’ </p>
        </v-card-text>
        <v-card-actions class="pt-0">
          <v-btn
            text
            color="teal accent-4"
            @click="reveal = false"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-expand-transition>

    </v-card>
  </template>

<script>
export default {
    data: () => ({
      reveal: false,
    }),
}
</script>

<style scoped>
    .v-card{
        box-shadow:0 0 black;
        top:0;
        opacity: 1;
        transition: top ease-in-out 0.2s , box-shadow ease-in-out 0.2s , opacity ease-in-out 0.2s ;
    }
    .v-card:hover{
        top: 10px;
        box-shadow:0 0 10px black;
        opacity: 0.5;

    }

</style>
