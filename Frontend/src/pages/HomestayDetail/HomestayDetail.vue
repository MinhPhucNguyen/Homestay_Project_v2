<template>
  <div class="homestay_detail_container"
       v-if="Object.values(homestayDetail).length !== 0 && homestayDetail.constructor === Object">
          <div class="homestay_image">
             <div class="homestay_image_container">
                <div class="main_image">
                   <div class="cover_homestay_image">
                      <img :src="'/' + homestayDetail.homestayImages[0].imagePath" alt="${response.data.homestayCustomName}" />
                   </div>
                </div>
                <div class="sub_image">
                   <div class="cover_homestay_image" v-for="subImage in newCarImageArr" :key="subImage.imageId">
                      <img :src="'/' + subImage.imagePath" alt="sub_homestay_image" />
                   </div>
                </div>
             </div>
          </div>
    <div class="homestay-detail">
      <div class="homestay-detail-content">
        <div class="infor-homestay-basic">
          <div class="group-name">
            <h3>{{ homestayDetail.homestayName }}</h3>
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
            <div class="ic">
              <font-awesome-icon icon="fa-solid fa-location-dot"/>
            </div>
            <span class="info address">{{ homestayDetail.address }}</span>
          </div>
        </div>
      </div>
      <div class="homestay-detail-sidebar">
        <div class="rent-box">
          <div class="price">
            <h4>
              {{ formatCurrency(homestayDetail.price) + "/ngày" }}
            </h4>
          </div>
          <div class="date-time-form">
            <div class="form-item">
              <label for="" @click="checkLog">Bắt đầu</label>
              <div class="form-choose">
                <input type="date" class="calendar-input fw-bold border-0" ref="startDateTime"/>
              </div>
            </div>
            <div class="line"></div>
            <div class="form-item">
              <label for="" ref="traXe">Kết thúc</label>
              <div class="form-choose">
                <input type="date" class="calendar-input fw-bold border-0" ref="endDateTime"/>
              </div>
            </div>
          </div>
          <div class="line-page"></div>
          <div class="price-container">
            <div class="price-item">
              <p>Đơn giá thuê</p>
              <p class="cost" id="originalPrice">
                {{ formatCurrency(homestayDetail.price) + "/ ngày" }}
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
              <p>Tổng phí thuê phòng</p>
              <!--                     <p class="cost" id="total">-->
              <!--                        {{ calulateTotalPrice(homestayDetail.price, 100000) + " x 1 ngày" }}-->
              <!--                     </p>-->
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
              <span>ĐẶT NGAY</span>
            </a>
          </div>
        </div>
      </div>
               <div class="homestay-detail-content">
                  <div class="line-page"></div>
                  <div class="infor-homestay-desc">
                     <h6>Mô tả</h6>
                     <div class="desc" :class="{ 'hide gradient': isDescriptionHidden }" >
                       <p>Agriturismo Cabrele nằm ở Santorso, nhìn ra khu vườn và có Wi-Fi miễn phí cùng chỗ đậu xe riêng miễn phí.</p>

                       <p>Tất cả các căn có phòng tắm riêng, vòi xịt/chậu rửa vệ sinh, điều hòa, TV màn hình phẳng và minibar.</p>

                       <p>Khách có thể tìm thấy sân chơi trẻ em tại trang trại nghỉ dưỡng, cùng khu vườn.</p>

                       <p>Sân bay gần nhất là Sân bay Treviso, cách Agriturismo Cabrele 80 km.</p>

                       <p>Các gia đình đặc biệt thích địa điểm này — họ cho điểm 9,0 nếu đi kèm với trẻ em.</p>

                       <p>Các khoảng cách nêu trong mô tả chỗ nghỉ được tính toán bằng © OpenStreetMap</p>

                     </div>
                     <div class="read-more fw-bold d-flex align-items-center" @click="toggleDescription">
                        {{ isDescriptionHidden ? "Đọc thêm..." : "Thu gọn" }}
                        <i v-if="!isDescriptionHidden" class="fa-solid fa-angle-up"></i>
                     </div>
                  </div>
                  <div class="line-page mt-4"></div>
                  <div class="infor-homestay-desc">
                     <h6>Các tiện nghi được ưa chuộng nhất</h6>
                     <div class="feature w-75">
<!--                        <div v-if="homestayDetail.features.length > 0">-->
<!--                           <div class="feature-item" v-for="feature in homestayDetail.features" :key="feature.featureId">-->
<!--                              {{ feature.featureName }}-->
<!--                           </div>-->
<!--                        </div>-->
<!--                        <div v-else>-->
<!--                           <div style="color: #7c7c7c">*Không có tiện nghi khác</div>-->
<!--                        </div>-->
                     </div>
                  </div>
                  <div class="line-page mt-4"></div>
