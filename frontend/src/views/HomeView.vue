<script setup>
import ParallaxSection from '@/components/ParallaxSection.vue';
import ProductList from '@/components/ProductCarousel.vue';
import CategoryCarousel from '@/components/CategoryCarousel.vue';

</script>

<template>
  <main>
    <ParallaxSection></ParallaxSection>
    <div>
      <ProductList />
    </div>
    <div class="welcome-section">
      <h2 class="welcome-title">Born in Malaysia. Loved worldwide.</h2>
      <p class="welcome-text">
        Welcome to the home of the MochiPals, a family where our mission is to share joy! 
        Expect the unexpected. Embrace our gentle humour. Enjoy the exquisite textures 
        and unusual colours… And if one of these characters makes you smile, make them 
        part of your family too.
      </p>
    </div>
    <CategoryCarousel />
  </main>
</template>

<style scoped>
.welcome-section {
  text-align: center;
  padding: 4rem 2rem;
  background-color: #f9f9f9;
}

.welcome-title {
  font-size: 2rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 1.5rem;
}

.welcome-text {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #555;
  max-width: 800px;
  margin: 0 auto;
}
</style>