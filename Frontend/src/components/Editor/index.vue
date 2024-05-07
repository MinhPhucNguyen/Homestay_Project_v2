<template>
   <div>
      <ckeditor v-model="editorData" :editor="editor" :config="editorConfig"></ckeditor>
   </div>
</template>

<script setup>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { computed } from "vue";
import { uploadImageAdapter } from "@/utils/uploadImageAdapter";

const editor = ClassicEditor;
const props = defineProps({
   modelValue: {
      type: String,
      default: "",
   },
});

const emit = defineEmits(["update:modelValue"]);

const editorData = computed({
   get() {
      return props.modelValue;
   },
   set(value) {
      emit("update:modelValue", value);
   },
});

function uploader(editor) {
   editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
      return uploadImageAdapter(loader);
   };
}

const editorConfig = {
   extraPlugins: [uploader],
};
</script>

<style></style>
