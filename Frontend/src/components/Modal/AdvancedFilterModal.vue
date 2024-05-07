<template>
    <myModal @clickTo="handleAdvancedFilter" idModal="advancedFilterModal">
        <template v-slot:title> <span> Bộ lọc nâng cao </span></template>
        <div class="advanced-filter-wrap">
            <div class="advanced-filter-scroll">

                <div class="advanced-filter-item" v-for="(item, index) in filters" :key="index">
                    <p class="title">{{ item.title }}</p>
                    <div class="slider">
                        <div class="progress"></div>
                    </div>
                    <div class="range-input" v-if="item.hasRange">
                        <input type="range" class="range-min" :min="item.min" :max="item.max"
                            v-model.number="model[index].min" @input="updateProgress(index, $event)">
                        <input type="range" class="range-max" :min="item.min" :max="item.max"
                            v-model.number="model[index].max" @input="updateProgress(index, $event)">
                    </div>
                    <div class="range-input" v-else>
                        <input type="range" class="fuel-consumption-range" :min="item.min" :max="item.max"
                            v-model.number="model[index].fuelConsumption" @input="fuelConsumptionProgress(index, $event)">
                    </div>
                    <div class="range-value" v-if="item.hasRange">
                        <div class="range-value-item">
                            <span>{{ item.fromTitle }}</span>
                            <input type="number" :value="item.min">
                        </div>
                        <div class="sperator"></div>
                        <div class="range-value-item">
                            <span>{{ item.toTitle }}</span>
                            <input type="number" :value="item.max">
                        </div>
                    </div>
                    <div class="range-value" v-else>
                        <div class="range-value-item fuel-consumption">
                            <p class="mb-0">Bất kỳ</p>
                        </div>
                    </div>
                </div>
                <div class="advanced-filter-item">
                    <p class="title">Tính năng </p>
                    <div class="features-list">
                        <div class="features-item" v-for="feature in props.featuresList" :key="feature.id">
                            <input type="checkbox" :value="feature.id" v-model="data.features">
                            <label for="name">{{ feature.name }}</label>
                        </div>
                    </div>
                </div>
                <div class="advanced-filter-item">
                    <p class="title">Nhiên liệu </p>
                    <div class="fuels-list">
                        <div class="fuels-item">
                            <input type="radio" name="fuel" value="" v-model="data.fuel">
                            <label for="fuel">
                                Tất cả
                            </label>
                        </div>
                        <div class="fuels-item">
                            <input type="radio" name="fuel" value="Petrol" v-model="data.fuel">
                            <label for="fuel">
                                Xăng
                            </label>
                        </div>
                        <div class="fuels-item">
                            <input type="radio" name="fuel" value="Diesel" v-model="data.fuel">
                            <label for="fuel">
                                Dầu Diesel
                            </label>
                        </div>
                        <div class="fuels-item">
                            <input type="radio" name="fuel" value="Electric" v-model="data.fuel">
                            <label for="fuel">
                                Điện
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:buttonName>Áp dụng</template>
    </myModal>
</template>

<script setup>
import {
    ref, onMounted, watch
} from 'vue';
import myModal from '@/components/Modal/Modal.vue'

const props = defineProps({
    featuresList: {
        type: Array
    }
})

const handleAdvancedFilter = () => {
    $('#advancedFilterModal').modal('hide');
}

const filters = ref([
    {
        title: 'Mức giá',
        min: 300000,
        max: 900000,
        fromTitle: 'Giá thấp nhất',
        toTitle: "Giá cao nhất",
        hasRange: true
    },
    {
        title: 'Số chỗ',
        min: 2,
        max: 10,
        fromTitle: 'Tối thiểu',
        toTitle: "Tối đa",
        hasRange: true
    },
    {
        title: 'Năm sản xuất',
        min: 2005,
        max: new Date().getFullYear(),
        fromTitle: 'Tối thiểu',
        toTitle: "Tối đa",
        hasRange: true
    },
    {
        title: 'Mức tiêu thụ nhiên liệu',
        min: 0,
        max: 30,
        hasRange: false
    }
])

const model = ref([
    {
        name: 'priceRange',
        min: 300000,
        max: 900000,
    },
    {
        name: 'seatRange',
        min: 2,
        max: 10,
    },
    {
        name: 'yearRange',
        min: 2005,
        max: new Date().getFullYear(),
    },
    {
        name: 'fuelConsumptionRange',
        fuelConsumption: 0
    },
]);

const data = ref({
    ...model.value,
    features: [],
    fuel: ''
})

const emits = defineEmits(['advanced-filter'])
onMounted(() => {
    watch(data.value, (value) => {
        emits('advanced-filter', value)
    })
})

onMounted(() => {
    for (const index in filters.value) {
        updateProgress(index);
        fuelConsumptionProgress(index);
    }
})

