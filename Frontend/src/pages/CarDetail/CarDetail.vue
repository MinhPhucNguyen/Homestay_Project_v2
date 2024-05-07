<template>
   <div class="car_detail_container" v-if="Object.values(carDetail).length !== 0 && carDetail.constructor === Object">
      <div class="car_image">
         <div class="car_image_container">
            <div class="main_image">
               <div class="cover_car_image">
                  <img :src="carDetail.carImages[0].imagePath" alt="${response.data.carCustomName}" />
               </div>
            </div>
            <div class="sub_image">
               <div class="cover_car_image" v-for="subImage in newCarImageArr" :key="subImage.imageId">
                  <img :src="subImage.imagePath" alt="sub_car_image" />
               </div>
            </div>
         </div>
      </div>
      <div class="car-detail">
         <div class="car-detail-content">
            <div class="infor-car-basic">
               <div class="group-name">
                  <h3>{{ carDetail.carCustomName }}</h3>
                  <div class="group-action">
                     <div class="wrap-ic">
                        <i class="fa-solid fa-share-nodes"></i>
                     </div>
                     <div class="wrap-ic fav-btn" :class="{ active: isFavorite }" @click="addCarToFavorite">
                        <i class="fa-regular fa-heart"></i>
                     </div>
                  </div>
               </div>
               <div class="group-total">
                  <div class="ic"><i class="fa-solid fa-suitcase-rolling"></i></div>
                  <span class="info">{{ carDetail.numberOfTrip }} Chuyến</span>
                  <span class="dot">•</span>
                  <span class="info address">{{ carDetail.location }}</span>
               </div>
               <div class="group-tag">
                  <span class="tag-transmission">{{
                     carDetail.transmission == "0" ? "Số tự động" : "Số sàn"
                  }}</span>
                  <span class="tag-delivery" v-if="carDetail.delivery_enable === 1">Giao xe tận nơi</span>
               </div>
            </div>
         </div>
         <div class="car-detail-sidebar">
            <div class="rent-box">
               <div class="price">
                  <h4>
                     {{ formatCurrency(carDetail.price) + "/ngày" }}
                  </h4>
               </div>
               <div class="date-time-form">
                  <div class="form-item">
                     <label for="" @click="checkLog">Nhận xe</label>
                     <div class="form-choose">
                        <input type="date" class="calendar-input fw-bold border-0" ref="startDateTime" />
                     </div>
                  </div>
                  <div class="line"></div>
                  <div class="form-item">
                     <label for="" ref="traXe">Trả xe</label>
                     <div class="form-choose">
                        <input type="date" class="calendar-input fw-bold border-0" ref="endDateTime" />
                     </div>
                  </div>
               </div>
               <div class="dropdown-form">
                  <label for="">Địa điểm giao nhận xe</label>
                  <div class="dropdown fw-bold">{{ carDetail.location }}</div>
               </div>
               <div class="line-page"></div>
               <div class="price-container">
                  <div class="price-item">
                     <p>Đơn giá thuê</p>
                     <p class="cost" id="originalPrice">
                        {{ formatCurrency(carDetail.price) + "/ ngày" }}
                     </p>
                  </div>
                  <div class="price-item">
                     <p>Phí dịch vụ</p>
                     <p class="cost" id="servicesFee">
                        {{ formatCurrency(100000) + "/ ngày" }}
                     </p>
                  </div>
                  <div class="line-page"></div>
                  <div class="price-item mt-3">
                     <p>Tổng phí thuê xe</p>
                     <p class="cost" id="total">
                        {{ calulateTotalPrice(carDetail.price, 100000) + " x 1 ngày" }}
                     </p>
                  </div>
                  <div class="promotion">
                     <div class="promotion-icon">
                        <i class="fa-solid fa-ticket"></i>
                     </div>
                     <p>Sử dụng mã khuyến mại</p>
                  </div>
                  <div class="line-page"></div>
                  <div class="price-item total-price">
                     <p>Tổng cộng</p>
                     <p class="cost" id="total"></p>
                  </div>
                  <a href="" class="order-btn w-100">
                     <i class="fa-solid fa-bolt"></i>
                     <span>ĐẶT XE</span>
                  </a>
               </div>
            </div>
         </div>
         <div class="car-detail-content">
            <div class="line-page"></div>
            <div class="infor-car-desc">
               <h6>Đặc điểm</h6>
               <div class="outstanding-features">
                  <div class="outstanding-features-item">
                     <div class="ic"></div>
                     <div class="title">
                        <div class="sub">Số ghế</div>
                        <div class="main" id="seats">{{ carDetail.seats + " chỗ" }}</div>
                     </div>
                  </div>
                  <div class="outstanding-features-item">
                     <div class="ic"></div>
                     <div class="title">
                        <div class="sub">Truyền động</div>
                        <div class="main" id="transmission">
                           {{ carDetail.transmission == "0" ? "Số tự động" : "Số sàn" }}
                        </div>
                     </div>
                  </div>
                  <div class="outstanding-features-item">
                     <div class="ic"></div>
                     <div class="title">
                        <div class="sub">Nhiên liệu</div>
                        <div class="main" id="fuel">{{ fuelOfCar }}</div>
                     </div>
                  </div>
                  <div class="outstanding-features-item">
                     <div class="ic"></div>
                     <div class="title">
                        <div class="sub">NL tiêu hao</div>
                        <div class="main" id="fuelConsumption">
                           {{ carDetail.fuelConsumption + " lít/100km" }}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="line-page"></div>
            <div class="infor-car-desc">
               <h6>Mô tả</h6>
               <div class="desc" :class="{ 'hide gradient': isDescriptionHidden }" v-html="carDescHTML"></div>
               <div class="read-more fw-bold d-flex align-items-center" @click="toggleDescription">
                  {{ isDescriptionHidden ? "Đọc thêm..." : "Thu gọn" }}
                  <i v-if="!isDescriptionHidden" class="fa-solid fa-angle-up"></i>
               </div>
            </div>
            <div class="line-page mt-4"></div>
            <div class="infor-car-desc">
               <h6>Các tiện nghi khác</h6>
               <div class="feature w-75">
                  <div v-if="carDetail.features.length > 0">
                     <div class="feature-item" v-for="feature in carDetail.features" :key="feature.featureId">
                        {{ feature.featureName }}
                     </div>
                  </div>
                  <div v-else>
                     <div style="color: #7c7c7c">*Không có tiện nghi khác</div>
                  </div>
               </div>
            </div>
            <div class="line-page"></div>
            <div class="infor-car-desc">
               <h6>Điều khoản</h6>
               <pre>
                        Quy định khác:
                        ◦ Sử dụng xe đúng mục đích.
                        ◦ Không sử dụng xe thuê vào mục đích phi pháp, trái pháp luật.
                        ◦ Không sử dụng xe thuê để cầm cố, thế chấp.
                        ◦ Không hút thuốc, nhả kẹo cao su, xả rác trong xe.
                        ◦ Không chở hàng quốc cấm dễ cháy nổ.
                        ◦ Không chở hoa quả, thực phẩm nặng mùi trong xe.
                        ◦ Khi trả xe, nếu xe bẩn hoặc có mùi trong xe, khách hàng vui lòng vệ sinh xe sạch sẽ hoặc gửi phụ
                        thu phí vệ sinh xe.
                        Trân trọng cảm ơn, chúc quý khách hàng có những chuyến đi tuyệt vời !
                    </pre>
            </div>
            <div class="infor-car-desc">
               <h6>Chính sách hủy chuyến</h6>
               <div class="cancel-policy w-100">
                  <div class="column title">
                     <div class="column-item">Thời điểm hủy chuyển</div>
                     <div class="column-item">Khách thuê hủy chuyển</div>
                     <div class="column-item">Chủ xe hủy chuyển</div>
                  </div>
                  <div class="column">
                     <div class="column-item case">Trong vòng 1h sau đặt cọc</div>
                     <div class="column-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>Hoàn tiền 100%</div>
                     </div>
                     <div class="column-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>Không đền cọc</div>
                     </div>
                  </div>
                  <div class="column">
                     <div class="column-item case">Trước Chuyến Đi >7 Ngày</div>
                     <div class="column-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>Hoàn tiền 70%</div>
                     </div>
                     <div class="column-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>Trước Chuyến Đi >7 Ngày</div>
                     </div>
                  </div>
                  <div class="column">
                     <div class="column-item case">Trong Vòng 7 Ngày Trước Chuyến Đi</div>
                     <div class="column-item">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <div>Không hoàn tiền</div>
                     </div>
                     <div class="column-item">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <div>Đền cọc 100%</div>
                     </div>
                  </div>
                  <div class="note">
                     <p>* Khách thuê không nhận xe sẽ không được hoàn cọc</p>
                     <p>* Chủ xe không giao xe sẽ đền 100% tiền cọc</p>
                     <p>* Tiền cọc sẽ được hoàn trả trong vòng 1-3 ngày làm việc</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div v-else-if="errorMessage">{{ errorMessage }}</div>
   <div v-else class="w-100 d-flex justify-content-center mt-4">
      <div class="spinner-grow" style="width: 3rem; height: 3rem; color: #1cc88a" role="status">
         <span class="visually-hidden">Loading...</span>
      </div>
   </div>
