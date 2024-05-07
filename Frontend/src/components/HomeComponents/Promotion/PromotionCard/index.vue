<template>
   <li class="promotion-card">
      <img
         :src="require(`@/assets/images/promotion-image/${props.promotion.image}`)"
         :alt="props.promotion.image"
         draggable="false"
      />
   </li>
</template>

<script setup>
const props = defineProps({
   promotion: {
      type: Object,
      required: true,
   },
});
</script>

<style></style>
