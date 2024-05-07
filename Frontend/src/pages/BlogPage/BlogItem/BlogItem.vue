<template>
  <router-link :to="`blog/${blog.blog.slug}`" class="blog-item">
    <div class="blog-img">
      <img :src="blog.blog.image" alt="blog-img" />
    </div>
    <h5>{{ blog.blog.title }}</h5>
    <div class="disc">
      <p>
        {{ blog.getDisc }}
      </p>
    </div>
  </router-link>
</template>

<script setup>
const props = defineProps({
  blog: {
    type: Object,
  },
});
</script>

<style scoped>
@import "./BlogItem.scss";
</style>
