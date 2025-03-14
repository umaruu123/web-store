<template>
    <div class="admin-sidebar">
      <div class="sidebar-header">
        <h2>Admin Panel</h2>
      </div>
      <ul class="sidebar-menu">
        <li @click="navigate('/admin/users')">Users</li>
        <li @click="navigate('/admin/orders')">Orders</li>
        <li @click="navigate('/admin/products')">Products</li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      navigate(route) {
        this.$emit('navigate', route); // 通知父組件導航
      },
    },
  };
  </script>
  
  <style scoped>
  .admin-sidebar {
    width: 250px;
    background-color: #343a40;
    color: white;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
  }
  
  .sidebar-header {
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #4b545c;
  }
  
  .sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .sidebar-menu li {
    padding: 15px 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .sidebar-menu li:hover {
    background-color: #4b545c;
  }
  </style>