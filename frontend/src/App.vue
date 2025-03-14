<script>
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

export default {
  name: 'App',
  components: {
    Header,
    Footer,
  },
  computed: {
    // 檢查當前路由是否為 Admin Dashboard
    isAdminRoute() {
      return this.$route.path.startsWith('/admin');
    },
  },
};
</script>

<template>
  <Header v-if="!isAdminRoute"></Header> <!-- 非 Admin 路由時顯示 Header -->
  <router-view></router-view>
  <Footer v-if="!isAdminRoute"></Footer> <!-- 非 Admin 路由時顯示 Footer -->
</template>

<style scoped>
</style>