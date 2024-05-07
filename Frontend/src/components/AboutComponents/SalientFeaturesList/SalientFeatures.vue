<template>
  <div class="about-salient-features">
    <div class="about-container">
      <div class="w-100 d-flex">
        <h1>
          TÍNH NĂNG NỔI BẬT CÓ TẠI CA<span style="color: #1cc88a">R</span>ENTAL
        </h1>
        <div class="salient-features-list">
          <div
            class="salient-features-item"
            v-for="(item, index) in salientFeaturesItem"
            :key="index"
            @click="showDetail(index)"
          >
            <a
              class="w-100"
              data-bs-toggle="collapse"
              :href="`#collapseExample${index}`"
              role="button"
              aria-expanded="false"
              :aria-controls="`collapseExample${index}`"
              :style="{ color: item.isShow ? '#1cc88a' : '' }"
            >
              {{ item.title }}
              <i
                class="fa-solid float-end"
                :class="{ 'fa-minus': item.isShow, 'fa-plus': !item.isShow }"
              ></i>
            </a>
            <div class="collapse" :id="`collapseExample${index}`">
              <div class="card card-body mt-0 border-0 bg-transparent">
                {{ item.content }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";

export default {
  name: "SalientFeatures",
  setup() {
    const salientFeaturesItem = ref([
      {
        title: "Tính năng lịch",
        content:
          "Hỗ trợ chủ xe thuận tiện quản lý, theo dõi lịch trình xe một cách khoa học và chủ động trong việc thiết lập, điều chỉnh giá  thuê xe. Cho phép khách thuê xem trước lịch xe chạy và nhận báo giá thuê xe theo ngày. Do đó, tính năng Lịch sẽ loại bỏ hoàn toàn việc liên lạc qua điện thoại giữa chủ xe và khách thuê trong việc trao đổi về thời gian và giá thuê xe, từ đó rút ngắn đáng kể thời gian đặt xe.",
        isShow: false,
      },
      {
        title: "Đặt xe nhanh chóng và giao xe tận nơi",
        content:
          "Bạn không có nhiều thời gian, bạn muốn thuê xe nhanh chóng mà không cần qua bước xét duyệt trực tuyến của chủ xe? Bạn muốn xe được giao tận nhà hay đón trực tiếp tại sân bay? Tính năng “Đặt hàng nhanh” và “Giao hàng tận nơi” của Mioto sẽ đáp ứng hoàn hảo những yêu cầu này của bạn. Tại Mioto, chúng tôi có một danh sách dài các chủ xe sẵn sàng giao xe tận nơi và cho phép bạn thuê xe mà không cần phê duyệt trực tuyến (chỉ cần đến tận nơi khi nhận xe).",
        isShow: false,
      },
      {
        title: "GPS trên mọi cung đường",
        content:
          "Carental biết rằng chiếc xe của bạn là tài sản lớn của bạn và việc kinh doanh cho thuê xe tự lái sẽ luôn tiềm ẩn nhiều rủi ro.s Vì vậy, bên cạnh việc hỗ trợ xác thực trước các thông tin cá nhân quan trọng của khách hàng (Bằng lái xe, CMND, sổ hộ khẩu KT3/giấy tạm trú và điểm đánh giá), chúng tôi đang phát triển thêm tính năng tích hợp GPS trực tiếp trên ứng dụng. Với tính năng GPS, chủ xe có thể dễ dàng theo dõi tình trạng, vị trí xe của mình ngay trên ứng dụng mọi lúc mọi nơi để bạn có thể hoàn toàn yên tâm về phương tiện của mình.",
        isShow: false,
      },
    ]);

    const showDetail = (index) => {
      salientFeaturesItem.value[index].isShow =
        !salientFeaturesItem.value[index].isShow;
    };
    return {
      salientFeaturesItem,
      showDetail,
    };
  },
};
</script>

<style scoped>
@import "./SalientFeatures.scss";
</style>
