<template>
  <div class="wishlists">
    <AccountNavigation title="Wishlists" />
    <div v-if="loading">Loading...</div>
    <div v-else>
      <ul>
        <li v-for="item in wishlist" :key="item.id">
          <div class="wishlist-item">
            <img :src="item.product.image_url" :alt="item.product.name" class="product-image" />
            <div class="product-info">
              <p class="product-name">{{ item.product.name }}</p>
              <p class="product-price">RM{{ parseFloat(item.product.price).toFixed(2) }}</p>
            </div>
            <div class="actions">
              <button class="remove-button" @click="removeFromWishlist(item.id)">Remove</button>
              <button class="add-to-cart-button" @click="addToCart(item.product.id)">Add to Cart</button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useUserStore } from '@/stores/userStore'; // 引入用戶 Store
import { useCartStore } from '@/stores/cartStore'; // 引入購物車 Store
import api from '@/api'; // 引入 api.js
import AccountNavigation from '@/components/AccountNavigation.vue'; // 引入導航組件

export default {
  components: {
    AccountNavigation, // 註冊導航組件
  },
  setup() {
    const wishlist = ref([]);
    const loading = ref(true);
    const userStore = useUserStore();
    const cartStore = useCartStore();

    // 獲取願望清單
    const fetchWishlist = async () => {
      try {
        const response = await api.getWishlist(); // 使用 api.js 的 getWishlist 方法
        wishlist.value = response.data;
      } catch (error) {
        console.error('Failed to fetch wishlist:', error);
      } finally {
        loading.value = false;
      }
    };

    // 從願望清單中移除商品
    const removeFromWishlist = async (itemId) => {
      try {
        await api.removeFromWishlist(itemId); // 使用 api.js 的 removeFromWishlist 方法
        fetchWishlist(); // 重新加載願望清單
        alert('Item removed from wishlist!');
      } catch (error) {
        console.error('Failed to remove item:', error);
        alert('Failed to remove item from wishlist.');
      }
    };

    // 將商品添加到購物車
    const addToCart = async (productId) => {
      if (!userStore.user) {
        // 如果用戶未登錄，跳轉到登錄頁面
        alert('Please login to add items to cart.');
        return;
      }

      try {
        // 檢查商品庫存
        const productResponse = await api.getProductDetails(productId); // 獲取商品詳情
        const product = productResponse.data;

        if (product.stock <= 0) {
          alert('This product is out of stock and cannot be added to the cart.');
          return;
        }

        // 如果商品有庫存，添加到購物車
        await cartStore.addItem({ id: productId }); // 使用購物車 Store
        alert('Item added to cart!');
      } catch (error) {
        console.error('Failed to add item to cart:', error);
        alert('Failed to add item to cart.');
      }
    };

    // 組件掛載時獲取願望清單
    onMounted(() => {
      fetchWishlist();
    });

    return {
      wishlist,
      loading,
      removeFromWishlist,
      addToCart,
    };
  },
};
</script>

<style scoped>
.wishlists {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 10px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.wishlist-item {
  display: flex;
  align-items: center;
  gap: 15px;
}

.product-image {
  width: 80px;
  height: 80px;
  border-radius: 8px;
  object-fit: cover;
}

.product-info {
  flex: 1;
}

.product-name {
  font-size: 18px;
  font-weight: bold;
  margin: 0;
}

.product-price {
  font-size: 16px;
  color: #28a745;
  margin: 5px 0;
}

.actions {
  display: flex;
  gap: 10px;
}

button {
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  font-size: 14px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.remove-button {
  background-color: #dc3545;
  color: white;
}

.remove-button:hover {
  background-color: #c82333;
}

.add-to-cart-button {
  background-color: #007bff;
  color: white;
}

.add-to-cart-button:hover {
  background-color: #0056b3;
}
</style>