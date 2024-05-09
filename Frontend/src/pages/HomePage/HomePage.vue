<template>
   <div>
      <BannerSection />
      <PromotionSection />
      <FeaturedHomestaysSection />
      <FeaturedPlacesSection />
      <AdvantagesSection />
      <ServiceSection />
      <PhotoLibrarySection />
   </div>
</template>

<script setup>
import BannerSection from "../../components/HomeComponents/Banner/Banner.vue";
import PromotionSection from "../../components/HomeComponents/Promotion/Promotion.vue";
import FeaturedHomestaysSection from "../../components/HomeComponents/FeaturedHomestays/FeaturedHomestays.vue";
import FeaturedPlacesSection from "../../components/HomeComponents/FeaturedPlaces/FeaturedPlaces.vue";
import AdvantagesSection from "../../components/HomeComponents/Advantages/Advantages.vue";
import ServiceSection from "../../components/HomeComponents/ServiceSection/ServiceSection.vue";
import PhotoLibrarySection from "../../components/HomeComponents/PhotoLibrary/PhotoLibrary.vue";
import { onMounted } from "vue";

/**
 * TODO: Display the element when it is visible in the viewport
 */
const observer = new IntersectionObserver((entries) => {
   entries.forEach((entry) => {
      if (entry.isIntersecting) {
         entry.target.classList.add("show");
      } else {
         entry.target.classList.remove("show");
      }
   });
});
onMounted(() => {
   const hiddenElements = document.querySelectorAll(".hidden");
   hiddenElements.forEach((el) => observer.observe(el));
});
</script>

<style scoped></style>