</template>

<script setup>
import { ref, computed, onUpdated } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";
import "flatpickr/dist/flatpickr.min.css";
import flatpickr from "flatpickr";
import { useStore } from "vuex";
import { formatCurrency } from "@/utils/formatCurrency.js";

const carID = ref(null);
const carDetail = ref({});
const errorMessage = ref("");
const totalPrice = ref(0);
const isDescriptionHidden = ref(true);
const startDateTime = ref("");
const endDateTime = ref("");
const store = useStore();
const isFavorite = ref(false);

//Get car detail
carID.value = useRoute().params.id;
const getCarDetail = async () => {
   try {
      const response = await axios.get(`v2/car/detail?car_id=${carID.value}`);
      if (response.status === 200) {
         carDetail.value = response.data.data;
      } else {
         throw new Error("Something went wrong");
      }
   } catch (error) {
      errorMessage.value = error;
   }
};
getCarDetail();

const newCarImageArr = computed(() => {
   if (carDetail.value.carImages) {
      return carDetail.value.carImages.slice(1, 4);
   } else {
      return [];
   }
});

const fuelOfCar = computed(() => {
   if (carDetail.value.fuel === "Petrol") {
      return "Xăng";
   } else if (carDetail.value.fuel === "Diesel") {
      return "Dầu";
   } else {
      return "Điện";
   }
});

