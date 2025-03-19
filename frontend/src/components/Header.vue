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
          <button class="search-icon" v-if="isMobile" @click="showSearchBar = !showSearchBar">🔍</button>
          <input
            type="text"
            placeholder="Search"
            class="search-input"
            v-model="searchQuery"
            @input="handleSearch"
            @blur="hideSearch"
            :class="{ 'hidden-mobile': isMobile && !showSearchBar }"
          />
          <!-- 搜索結果 -->
          <div v-if="searchResults.length > 0" class="search-results">
            <ul>
              <li v-for="product in searchResults" :key="product.id" @click="goToProduct(product.id)">
                <img :src="product.image_url" :alt="product.name" class="search-result-image" />
                <span class="search-result-name">{{ product.name }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- 中間的導航欄 -->
      <nav :class="['nav', { 'nav-open': menuOpen }]">
        <ul class="nav-list">
          <li class="nav-item">
            <router-link to="/">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/explore-all">EXPLORE ALL</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/animals">ANIMALS</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/bags-chairs">BAGS & CHAIRS</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/baby-books">BABY & BOOKS</router-link>
          </li>
        </ul>
      </nav>

      <!-- 右邊的圖標 -->
      <div class="icons">
        <!-- 用戶圖標 -->
        <router-link v-if="user" to="/account/details" class="icon-link">
          <i class="fas fa-user"></i>
        </router-link>
        <router-link v-else to="/login" class="icon-link">
          <i class="fas fa-user"></i>
        </router-link>

        <!-- 其他圖標 -->
        <a href="#" class="icon-link" @click.prevent="goToWishlist">
          <i class="fas fa-heart"></i>
        </a>
        <div class="cart-icon" @mouseenter="showCartPreview = true" @mouseleave="showCartPreview = false">
          <i class="fas fa-shopping-cart"></i>
          <span class="cart-count">{{ cartTotalItems }}</span>
          <!-- 購物車預覽 -->
          <div v-if="showCartPreview" class="cart-preview">
            <div v-if="cartItems.length > 0">
              <div v-for="item in cartItems" :key="item.id" class="cart-item">
                <img :src="item.image_url" :alt="item.name" class="cart-item-image" />
                <div class="cart-item-details">
                  <p class="cart-item-name">{{ item.name }}</p>
                  <p class="cart-item-price">RM{{ typeof item.price === 'number' ? item.price.toFixed(2) : 'N/A' }}</p>
                  <p class="cart-item-quantity">Quantity: {{ item.quantity }}</p>
                </div>
              </div>
              <!-- 添加 Check Out 按鈕 -->
              <button class="checkout-button" @click="goToCart">Check Out</button>
            </div>
            <div v-else class="empty-cart">
              Your cart is empty.
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { useUserStore } from '@/stores/userStore'; // 引入用戶 Store
import { useCartStore } from '@/stores/cartStore'; // 引入購物車 Store
import { mapState } from 'pinia';
import axios from 'axios';

export default {
  name: 'Header',
  data() {
    return {
      searchQuery: '',
      searchResults: [],
      menuOpen: false,
      showSearchBar: false,
      isMobile: window.innerWidth < 1280,
      showCartPreview: false, // 控制購物車預覽的顯示
    };
  },
  computed: {
    // 使用 mapState 獲取用戶和購物車狀態
    ...mapState(useUserStore, ['user']),
    ...mapState(useCartStore, ['items', 'totalItems']),
    // 購物車中的商品列表
    cartItems() {
      return this.items;
    },
    // 購物車中的商品總數
    cartTotalItems() {
      return this.totalItems;
    },
  },
  methods: {
    // 處理搜索
    async handleSearch() {
      if (this.searchQuery.trim()) {
        try {
          const response = await axios.get(`http://127.0.0.1:8000/api/products?search=${this.searchQuery}`);
          this.searchResults = response.data;
        } catch (error) {
          console.error('Search failed:', error);
        }
      } else {
        this.searchResults = [];
      }
    },
    // 隱藏搜索欄
    hideSearch() {
      if (!this.searchQuery.trim()) {
        this.showSearchBar = false;
      }
    },
    // 更新屏幕大小
    updateScreenSize() {
      this.isMobile = window.innerWidth < 1280;
    },
    // 跳轉到購物車頁面
    goToCart() {
      this.$router.push({ name: 'Cart' });
    },
    // 跳轉到產品詳情頁面
    goToProduct(productId) {
      this.$router.push({ name: 'ProductDetails', params: { id: productId } });
      this.searchResults = []; // 清空搜索結果
    },
    goToWishlist() {
    const userStore = useUserStore();
    if (!userStore.user) {
      // 如果用戶未登錄，跳轉到登錄頁面
      this.$router.push({ name: 'login' });
    } else {
      // 如果用戶已登錄，跳轉到願望清單頁面
      this.$router.push({ name: 'Wishlists' });
    }
  },
  },
  async mounted() {
    // 監聽窗口大小變化
    window.addEventListener('resize', this.updateScreenSize);

    // 如果用戶已登錄，獲取購物車數據
    if (this.user) {
      const cartStore = useCartStore();
      await cartStore.fetchCart(); // 從後端獲取購物車數據
    }
  },
  beforeUnmount() {
    // 移除窗口大小變化監聽器
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

.search-results {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  background-color: white;
  border: 1px solid #ccc;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  max-height: 300px;
  overflow-y: auto;
}

.search-results ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.search-results li {
  display: flex;
  align-items: center;
  padding: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.search-results li:hover {
  background-color: #f0f0f0;
}

.search-result-image {
  width: 40px;
  height: 40px;
  margin-right: 10px;
  border-radius: 4px;
}

.search-result-name {
  font-size: 14px;
  color: #333;
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

/* 購物車圖標樣式 */
.cart-icon {
  position: relative;
  cursor: pointer;
}

.cart-count {
  position: absolute;
  top: -8px;
  right: -8px;
  background-color: red;
  color: white;
  border-radius: 50%;
  padding: 2px 6px;
  font-size: 12px;
}

/* 購物車預覽樣式 */
.cart-preview {
  position: absolute;
  top: 100%;
  right: 0;
  width: 300px;
  background-color: white;
  border: 1px solid #ccc;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  padding: 10px;
}

.cart-item {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.cart-item-image {
  width: 50px;
  height: 50px;
  margin-right: 10px;
}

.cart-item-details {
  flex: 1;
}

.cart-item-name {
  font-size: 14px;
  font-weight: bold;
}

.cart-item-price {
  font-size: 12px;
  color: #888;
}

.cart-item-quantity {
  font-size: 12px;
  color: #888;
}

.empty-cart {
  text-align: center;
  font-size: 14px;
  color: #888;
}

/* Check Out 按鈕樣式 */
.checkout-button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 14px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.checkout-button:hover {
  background-color: #0056b3;
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