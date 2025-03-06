<script setup>
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import ProductList from './components/ProductList.vue';



</script>

<template>
<Header></Header>
<router-view></router-view>
<div>
    <h1>Welcome to My Store</h1>
    <ProductList />
  </div>
<Footer></Footer>
</template>

<style scoped>
</style>