const updateProgress = (index, event) => {
    const filter = filters.value[index];
    const rangeInput = document.querySelectorAll('.range-input input');
    const rangeValue = document.querySelectorAll('.range-value input');
    const progress = document.querySelectorAll('.slider .progress')[index];
    if (filter.hasRange) {
        let seatGap = 1
        let minVal = parseInt(rangeInput[2 * index].value); //lấy giá trị min đang được chọn
        let maxVal = parseInt(rangeInput[2 * index + 1].value); //lấy giá trị max đang được chọn

        //nếu maxVal - minVal < seatGap thì tăng giá trị của max hoặc min lên 1
        if (maxVal - minVal < seatGap) {
            if (event.target.className === 'range-min') {
                rangeInput[2 * index].value = maxVal - seatGap;
            }
            else {
                rangeInput[2 * index + 1].value = minVal + seatGap;
            }
        }
        else {
            let range = rangeInput[2 * index].max - rangeInput[2 * index].min;
            let leftPercent = ((minVal - rangeInput[2 * index].min) / range) * 100;
            let rightPercent = 100 - ((maxVal - rangeInput[2 * index + 1].min) / range) * 100;

            progress.style.left = `${leftPercent}%`;
            progress.style.right = `${rightPercent}%`;

            rangeValue[2 * index].value = minVal;
            rangeValue[2 * index + 1].value = maxVal;
        }
    }
};


const fuelConsumptionProgress = (index, event) => {
    const filter = filters.value[index];

    const rangeInput = document.querySelector('.range-input .fuel-consumption-range');
    const progress = document.querySelectorAll('.slider .progress')[index];
    const rangeValue = document.querySelector('.fuel-consumption p');

    if (filter.hasRange) return;

    let gapValue = 5;
    let valueIsPulling = parseInt(rangeInput.value);

    let percent = (valueIsPulling / rangeInput.max) * 100;
    progress.style.right = `${100 - percent}%`;

    if (valueIsPulling !== 0) {
        rangeValue.innerHTML = `<span class="fuel-consumption-value">Từ dưới ${valueIsPulling}l/100km</span>`;
    }
    else {
        rangeValue.textContent = `Bất kỳ`;
    }
}

</script>


<style lang="scss" scoped>
.advanced-filter-wrap {
    margin-top: 20px;
    display: inline-block;
    width: 100%;
    height: 100%;

    .advanced-filter-scroll {

        .advanced-filter-item {
            margin-bottom: 30px;

            .title {
                color: black;
                font-weight: 500;
                font-size: 18px;
                margin-bottom: 10px;
            }

            .slider {
                width: 100%;
                height: 5px;
                background-color: #ddd;
                border-radius: 5px;
                position: relative;

                & .progress {
                    position: absolute;
                    left: 0%;
                    right: 25%;
                    height: 5px;
                    background-color: #1cc88a;
                }
            }

            .range-input {
                position: relative;

                & input {
                    position: absolute;
                    top: -5px;
                    height: 5px;
                    width: 100%;
                    background: none;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    pointer-events: none;
                }

                input[type="range"]::-webkit-slider-thumb {
                    height: 20px;
                    width: 20px;
                    border-radius: 50%;
                    pointer-events: auto;
                    background: #1cc88a;
                    -webkit-appearance: none;
                    border: 2px solid white;
                    cursor: pointer;
                }
            }

            .range-value {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 24px;

                .sperator {
                    width: 20px;
                    background-color: #aaa;
                    height: 2px;
                    border-radius: 50px;
                }

                .range-value-item {
                    width: 50%;
                    border: 1px solid #aaa;
                    padding: 8px 10px;
                    border-radius: 9px;
                    display: flex;
                    flex-direction: column;


                    &.fuel-consumption {
                        text-align: center;
                        color: black;
                        width: fit-content;

                        &>p {
                            font-size: 12px;
                            display: inline-block;
                            margin-bottom: 0;
                        }
                    }

                    span {
                        font-size: 12px;
                    }

                    input {
                        margin-bottom: 0;
                        color: black;
                        font-size: 14px;
                        outline: none;
                        border: 0;
                        font-weight: 500;
                    }

                    input[type="number"]::-webkit-outer-spin-button,
                    input[type="number"]::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                    }

                }
            }
        }
    }
}

.advanced-filter-item .features-list {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    grid-gap: 10px;

    .features-item {
        width: calc((100% / 3) - 9px);
        display: flex;
        align-items: center;
        margin-bottom: 8px;

        input {
            width: 16px;
            height: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        label {
            margin-left: 12px;
            margin-bottom: 0;
        }
    }
}

.advanced-filter-item .fuels-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    grid-gap: 10px;

    .fuels-item {
        width: calc(100% / 4 - 9px);
        display: flex;
        align-items: center;

        input {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        label {
            margin-left: 12px;
            margin-bottom: 0;
        }
    }
}
</style>