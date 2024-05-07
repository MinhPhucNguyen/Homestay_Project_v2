<template>
   <div>
      <BannerSection />
      <PromotionSection />
      <FeaturedCarsSection />
      <FeaturedPlacesSection />
      <AdvantagesSection />
      <ServiceSection />
      <ExplorerSection />
      <BlogSection />
   </div>
</template>

<script setup>
import BannerSection from "../../components/HomeComponents/Banner/Banner.vue";
import PromotionSection from "../../components/HomeComponents/Promotion/Promotion.vue";
import FeaturedCarsSection from "../../components/HomeComponents/FeaturedCars/FeaturedCars.vue";
import FeaturedPlacesSection from "../../components/HomeComponents/FeaturedPlaces/FeaturedPlaces.vue";
import AdvantagesSection from "../../components/HomeComponents/Advantages/Advantages.vue";
import ServiceSection from "../../components/HomeComponents/ServiceSection/ServiceSection.vue";
import ExplorerSection from "../../components/HomeComponents/ExplorerSection/ExplorerSection.vue";
import BlogSection from "../../components/HomeComponents/BlogSection/BlogSection.vue";
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
