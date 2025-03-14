<template>
  <div class="account-navigation">
    <!-- 顯示標題 -->
    <h1>{{ title }}</h1>
    <!-- 導航選項 -->
    <div class="options-container">
      <span @click="navigateTo('Orders')" class="option">Orders</span>
      <span @click="navigateTo('Addresses')" class="option">Addresses</span>
      <span @click="navigateTo('Wishlists')" class="option">Wishlists</span>
      <span @click="navigateTo('RecentlyViewed')" class="option">Recently Viewed</span>
      <span @click="navigateTo('AccountDetails')" class="option">Account Details</span>
      <span @click="logout" class="option">Log Out</span>
    </div>
  </div>
</template>

<script>
import { useUserStore } from '@/stores/userStore'; // 引入 Pinia Store

export default {
  props: {
    title: {
      type: String,
      required: true, // 標題為必填
    },
  },
  methods: {
    navigateTo(routeName) {
      this.$router.push({ name: routeName });
    },
    logout() {
      const userStore = useUserStore();
      userStore.clearUser(); // 清除 Pinia Store 中的用戶狀態
      localStorage.removeItem('authToken'); // 清除 localStorage 中的 authToken
      localStorage.removeItem('user'); // 清除 localStorage 中的 user
      this.$router.push('/login'); // 跳轉到登錄頁面
    },
  },
};
</script>

<style scoped>
.account-navigation {
  text-align: center;
  padding: 20px;
}

h1 {
  margin-bottom: 20px; /* 標題與導航選項之間的間距 */
}

.options-container {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 20px;
}

.option {
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  color: #007bff;
  transition: color 0.3s ease;
}

.option:hover {
  color: #0056b3;
  text-decoration: underline;
}

.account-navigation {
  text-align: center;
  padding-top: 80px; /* 確保內容不被 Header 遮擋 */
}
</style>