<!--                  <div class="infor-homestay-desc">-->
<!--                     <h6>Chính sách hủy chuyến</h6>-->
<!--                     <div class="cancel-policy w-100">-->
<!--                        <div class="column title">-->
<!--                           <div class="column-item">Thời điểm hủy chuyển</div>-->
<!--                           <div class="column-item">Khách thuê hủy chuyển</div>-->
<!--                           <div class="column-item">Chủ xe hủy chuyển</div>-->
<!--                        </div>-->
<!--                        <div class="column">-->
<!--                           <div class="column-item case">Trong vòng 1h sau đặt cọc</div>-->
<!--                           <div class="column-item">-->
<!--                              <i class="fa-solid fa-circle-check"></i>-->
<!--                              <div>Hoàn tiền 100%</div>-->
<!--                           </div>-->
<!--                           <div class="column-item">-->
<!--                              <i class="fa-solid fa-circle-check"></i>-->
<!--                              <div>Không đền cọc</div>-->
<!--                           </div>-->
<!--                        </div>-->
<!--                        <div class="column">-->
<!--                           <div class="column-item case">Trước Chuyến Đi >7 Ngày</div>-->
<!--                           <div class="column-item">-->
<!--                              <i class="fa-solid fa-circle-check"></i>-->
<!--                              <div>Hoàn tiền 70%</div>-->
<!--                           </div>-->
<!--                           <div class="column-item">-->
<!--                              <i class="fa-solid fa-circle-check"></i>-->
<!--                              <div>Trước Chuyến Đi >7 Ngày</div>-->
<!--                           </div>-->
<!--                        </div>-->
<!--                        <div class="column">-->
<!--                           <div class="column-item case">Trong Vòng 7 Ngày Trước Chuyến Đi</div>-->
<!--                           <div class="column-item">-->
<!--                              <i class="fa-solid fa-circle-xmark"></i>-->
<!--                              <div>Không hoàn tiền</div>-->
<!--                           </div>-->
<!--                           <div class="column-item">-->
<!--                              <i class="fa-solid fa-circle-xmark"></i>-->
<!--                              <div>Đền cọc 100%</div>-->
<!--                           </div>-->
<!--                        </div>-->
<!--                        <div class="note">-->
<!--                           <p>* Khách thuê không nhận xe sẽ không được hoàn cọc</p>-->
<!--                           <p>* Chủ xe không giao xe sẽ đền 100% tiền cọc</p>-->
<!--                           <p>* Tiền cọc sẽ được hoàn trả trong vòng 1-3 ngày làm việc</p>-->
<!--                        </div>-->
<!--                     </div>-->
<!--                  </div>-->
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
import {ref, computed, onUpdated} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import "flatpickr/dist/flatpickr.min.css";
import flatpickr from "flatpickr";
import {useStore} from "vuex";
import {formatCurrency} from "@/utils/formatCurrency.js";

const homestayDetail = ref({});
const errorMessage = ref("");
const totalPrice = ref(0);
const isDescriptionHidden = ref(true);
const startDateTime = ref("");
const endDateTime = ref("");
const store = useStore();
const isFavorite = ref(false);

const getHomestayDetail = async () => {
  try {
    const response = await axios.get(`v2/homestay/${useRoute().params.slug}`);
    if (response.status === 200) {
      homestayDetail.value = response.data.homestay;
    } else {
      throw new Error("Something went wrong");
    }
  } catch (error) {
    errorMessage.value = error;
  }
};
getHomestayDetail();

const newCarImageArr = computed(() => {
   if (homestayDetail.value.homestayImages) {
      return homestayDetail.value.homestayImages.slice(1, 4);
   } else {
      return [];
   }
});

//Calulate total price of bill
// const calulateTotalPrice = (originalPrice, servicesFee) => {
//    totalPrice.value = originalPrice + servicesFee;
//    return formatCurrency(totalPrice.value);
// };

//Ẩn hiện mô tả
const toggleDescription = () => {
   isDescriptionHidden.value = !isDescriptionHidden.value;
};

// const homestayDescHTML = computed(() => {
//    return homestayDetail.value.desc;
// });

// onUpdated(() => {
//    flatpickr(startDateTime.value, {
//       enableTime: true,
//       dateFormat: "d/m/Y    H:i",
//       allowInput: true,
//       defaultDate: new Date(),
//    });
//
//    flatpickr(endDateTime.value, {
//       enableTime: true,
//       dateFormat: "d/m/Y    H:i",
//       allowInput: true,
//       defaultDate: new Date(),
//    });
// });

/**
 * TODO: Add homestay to favorite
 */

// const addCarToFavorite = () => {
//    const favBtn = document.querySelector(".fav-btn");
//    favBtn.classList.toggle("active");
//    if (favBtn.classList.contains("active")) {
//       store
//          .dispatch("favorite/addCar", { id: homestayID.value })
//          .then((response) => {
//             console.log(response);
//          })
//          .catch((error) => {
//             console.log(error);
//          });
//    } else {
//       store
//          .dispatch("favorite/removeCar", { id: homestayID.value })
//          .then((response) => {
//             console.log(response);
//          })
//          .catch((error) => {
//             console.log(error);
//          });
//    }
// };
//
// store.getters["favorite/getFavoriteCars"].some((homestay) => {
//    if (homestay.homestayId === parseInt(homestayID.value)) {
//       isFavorite.value = true;
//       return true;
//    } else {
//       isFavorite.value = false;
//       return false;
//    }
// });
</script>

<style scoped>
@import "HomestayDetail.scss";
</style>
