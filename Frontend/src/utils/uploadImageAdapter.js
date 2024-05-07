import axios from "axios";

export const uploadImageAdapter = (loader) => {
   return {
      upload: () => {
         return new Promise(async (resolve, reject) => {
            loader.file.then(async (file) => {
               try {
                  if (!file) return;

                  const formData = new FormData();
                  formData.append("image-content", file);
                  const response = await axios.post("v2/admin/upload", formData);
                  if (response) {
                     const imageUrl = `http://127.0.0.1:8000/storage/blogimages/imageContent/${response.data.url}`;
                     resolve({ default: imageUrl });
                  }
               } catch (error) {
                  reject(error);
               }
            });
         });
      },
   };
};
