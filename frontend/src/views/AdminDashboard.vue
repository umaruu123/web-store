<template>
  <div class="admin-dashboard">
    <!-- 側邊欄 -->
    <AdminSidebar @navigate="handleNavigation" />

    <!-- 主內容區 -->
    <div class="main-content">
      <!-- 頂部導航欄 -->
      <AdminNavbar @logout="handleLogout" />

      <!-- 動態加載的子頁面 -->
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import AdminSidebar from '@/components/AdminSidebar.vue';
import AdminNavbar from '@/components/AdminNavbar.vue';

export default {
  components: {
    AdminSidebar,
    AdminNavbar,
  },
  methods: {
    handleNavigation(route) {
      this.$router.push(route); // 導航到指定頁面
    },
    handleLogout() {
      // 處理登出邏輯
      alert('Logged out successfully!');
      this.$router.push('/login'); // 跳轉到登錄頁
    },
  },
  mounted() {
    // 隱藏全局 Header
    this.$root.showHeader = false;
  },
  beforeDestroy() {
    // 恢復全局 Header
    this.$root.showHeader = true;
  },
};
</script>

<style scoped>
.admin-dashboard {
  display: flex;
  min-height: 100vh;
  background-color: #f8f9fa;
}

.main-content {
  flex: 1;
  padding: 20px;
  margin-left: 250px; /* 側邊欄寬度 */
}
</style>