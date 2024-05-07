<template>
   <div class="blog-page w-100 h-100">
      <div class="blog-container">
         <h1 class="blog-title fw-bold">CA<span style="color: #1cc88a">R</span>ENTAL BLOG</h1>
         <div v-if="allBlogList.length > 0">
            <div class="blog-latest w-100 d-flex">
               <div class="blog-latest-main">
                  <router-link :to="`blog/${mainLatestBlog.slug}`" class="d-inline-block w-100">
                     <img :src="mainLatestBlog.image" alt="blog-image" class="w-100" />
                     <h5>{{ mainLatestBlog.title }}</h5>
                  </router-link>
                  <div class="disc">
                     <p>
                        {{ getDisc(mainLatestBlog.content) }}
                     </p>
                  </div>
               </div>
               <div class="blog-latest-other">
                  <router-link
                     :to="`blog/${blog.slug}`"
                     v-for="blog in otherBlogs"
                     :key="blog.blog_id"
                     class="blog-latest-other-item"
                  >
                     <div class="latest-image">
                        <img :src="blog.image" alt="blog-image" />
                     </div>
                     <div class="content">
                        <h6>{{ blog.title }}</h6>
                        <div class="disc">
                           <p>
                              {{ getDisc(blog.content) }}
                           </p>
                        </div>
                     </div>
                  </router-link>
               </div>
            </div>
            <div class="blog-content">
               <div class="blog-content-inner">
                  <blog-item
                     v-for="blog in allBlogList"
                     :key="blog.blog_id"
                     :blog="{
                        blog: blog,
                        getDisc: getDisc(blog.content),
                     }"
                  />
               </div>
            </div>
         </div>
         <div v-else-if="errorMessage">{{ errorMessage }}</div>
         <div v-else>
            <state-loading />
         </div>
      </div>
   </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import axios from "axios";
import BlogItem from "./BlogItem/BlogItem.vue";
import stateLoading from "@/components/Loading/Loading.vue";
const allBlogList = ref([]);
const errorMessage = ref(null);
const mainLatestBlog = ref({});
const otherBlogs = ref([]);

const getAllBlog = async () => {
   try {
      const response = await axios.get("v2/blogs");
      if (response.status === 200) {
         allBlogList.value = response.data.blogs;
      }
   } catch (error) {
      errorMessage.value = error;
   }
};
onMounted(() => getAllBlog());

const getDisc = (item) => {
   // Create a new DOMParser
   const parser = new DOMParser();
   // convert string to HTMLDocument
   const doc = parser.parseFromString(item, "text/html");
   // Get all the <p> elements
   const paragraphs = doc.querySelectorAll("p");
   // Extract the first <> tag and log its content

   if (paragraphs.length > 0) {
      // Extract the innerHTML of the first <p> element
      const firstParagraph = paragraphs[0].innerHTML;
      return firstParagraph;
   } else {
      return ""; // Return an empty string if no <p> elements are found
   }
};

const updateBlogLists = () => {
   if (allBlogList.value.length > 0) {
      mainLatestBlog.value = allBlogList.value[0]; //Lấy item đầu tiên của mảng con
      otherBlogs.value = allBlogList.value.slice(1, 4);
   }
};

watch(allBlogList, () => {
   updateBlogLists();
});
</script>

<style scoped>
@import "./BlogPage.scss";
</style>