//Calulate total price of bill
const calulateTotalPrice = (originalPrice, servicesFee) => {
   totalPrice.value = originalPrice + servicesFee;
   return formatCurrency(totalPrice.value);
};

//Ẩn hiện mô tả
const toggleDescription = () => {
   isDescriptionHidden.value = !isDescriptionHidden.value;
};

const carDescHTML = computed(() => {
   return carDetail.value.desc;
});

onUpdated(() => {
   flatpickr(startDateTime.value, {
      enableTime: true,
      dateFormat: "d/m/Y    H:i",
      allowInput: true,
      defaultDate: new Date(),
   });

   flatpickr(endDateTime.value, {
      enableTime: true,
      dateFormat: "d/m/Y    H:i",
      allowInput: true,
      defaultDate: new Date(),
   });
});

/**
 * TODO: Add car to favorite
 */

const addCarToFavorite = () => {
   const favBtn = document.querySelector(".fav-btn");
   favBtn.classList.toggle("active");
   if (favBtn.classList.contains("active")) {
      store
         .dispatch("favorite/addCar", { id: carID.value })
         .then((response) => {
            console.log(response);
         })
         .catch((error) => {
            console.log(error);
         });
   } else {
      store
         .dispatch("favorite/removeCar", { id: carID.value })
         .then((response) => {
            console.log(response);
         })
         .catch((error) => {
            console.log(error);
         });
   }
};

store.getters["favorite/getFavoriteCars"].some((car) => {
   if (car.carId === parseInt(carID.value)) {
      isFavorite.value = true;
      return true;
   } else {
      isFavorite.value = false;
      return false;
   }
});
</script>

<style scoped>
@import "./CarDetail.scss";
</style>
