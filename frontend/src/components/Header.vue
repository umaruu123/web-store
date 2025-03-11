<template>
  <header class="header">
    <!-- 商標名稱和圖片 -->
    <div class="brand">
      <a href="/" class="brand-link">
        <img src="/image/toyLogo.webp" alt="Logo" class="brand-logo" />
        <h1 class="brand-name">MochiPals</h1>
      </a>
    </div>

    <!-- 主要內容（漢堡選單、搜索欄、導航欄、圖標） -->
    <div class="main-content">
      <div class="left-group">
        <!-- 漢堡選單按鈕 -->
        <button class="menu-toggle" @click="menuOpen = !menuOpen">☰</button>

        <!-- 搜索欄 -->
        <div class="search-container">
          <!-- 🔍 按鈕（僅在小螢幕時顯示） -->
          <button class="search-icon" v-if="isMobile" @click="showSearchBar = !showSearchBar">🔍</button>

          <!-- 搜索輸入框（大螢幕時直接顯示，小螢幕點擊 🔍 後顯示） -->
          <input
            type="text"
            placeholder="Search"
            class="search-input"
            v-model="searchQuery"
            @keyup.enter="handleSearch"
            @blur="hideSearch"
            :class="{ 'hidden-mobile': isMobile && !showSearchBar }"
          />
        </div>
      </div>

      <!-- 中間的導航欄 -->
      <nav :class="['nav', { 'nav-open': menuOpen }]">
        <ul class="nav-list">
          <li class="nav-item"><a href="#">Home</a></li>
          <li class="nav-item"><a href="#">EXPLORE ALL</a></li>
          <li class="nav-item"><a href="#">ANIMALS</a></li>
          <li class="nav-item"><a href="#">BAGS & CHAIRS</a></li>
          <li class="nav-item"><a href="#">BABY & BOOKS</a></li>
        </ul>
      </nav>

      <!-- 右邊的圖標 -->
      <div class="icons">
        <!-- 用戶圖標：根據登入狀態顯示不同內容 -->
        <router-link v-if="user" to="/account" class="icon-link">
          <i class="fas fa-user"></i>
        </router-link>
        <router-link v-else to="/login" class="icon-link">
          <i class="fas fa-user"></i>
        </router-link>

        <!-- 其他圖標 -->
        <a href="#" class="icon-link">
          <i class="fas fa-heart"></i>
        </a>
        <a href="#" class="icon-link">
          <i class="fas fa-shopping-cart"></i>
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
      searchQuery: '',
      menuOpen: false, // 控制漢堡選單開關
      showSearchBar: false, // 控制是否顯示搜尋框（小螢幕）
      isMobile: window.innerWidth < 1280, // 判斷是否為小螢幕
      user: null, // 存儲用戶信息
    };
  },
  created() {
    // 從 localStorage 中讀取用戶信息
    const user = JSON.parse(localStorage.getItem('user'));
    if (user) {
      this.user = user;
    }
  },
  methods: {
    handleSearch() {
      if (this.searchQuery.trim()) {
        console.log('Searching for:', this.searchQuery);
      }
    },
    hideSearch() {
      if (!this.searchQuery.trim()) {
        this.showSearchBar = false; // 如果沒有輸入內容，則隱藏搜尋框
      }
    },
    updateScreenSize() {
      this.isMobile = window.innerWidth < 1280;
    },
    logout() {
      // 清除 localStorage 中的用戶信息
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      this.user = null;

      // 重定向到登入頁面
      this.$router.push('/login');
    },
  },
  mounted() {
    window.addEventListener('resize', this.updateScreenSize);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.updateScreenSize);
  },
};
</script>

<style scoped>
.header {
  width: 100%;
  max-width: 100vw; /* 防止超出視窗 */
  background-color: #f8f8f8;
  border-bottom: 1px solid #e7e7e7;
  padding: 10px 0; /* 只保留上下 padding，不影響寬度 */
  position: fixed; /* 讓 header 固定在頂部 */
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000; /* 確保在最上層 */
}

.brand {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 10px;
}

.brand-link {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: inherit;
}

.brand-logo {
  width: 80px; /* 調整這個值來讓 Logo 變大 */
  height: auto;
  max-width: 100%;
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
  position: relative;
  padding: 0 20px; /* 左右增加內距，讓 search bar 和 icon 不貼邊 */
}

/* 左側組合（漢堡選單 + 搜索欄） */
.left-group {
  display: flex;
  align-items: center;
  gap: 10px;
}

/* 漢堡選單按鈕 */
.menu-toggle {
  display: none;
  font-size: 24px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 5px 10px;
}

/* 搜索欄容器 */
.search-container {
  margin-left: 20px; /* 讓搜尋框不貼著邊緣 */
}

/* 搜索圖示按鈕 */
.search-icon {
  display: none;
  font-size: 20px;
  background: none;
  border: none;
  cursor: pointer;
}

/* 搜索輸入框 */
.search-input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 200px;
  transition: width 0.3s ease;
}

/* 預設隱藏 search bar（小螢幕） */
.hidden-mobile {
  display: none;
}

/* 導航列表 */
.nav-list {
  list-style: none;
  display: flex;
  flex-direction: row;
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
  white-space: nowrap;
}

.nav-item a:hover {
  color: #007bff;
}

/* 右側圖標 */
.icons {
  display: flex;
  align-items: center;
  gap: 15px; /* 圖標之間的間距 */
  padding-right: 20px; /* 右邊留白 */
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

/* 登出按鈕 */
.logout-button {
  background: none;
  border: none;
  color: #333;
  font-size: 16px;
  cursor: pointer;
  margin-left: 15px;
}

.logout-button:hover {
  color: #007bff;
}

/* 📌 當螢幕介於 1280px ~ 1400px */
@media (max-width: 1400px) {
  .nav-list {
    font-size: 14px; /* 縮小字體 */
    gap: 8px; /* 增加間距 */
    flex-wrap: wrap; /* 避免擠壓，必要時換行 */
  }

  .nav-item {
    margin: 4px 6px; /* 減小間距 */
  }

  .icons {
    min-width: 120px; /* 保證右邊圖標區域不會擠壓 */
  }
}

/* 📌 1280px 以下隱藏 nav-list，顯示漢堡選單 */
@media (max-width: 1280px) {
  .nav {
    display: none;
  }

  .menu-toggle {
    display: block;
  }

  /* 讓左側組合（漢堡選單 + 搜索）靠左 */
  .left-group {
    flex: 1;
  }

  /* 隱藏導航欄 */
  .nav {
    display: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 100%;
    background: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .nav-list {
    flex-direction: column;
    text-align: center;
    padding: 10px 0;
  }

  .nav-item {
    padding: 10px 0;
  }

  /* 當 menuOpen 為 true 時顯示導航欄 */
  .nav.nav-open {
    display: block;
  }

  /* 顯示漢堡選單按鈕 */
  .menu-toggle {
    display: block;
  }

  /* 讓 search bar 變成 🔍 按鈕 */
  .search-icon {
    display: block;
  }
}
</style>