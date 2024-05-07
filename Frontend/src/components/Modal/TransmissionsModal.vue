<template>
    <myModal @clickTo="selectTransmission" idModal="transmissionsModal">
        <template v-slot:title> <span>Truyền động </span></template>
        <div class="transmissions-list">
            <div class="transmissions-item">
                <input type="radio" name="transmission" value="all" checked v-model="transmissionChecked">
                <label for="transmission">Tất cả</label>
            </div>
            <div class="transmissions-item">
                <input type="radio" name="transmission" value="0" v-model="transmissionChecked">
                <label for="transmission">Số tự động</label>
            </div>
            <div class="transmissions-item">
                <input type="radio" name="transmission" value="1" v-model="transmissionChecked">
                <label for="transmission">Số sàn</label>
            </div>
        </div>
        <template v-slot:buttonName>Áp dụng</template>
    </myModal>
</template>

<script setup>
import myModal from "@/components/Modal/Modal.vue";
import { ref, watch } from "vue";

const transmissionChecked = ref("all");
const selectTransmission = () => {
    $('#transmissionsModal').modal('hide')
}

const emits = defineEmits(['select-transmission']);

watch(transmissionChecked, (value) => {
    emits('select-transmission', value);
})

</script>

<style lang="scss" scoped>
.transmissions-item {
    margin-top: 8px;

    input {
        cursor: pointer;
    }

    label {
        color: black;
        margin-left: 10px;
    }
}
</style>
