<template>
  <div class="admin-navbar">
    <div class="navbar-right">
      <button @click="logout">Logout</button>
    </div>
  </div>
</template>

<script>
import { useUserStore } from '@/stores/userStore'; // 引入 Pinia Store

export default {
  methods: {
    logout() {
      // 清除 localStorage 中的用戶數據
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');

      // 重置 Pinia Store 中的用戶狀態
      const userStore = useUserStore();
      userStore.clearUser();

      // 重定向到登錄頁面
      this.$router.push('/login');
    },
  },
};
</script>
  
  <style scoped>
  .admin-navbar {
    background-color: white;
    padding: 10px 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: flex-end;
  }
  
  .navbar-right button {
    padding: 8px 16px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .navbar-right button:hover {
    background-color: #c82333;
  }
  </style>