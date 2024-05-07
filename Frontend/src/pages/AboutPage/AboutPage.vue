<template>
   <div id="about">
      <head-section />
      <advantage-section />
      <salient-features />
   </div>
</template>

<script>
import HeadSection from "../../components/AboutComponents/HeadSection/HeadSection.vue";
import AdvantageSection from "../../components/AboutComponents/AdvantageSection/AdvantageSection.vue";
import SalientFeatures from "../../components/AboutComponents/SalientFeaturesList/SalientFeatures.vue";

export default {
   name: "AboutPage",
   components: {
      HeadSection,
      AdvantageSection,
      SalientFeatures,
   },
};
</script>

<style>
#about {
   width: 100%;
   background: white;
}

.about-container {
   width: 75%;
   margin: 0 auto;
   display: flex;
   padding: 60px 0;
}
</style>
