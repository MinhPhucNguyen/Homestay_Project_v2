<template>
   <ToastMessage :message="successMessage" />
   <div class="col-md-12">
      <div class="card">
         <div class="card-header bg-transparent border-0">
            <div class="d-inline-block fw-bold text-dark fs-4">Create New Blog</div>
            <router-link :to="{ name: 'admin.blogs' }" class="btn btn-danger fw-bold float-right">
               <i class="fa-solid fa-arrow-left"></i>
               BACK
            </router-link>
         </div>
         <div class="card-body mt-0">
            <form @submit.prevent="createNewBlog">
               <div class="row">
                  <div class="form-group col-md-6">
                     <label class="fw-bold">Title</label>
                     <input
                        type="text"
                        name="title"
                        class="form-control"
                        placeholder="Enter title"
                        v-model="model.title"
                     />
                     <small class="text-danger" v-if="errors.title">{{ errors.title[0] }}</small>
                  </div>
                  <div class="form-group col-md-6">
                     <label class="fw-bold">Slug</label>
                     <input
                        type="text"
                        name="slug"
                        class="form-control"
                        placeholder="Enter slug"
                        v-model="model.slug"
                     />
                     <small class="text-danger" v-if="errors.slug">{{ errors.slug[0] }}</small>
                  </div>
               </div>
               <div class="row">
                  <div class="form-group col-md-6">
                     <label class="fw-bold">Image</label>
                     <input
                        ref="imageInput"
                        type="file"
                        name="image"
                        class="blog-image-input form-control d-none"
                        @change="uploadBlogImage"
                     />
                     <div class="blog-image-container" @click="openImageInput">
                        <img v-if="imageBlogSrc" :src="imageBlogSrc" alt="" class="blog-image" />
                        <i v-else class="fa-solid fa-image fs-2"></i>
                     </div>
                  </div>
                  <div class="form-group mt-4 col-md-6">
                     <label class="fw-bold mr-2">Publish</label>
                     <input type="checkbox" name="status" v-model="isPublish" />
                  </div>
               </div>
               <div class="form-group border-dark border-top mt-4">
                  <label class="mt-4 fw-bold d-block">Blog Content</label>
                  <!--    
                    * The v-model:content="model.content" là một cách viết khác của v-model="model.content"
                    * khi muốn update content thì phải emit event update:content từ component Editor
                    * Nếu viết v-model="model.content" thì sẽ update là emit event update:modelValue với modelValue là props của component Editor 
                 -->
                  <small class="text-danger" v-if="errors.content">{{ errors.content[0] }}</small>
                  <ckeditorComponent
                     v-model="model.content"
                     @update:modelValue="
                        successMessage ? (model.content = '') : (model.content = model.content)
                     "
                  ></ckeditorComponent>
               </div>
               <div class="create-btn">
                  <button type="submit" class="btn btn-success fw-bold p-3 float-end">
                     Create
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>

<script setup>
import ckeditorComponent from "@/components/Editor/index.vue";
import { computed, ref } from "vue";
import axios from "axios";
import ToastMessage from "@/components/Toast/index.vue";

const imageInput = ref(null);
const model = ref({
   title: "",
   slug: "",
   image: null,
   status: 0,
   content: "",
});
const imageBlogSrc = ref(null);

const isPublish = computed({
   get() {
      return model.value.status === 1;
   },
   set(value) {
      model.value.status = value ? 1 : 0;
   },
});

const resetForm = () => {
   model.value.title = "";
   model.value.slug = "";
   model.value.image = null;
   model.value.status = 0;
   model.value.content = "";
   imageBlogSrc.value = null;
   imageInput.value = null;
};

/**
 * TODO: OPEN IMAGE INPUT
 */
const openImageInput = () => {
   imageInput.value.click();
};

/**
 * TODO: UPLOAD BLOG IMAGE
 */
const uploadBlogImage = (event) => {
   const file = event.target.files[0];
   imageBlogSrc.value = URL.createObjectURL(file);
   model.value.image = file;
};

/**
 * TODO: CREATE BLOG
 */
const errors = ref({});
const successMessage = ref(null);
const createNewBlog = async () => {
   const formData = new FormData();
   for (const key in model.value) {
      if (model.value.hasOwnProperty(key)) {
         //Xác định xem đối tượng có chứa thuộc tính được chỉ định hay không
         const value = model.value[key];
         formData.append(key, value);
      }
   }
   await axios
      .post("v2/admin/blogs/create", formData)
      .then((response) => {
         successMessage.value = response.data.message;
         $(".toast").toast("show");
         resetForm();
      })
      .catch((e) => {
         console.log(e);
         if (e.response) {
            errors.value = e.response.data.errors;
         }
      });
};
</script>

<style></style>
