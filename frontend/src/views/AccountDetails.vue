<template>
    <div class="account-details">
      <h1>Account Details</h1>
      <div class="button-container">
        <button @click="navigateTo('Orders')">Orders</button>
        <button @click="navigateTo('Addresses')">Addresses</button>
        <button @click="navigateTo('Wishlists')">Wishlists</button>
        <button @click="navigateTo('RecentlyViewed')">Recently Viewed</button>
        <button @click="navigateTo('AccountDetails')">Account Details</button>
        <button @click="logout">Log Out</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      navigateTo(routeName) {
        // 根據按鈕點擊切換到對應的路由
        this.$router.push({ name: routeName });
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
  }
  
  .button-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    margin-top: 20px;
  }
  
  button {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    transition: background-color 0.3s ease;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  </style>