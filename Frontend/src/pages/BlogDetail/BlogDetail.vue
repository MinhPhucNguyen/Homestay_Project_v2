<template>
   <div v-if="blog">
      <div class="blog-page w-100 h-100 bg-white border-top border-bottom">
         <div class="blog-detail-container">
            <img :src="blog.image" alt="" class="main-blog-image" />
            <div class="blog-detail-content">
               <h1>{{ blog.title }}</h1>
               <strong>Đăng vào: </strong> <span>{{ formatCreatedAt }}</span>
               <div class="content" v-html="blog.content"></div>
            </div>
         </div>
      </div>
   </div>
   <div v-else-if="errorMessage">{{ errorMessage }}</div>
   <div v-else>
      <state-loading />
   </div>
</template>

<script setup>
import stateLoading from "@/components/Loading/Loading.vue";
import { computed, onBeforeMount, ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const blog = ref(null);
const errorMessage = ref("");
const router = useRouter();
const slug = router.currentRoute.value.params.slug;

const getBlogContent = async () => {
   try {
      const response = await axios.get(`/v2/blogs/${slug}`);
      if (response.status === 200) {
         blog.value = response.data.blog;
      }
   } catch (error) {
      errorMessage.value = error;
   }
};

onBeforeMount(() => getBlogContent());

const formatCreatedAt = computed(() => {
   const createdDate = new Date(blog.value.created_at);
   const currentDate = new Date();

   const timeDistance = currentDate.getTime() - createdDate.getTime();
   const daysAgo = Math.floor(timeDistance / (1000 * 3600 * 24));
   const dayDisplay = daysAgo == 0 ? "Hôm nay" : daysAgo == 1 ? "Hôm qua" : `${daysAgo} ngày trước`;
   return dayDisplay;
});
</script>

<style>
.blog-page {
   background: #f5f5f5;
}

.blog-detail-container {
   width: 75%;
   margin: 0 auto;
   padding: 80px 0;
}

.main-blog-image {
   border-radius: 16px;
   width: 100%;
   object-fit: cover;
   height: 600px;
}

.blog-detail-content {
   margin-top: 80px;
   padding: 0 50px;
}

.blog-detail-content h1 {
   line-height: 1.5;
   font-weight: bold;
   font-size: 50px;
   margin-bottom: 50px;
}

.blog-detail-content .content {
   margin-top: 20px;
}

.blog-detail-content > strong {
   color: #1cc88a;
}

.blog-detail-content .content p {
   margin-bottom: 40px;
}

.blog-detail-content .content p img {
   max-width: 800px;
   max-height: 400px;
   object-fit: cover;
}

.blog-detail-content .content h2 {
   font-size: 24px;
}
</style>
