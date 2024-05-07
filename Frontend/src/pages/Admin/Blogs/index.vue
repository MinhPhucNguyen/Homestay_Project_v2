<template>
   <ToastMessage :message="successMessage" />

   <div class="col-md-12">
      <div class="card">
         <div class="card-header bg-transparent border-0">
            <div class="d-inline-block fw-bold text-dark fs-4">Blog List</div>
            <router-link :to="{ name: 'blogs.create' }" class="btn btn-success fw-bold float-right">
               <i class="fa-solid fa-plus"></i>
               Add New Blog
            </router-link>
         </div>
         <div class="card-body mt-0">
            <table class="table table-bordered table-striped text-dark fw-bold">
               <thead>
                  <tr class="text-dark">
                     <th>ID</th>
                     <th style="width: 30%">Title</th>
                     <th style="width: 30%">Slug</th>
                     <th>Status</th>
                     <th>Create at</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody id="body-table">
                  <tr v-for="blog in blogsList" :key="blog.blog_id">
                     <td class="text-center">{{ blog.blog_id }}</td>
                     <td class="text-center">{{ blog.title }}</td>
                     <td class="text-center">{{ blog.slug }}</td>
                     <td
                        class="text-center"
                        :class="blog.status === 1 ? 'text-success' : 'text-danger'"
                     >
                        {{ blog.status === 1 ? "Publish" : "Unpublish" }}
                     </td>
                     <td class="text-center">{{ formatDateTime(blog.created_at) }}</td>
                     <td class="text-center">
                        <div class="dropdown">
                           <button
                              class="btn btn-success dropdown-toggle"
                              type="button"
                              data-bs-toggle="dropdown"
                              aria-expanded="false"
                           >
                              Action
                           </button>
                           <ul class="dropdown-menu">
                              <li>
                                 <router-link
                                    :to="{ name: 'blogs.edit', params: { id: blog.blog_id } }"
                                    class="dropdown-item mb-3 fs-6 text-primary bg-white"
                                    href=""
                                 >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="ml-2">Edit</span>
                                 </router-link>
                              </li>
                              <button
                                 type="button"
                                 class="dropdown-item fs-6 text-danger bg-white"
                                 data-bs-toggle="modal"
                                 :data-bs-target="`#deleteBlogModal${blog.blog_id}`"
                              >
                                 <i class="fa-solid fa-trash"></i>
                                 <span class="ml-2">Delete</span>
                              </button>
                           </ul>
                        </div>
                     </td>

                     <!-- Modal Delete Confirm -->
                     <my-modal
                        @clickTo="deleteBlog(blog.blog_id)"
                        :idModal="`deleteBlogModal${blog.blog_id}`"
                        bgColor="danger"
                     >
                        <template v-slot:title>Delete blog</template>
                        <h6 class="text-dark text-center fs-5 mt-4">
                           Are you sure, you want to delete this blog?
                        </h6>
                        <template v-slot:buttonName>
                           <div
                              class="spinner-border"
                              role="status"
                              style="width: 24px; height: 24px; margin-right: 10px"
                              v-if="isLoading"
                           >
                              <span class="visually-hidden">Loading...</span>
                           </div>
                           Delete</template
                        >
                     </my-modal>
                  </tr>
                  <tr v-if="blogsList.length === 0">
                     <td colspan="6" class="text-center">
                        <stateLoading />
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import axios from "axios";
import MyModal from "@/components/Modal/Modal.vue";
import ToastMessage from "@/components/Toast/index.vue";
import stateLoading from "@/components/Loading/Loading.vue";
import { formatDateTime } from "@/utils/formatDateTime";

const blogsList = ref([]);
const successMessage = ref(null);
const isLoading = ref(false);

const getBlogsList = async () => {
   return await axios.get("v2/admin/blogs").then((response) => {
      blogsList.value = response.data.blogs;
   });
};

const deleteBlog = async (id) => {
   isLoading.value = true;
   axios.delete(`v2/admin/blogs/${id}/delete`).then((response) => {
      isLoading.value = false;
      $(`#deleteBlogModal${id}`).modal("hide");
      getBlogsList().then(() => {
         successMessage.value = response.data.message;
         $(".toast").toast("show");
      });
   });
};

onBeforeMount(() => {
   getBlogsList();
});
</script>

<style></style>
