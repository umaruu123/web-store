<template>
  <div class="product-details">
    <div v-if="loading" class="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="product-info">
      <img :src="product.image_url" :alt="product.name" class="product-image" />
      <h1 class="product-name">{{ product.name }}</h1>
      <p class="product-price">RM{{ parseFloat(product.price).toFixed(2) }}</p>
      <p class="product-description">{{ product.description }}</p>

      <!-- 按鈕區域 -->
      <div class="button-group">
        <button class="wishlist-button" @click="addToWishlist(product.id)">
          Add to Wishlist
        </button>
        <!-- 根據庫存狀態禁用 Add to Cart 按鈕 -->
        <button
          class="cart-button"
          :class="{ disabled: product.stock <= 0 }"
          @click="addToCart(product)"
          :disabled="product.stock <= 0"
        >
          {{ product.stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useUserStore } from '@/stores/userStore'; // 引入用戶 Store
import { useCartStore } from '@/stores/cartStore'; // 引入購物車 Store
import { mapState } from 'pinia';

export default {
  data() {
    return {
      product: null,
      loading: true,
      error: null,
    };
  },
  computed: {
    // 使用 mapState 獲取用戶狀態
    ...mapState(useUserStore, ['user']),
  },
  async mounted() {
    const productId = this.$route.params.id;
    try {
      const response = await axios.get(
        `http://127.0.0.1:8000/api/products/${productId}/details`
      );
      this.product = response.data;
      this.product.price = parseFloat(this.product.price);
    } catch (err) {
      this.error = 'Failed to load product details.';
      console.error(err);
    } finally {
      this.loading = false;
    }
  },
  methods: {
  async addToCart(product) {
    if (!this.user) {
      // 如果用戶未登錄，跳轉到登錄頁面
      this.$router.push({ name: 'login' });
    } else {
      // 如果用戶已登錄，調用後端 API 添加商品到購物車
      const cartStore = useCartStore();
      await cartStore.addItem(product);
      alert('Product added to cart!');
    }
  },

    // 添加到願望清單
    async addToWishlist(productId) {
      try {
        const response = await axios.post(
          'http://127.0.0.1:8000/api/wishlist',
          { itemId: productId }
        );
        alert('Product added to wishlist!');
        console.log('Wishlist response:', response.data);
      } catch (err) {
        alert('Failed to add to wishlist.');
        console.error(err);
      }
    },
  },
};
</script>
  
  <style scoped>
  .product-details {
    padding: 10rem;
    text-align: center;
  }
  
  .product-info {
    max-width: 600px;
    margin: 0 auto;
  }
  
  .product-image {
    width: 100%;
    height: auto;
    border-radius: 12px;
    margin-bottom: 1rem;
  }
  
  .product-name {
    font-size: 2rem;
    font-weight: bold;
    margin: 1rem 0;
  }
  
  .product-price {
    font-size: 1.5rem;
    color: #28a745;
    font-weight: bold;
    margin-bottom: 1rem;
  }
  
  .product-description {
    font-size: 1.2rem;
    color: #555;
    margin-bottom: 2rem;
  }
  
  /* 按鈕區域 */
  .button-group {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
  }
  
  .wishlist-button,
  .cart-button {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }
  
  .wishlist-button {
    background-color: #ff6b6b;
    color: white;
  }
  
  .wishlist-button:hover {
    background-color: #ff4c4c;
    transform: translateY(-2px);
  }
  
  .cart-button {
    background-color: #007bff;
    color: white;
  }
  
  .cart-button:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
  }
  
  .loading,
  .error {
    font-size: 1.2rem;
    color: #333;
    margin-top: 20px;
  }
  .cart-button.disabled {
    background-color: #ccc; /* 灰色 */
    cursor: not-allowed;
  }

  .cart-button.disabled:hover {
    background-color: #ccc; /* 保持灰色 */
  }
  </style>