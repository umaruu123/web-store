<script>
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import axios from 'axios';
import { useUserStore } from '@/stores/userStore'; // 引入 Pinia Store

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
  async mounted() {
    const token = localStorage.getItem('authToken');
    if (token) {
      try {
        // 驗證 Token 是否有效
        const response = await axios.get('http://127.0.0.1:8000/api/user/details', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        const userStore = useUserStore();
        userStore.setUser(response.data); // 更新用戶狀態
      } catch (error) {
        // Token 無效，清除用戶狀態並重定向到登錄頁面
        localStorage.removeItem('authToken');
        localStorage.removeItem('user');
        this.$router.push({ name: 'login' });
      }
    }
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