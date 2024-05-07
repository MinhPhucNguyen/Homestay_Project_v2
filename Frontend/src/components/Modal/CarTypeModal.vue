<template>
    <myModal @clickTo="selectCarType" idModal="carTypeModal">
        <template v-slot:title> <span> Loại xe </span></template>
        <div class="car-types">
            <div class="custome-checkbox-selected" v-for="item in carTypesArr" :key="item.id" @click="selectItem">
                <input type="hidden" :value="item.seatsNumber">
                <div class="car-types-item">
                    <div class="car-types-item_image">
                        <img :src="require(`@/assets/images/car-types-images/${item.image}`)" :alt="item.name">
                    </div>
                    <p>{{ item.name }}</p>
                </div>
            </div>
        </div>
        <template v-slot:buttonName>Áp dụng</template>
    </myModal>
</template>

<script setup>
import myModal from "@/components/Modal/Modal.vue";
import { ref } from "vue";

const carTypesArr = [
    {
        id: 1,
        name: "4 chỗ",
        image: "4-sedan-v2.png",
        seatsNumber: 4,
    },
    {
        id: 2,
        name: "5 chỗ",
        image: "5-suv-v2.png",
        seatsNumber: 5,
    },
    {
        id: 3,
        name: "7 chỗ",
        image: "7-suv-v2.png",
        seatsNumber: 7,
    },
    {
        id: 4,
        name: "Bán tải",
        image: "pickup-v2.png",
        seatsNumber: 'Bán tải',
    },
];

const carTypesSelected = ref([]);
const emits = defineEmits(['select-car-types']);

const selectItem = (event) => {
    const target = event.currentTarget;
    target.classList.toggle("active");
    const selected = target.querySelector('input[type=hidden]').value;
    if (target.classList.contains('active')) {
        carTypesSelected.value.push(selected);
        emits('select-car-types', carTypesSelected.value);
    } else {
        carTypesSelected.value = carTypesSelected.value.filter(item => item !== selected);
        emits('select-car-types', carTypesSelected.value);
    }
}


const selectCarType = () => {
    $('#carTypeModal').modal('hide');
};

</script>

<style lang="scss" scoped>
.car-types {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    grid-gap: 15px;
    margin-top: 20px;

    .custome-checkbox-selected {
        width: calc((100% / 3) - 10px);
        height: 145px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border: 1px solid #e0e0e0;
        border-radius: 12px;

        &.active {
            border: 1px solid #1cc88a;
            background-color: #effaf3;
        }

        &:hover {
            box-shadow: 0px 0px 10px 0px #e0e0e0;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .car-types-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            .car-types-item_image {
                width: 100%;
                border-radius: 5px;
                overflow: hidden;
                display: flex;
                justify-content: center;

                img {
                    width: 80px;
                    object-fit: cover;
                }
            }

            p {
                margin-bottom: 0;
                color: black;
                font-size: 16px;
            }
        }
    }
}
</style>
