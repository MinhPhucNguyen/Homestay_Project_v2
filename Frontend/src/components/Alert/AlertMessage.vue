<template>
   <div class="alert alert-dismissible fade show p-2" :class="'alert-' + type" role="alert">
      <strong> <slot></slot></strong>
      <button type="button" @click="$emit('closeAlert')" class="btn-close" style="padding: 1rem 1rem;" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
</template>

<script>
export default {
   name: "AlertMessage",
   props: {
      type: {
         type: String,
         required: true,
      },
   },
};
</script>

<style></style>
