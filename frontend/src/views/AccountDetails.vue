<template>
  <div class="account-details">
    <!-- 動態顯示當前選項的標題 -->
    <h1>{{ currentTitle }}</h1>
    <div class="options-container">
      <!-- 使用 span 替代 label -->
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
export default {
  data() {
    return {
      currentTitle: 'Account Details', // 當前顯示的標題
    };
  },
  methods: {
    navigateTo(routeName) {
      // 根據點擊切換到對應的路由
      this.$router.push({ name: routeName });

      // 更新當前標題
      this.updateTitle(routeName);
    },
    updateTitle(routeName) {
      // 根據路由名稱更新標題
      switch (routeName) {
        case 'Orders':
          this.currentTitle = 'Orders';
          break;
        case 'Addresses':
          this.currentTitle = 'Addresses';
          break;
        case 'Wishlists':
          this.currentTitle = 'Wishlists';
          break;
        case 'RecentlyViewed':
          this.currentTitle = 'Recently Viewed';
          break;
        case 'AccountDetails':
          this.currentTitle = 'Account Details';
          break;
        default:
          this.currentTitle = 'Account Details';
      }
    },
    logout() {
      // 清除 localStorage 中的用戶信息
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');

      // 重定向到登入頁面
      this.$router.push('/login');
    },
  },
};
</script>

<style scoped>
.account-details {
  text-align: center;
  padding: 20px;
  margin-top: 80px; /* 避免被 Header 覆蓋 */
}

/* 將 options-container 設置為並排顯示 */
.options-container {
  display: flex;
  justify-content: center; /* 水平居中 */
  gap: 20px; /* 設置間距 */
  margin-top: 20px;
}

/* 設置 option 的樣式 */
.option {
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  color: #007bff; /* 文字顏色 */
  transition: color 0.3s ease;
}

/* 滑鼠懸停效果 */
.option:hover {
  color: #0056b3; /* 滑鼠懸停時變深藍色 */
  text-decoration: underline; /* 滑鼠懸停時加底線 */
}
</style>