<template>
   <div id="blog-section" class="hidden">
      <div class="section-container">
         <p class="section-title">CA<span style="color: #1cc88a">R</span>ENTAL Blog</p>
         <div class="blog-section-container" v-if="blogSectionList.length > 0">
            <div class="blog-wrap_1">
               <router-link
                  v-for="blogItem in blogSectionList.slice(0, 2)"
                  :key="blogItem.blog_id"
                  :to="`blog/${blogItem.slug}`"
                  class="blog-item"
               >
                  <div class="blog-item_img">
                     <img :src="blogItem.image" alt="blog-image" />
                  </div>
                  <div class="blog-item_content">
                     <p class="time-text text-light mb-0">
                        {{ handleDateCreatedAt(blogItem.created_at) }}
                     </p>
                     <p class="name-text text-light mb-0">{{ blogItem.title }}</p>
                  </div>
               </router-link>
            </div>
            <div class="blog-wrap_2">
               <router-link
                  :to="`blog/${blogSectionList[blogSectionList.length - 1].slug}`"
                  class="blog-item"
                  v-if="blogSectionList[blogSectionList.length - 1]"
               >
                  <div class="blog-item_img">
                     <img
                        :src="blogSectionList[blogSectionList.length - 1].image"
                        alt="blog-image"
                     />
                  </div>
                  <div class="blog-item_content">
                     <p class="time-text text-light mb-0">
                        {{
                           handleDateCreatedAt(
                              blogSectionList[blogSectionList.length - 1].created_at
                           )
                        }}
                     </p>
                     <p class="name-text text-light mb-0">
                        {{ blogSectionList[blogSectionList.length - 1].title }}
                     </p>
                  </div>
               </router-link>
            </div>
         </div>
         <div v-else-if="errorMessage">{{ errorMessage }}</div>
         <div v-else>
            <state-loading />
         </div>
      </div>
   </div>
</template>

<script>
import { onMounted, ref } from "vue";
import axios from "axios";
import stateLoading from "@/components/Loading/Loading.vue";

export default {
   name: "BlogSection",
   components: {
      stateLoading,
   },
   setup() {
      const blogSectionList = ref([]);
      const errorMessage = ref(null);

      const getBlogList = async () => {
         try {
            const response = await axios.get("v2/blogs");
            if (response.status === 200) {
               blogSectionList.value = await response.data.blogs.slice(0, 3);
            }
         } catch (error) {
            errorMessage.value = error;
         }
      };
      onMounted(() => getBlogList());

      const handleDateCreatedAt = (item) => {
         const date = new Date(item);
         const day = date.getDate();
         const month = "0" + (date.getMonth() + 1);
         const year = date.getFullYear();
         return `${day}-${month}-${year}`;
      };

      return {
         blogSectionList,
         errorMessage,
         handleDateCreatedAt,
      };
   },
};
</script>

<style scoped>
@import "../../../assets/styles/MainStyles/HomeStyles.scss";
@import "./BlogSection.scss";
</style>
