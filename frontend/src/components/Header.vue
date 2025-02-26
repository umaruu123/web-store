<template>
    <header class="header">
      <!-- 商標名稱和圖片 -->
      <div class="brand">
        <a href="/" class="brand-link"> <!-- 點擊後回到主頁 -->
          <img src="" alt="Logo" class="brand-logo" /> <!-- 商業圖片 -->
          <h1 class="brand-name">Jellycat</h1> <!-- 商標名稱 -->
        </a>
      </div>
  
      <!-- 主要內容（搜索欄、導航欄、圖標） -->
      <div class="main-content">
        <!-- 左邊的搜索欄 -->
        <div class="search-bar">
          <input
            type="text"
            placeholder="Search"
            class="search-input"
            v-model="searchQuery"
            @keyup.enter="handleSearch"
          />
        </div>
  
        <!-- 中間的導航欄 -->
        <nav class="nav">
          <ul class="nav-list">
            <li class="nav-item"><a href="#">NEW</a></li>
            <li class="nav-item"><a href="#">EXPLORE ALL</a></li>
            <li class="nav-item"><a href="#">DISCOVER</a></li>
            <li class="nav-item"><a href="#">ANIMALS</a></li>
            <li class="nav-item"><a href="#">AMUSEABLES</a></li>
            <li class="nav-item"><a href="#">BAGS & CHAIRS</a></li>
            <li class="nav-item"><a href="#">BABY & BOOKS</a></li>
            <li class="nav-item"><a href="#">PERSONALISED</a></li>
            <li class="nav-item"><a href="#">GIFTS</a></li>
          </ul>
        </nav>
  
        <!-- 右邊的圖標 -->
        <div class="icons">
          <a href="#" class="icon-link">
            <i class="fas fa-user"></i> <!-- 用戶圖標 -->
          </a>
          <a href="#" class="icon-link">
            <i class="fas fa-heart"></i> <!-- 收藏圖標 -->
          </a>
          <a href="#" class="icon-link">
            <i class="fas fa-shopping-cart"></i> <!-- 購物車圖標 -->
          </a>
        </div>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    name: 'Header',
    data() {
      return {
        searchQuery: '', // 綁定輸入框的值
      };
    },
    methods: {
      handleSearch() {
        if (this.searchQuery.trim()) {
          console.log('Searching for:', this.searchQuery);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .header {
    background-color: #f8f8f8;
    border-bottom: 1px solid #e7e7e7;
    padding: 10px 20px;
  }
  
  .brand {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px; /* 商標名稱與下方內容的間距 */
  }
  
  .brand-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: inherit;
  }
  
  .brand-logo {
    width: 40px; /* 圖片寬度 */
    height: 40px; /* 圖片高度 */
    margin-right: 10px; /* 圖片與商標名稱的間距 */
  }
  
  .brand-name {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
    color: #333;
  }
  
  .main-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .search-bar {
    display: flex;
    align-items: center;
  }
  
  .search-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
  }
  
  .nav-list {
    list-style: none;
    display: flex;
    justify-content: center;
    margin: 0;
    padding: 0;
  }
  
  .nav-item {
    margin: 0 10px;
  }
  
  .nav-item a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
  }
  
  .nav-item a:hover {
    color: #007bff;
  }
  
  .icons {
    display: flex;
    align-items: center;
  }
  
  .icon-link {
    margin-left: 15px;
    color: #333;
    text-decoration: none;
    font-size: 18px;
  }
  
  .icon-link:hover {
    color: #007bff;
  }
  </style>