<template>
  <my-modal :idModal="modalId" bgColor="primary">
    <template v-slot:title>Thêm phòng</template>
    <div class="form-group">
      <label for="roomNumber">Số phòng:</label>
      <input type="text" class="form-control" id="roomNumber" v-model="roomNumber">
    </div>
    <div class="form-group">
      <label for="roomType">Loại phòng:</label>
      <input type="text" class="form-control" id="roomType" v-model="roomType">
    </div>
    <div class="text-end">
      <button type="button" class="btn btn-secondary me-2" @click="closeModal">Hủy</button>
      <button type="button" class="btn btn-primary" @click="addRoom">Thêm</button>
    </div>
  </my-modal>
</template>

<script setup>
import myModal from "@/components/Modal/Modal.vue";
import { ref } from 'vue';

const modalId = 'addRoomModal';
const roomNumber = ref('');
const roomType = ref('');

const closeModal = () => {
  // Logic đóng modal
};

const addRoom = () => {
  // Logic thêm phòng
};

</script>

<style scoped>

</style>