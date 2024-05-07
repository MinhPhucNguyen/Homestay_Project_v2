<template>
   <li class="places-card">
      <router-link :to="{ name: 'findCar' }">
         <img
            :src="require(`@/assets/images/places-image/${props.place.image}`)"
            :alt="props.place.alt"
            draggable="false"
         />
      </router-link>
   </li>
</template>

<script setup>
const props = defineProps({
   place: {
      type: Object,
      required: true,
   },
});
</script>

<style></style>
