<template>
  <div class="cart-page">
    <h1>Your Cart</h1>
    <div v-if="cartItems.length > 0">
      <table class="cart-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in cartItems" :key="item.id">
            <td class="product-image">
              <img :src="item.image_url" :alt="item.name" class="product-img" />
              <span class="product-name">{{ item.name }}</span>
              <!-- 顯示庫存狀態 -->
              <div :class="['stock-status', item.stock > 0 ? 'in-stock' : 'out-of-stock']">
                {{ item.stock > 0 ? 'In Stock' : 'Out of Stock' }}
              </div>
            </td>
            <td>RM{{ item.price.toFixed(2) }}</td>
            <td>
              <div class="quantity-control">
                <button @click="decreaseQuantity(item)" class="quantity-button">-</button>
                <span class="quantity">{{ item.quantity }}</span>
                <button @click="increaseQuantity(item)" class="quantity-button">+</button>
              </div>
            </td>
            <td>
              <span>RM{{ (item.price * item.quantity).toFixed(2) }}</span>
              <button @click="removeItem(item.id)" class="delete-button">✕</button>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" class="total-label">Total</td>
            <td class="total-amount">RM{{ totalAmount.toFixed(2) }}</td>
          </tr>
        </tfoot>
      </table>
      <!-- 根據庫存狀態禁用 Check Out 按鈕 -->
      <button
        class="checkout-button"
        :class="{ disabled: isOutOfStock }"
        @click="goToCheckout"
        :disabled="isOutOfStock"
      >
        {{ isOutOfStock ? 'Out of Stock' : 'Check Out' }}
      </button>
    </div>
    <div v-else class="empty-cart">
      <p>Your cart is empty.</p>
      <router-link to="/" class="continue-shopping">Continue Shopping</router-link>
    </div>
  </div>
</template>

<script>
import { useCartStore } from '@/stores/cartStore';
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
  name: 'Cart',
  setup() {
    const cartStore = useCartStore();
    const router = useRouter();

    // 計算購物車總金額
    const totalAmount = computed(() => {
      return cartStore.items.reduce((total, item) => {
        return total + item.price * item.quantity;
      }, 0);
    });

    // 檢查是否有商品是 Out of Stock
    const isOutOfStock = computed(() => {
      return cartStore.items.some((item) => item.stock <= 0);
    });

    // 頁面加載時獲取購物車數據
    onMounted(() => {
      cartStore.fetchCart();
    });

    return {
      cartItems: computed(() => cartStore.items),
      totalAmount,
      isOutOfStock,
    };
  },
  methods: {
    // 增加商品數量
    async increaseQuantity(item) {
      const cartStore = useCartStore();
      await cartStore.addItem(item); // 增加數量
    },
    // 減少商品數量
    async decreaseQuantity(item) {
      const cartStore = useCartStore();
      if (item.quantity > 1) {
        await cartStore.addItem(item, -1); // 減少數量
      } else {
        await cartStore.removeItem(item.id); // 移除商品
      }
    },
    // 刪除商品
    async removeItem(productId) {
      const cartStore = useCartStore();
      await cartStore.removeItem(productId);
    },
    // 前往付款頁面
    goToCheckout() {
      this.$router.push({ name: 'Checkout' });
    },
  },
};
</script>

<style scoped>
.cart-page {
  padding: 100px 20px 20px; /* 添加 padding-top 避免被 Header 覆蓋 */
  max-width: 1200px;
  margin: 0 auto;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
  font-size: 32px;
  color: #333;
}

.cart-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 30px;
  background-color: #fff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
}

.cart-table th,
.cart-table td {
  padding: 15px;
  border: 1px solid #eee;
  text-align: center;
}

.cart-table th {
  background-color: #007bff;
  color: white;
  font-weight: bold;
}

.product-image {
  display: flex;
  align-items: center;
  gap: 15px;
}

.product-img {
  width: 80px;
  height: 80px;
  border-radius: 8px;
  object-fit: cover;
}

.product-name {
  font-size: 18px;
  font-weight: bold;
  color: #333;
}

.quantity-control {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.quantity-button {
  padding: 8px 16px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.quantity-button:hover {
  background-color: #0056b3;
}

.quantity {
  font-size: 18px;
  font-weight: bold;
}

.delete-button {
  margin-left: 10px;
  padding: 8px 16px;
  background-color: #ff4d4d;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.delete-button:hover {
  background-color: #cc0000;
}

.total-label {
  text-align: right;
  font-weight: bold;
  font-size: 20px;
  color: #333;
}

.total-amount {
  font-weight: bold;
  font-size: 20px;
  color: #28a745;
}

.checkout-button {
  display: block;
  width: 100%;
  max-width: 300px;
  margin: 30px auto;
  padding: 15px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.checkout-button.disabled {
  background-color: #ccc; /* 灰色 */
  cursor: not-allowed;
}

.checkout-button.disabled:hover {
  background-color: #ccc; /* 保持灰色 */
}

.checkout-button:hover:not(.disabled) {
  background-color: #218838;
}

.empty-cart {
  text-align: center;
  font-size: 20px;
  color: #666;
  margin-top: 50px;
}

.continue-shopping {
  display: inline-block;
  margin-top: 20px;
  padding: 12px 24px;
  background-color: #007bff;
  color: white;
  border-radius: 8px;
  text-decoration: none;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.continue-shopping:hover {
  background-color: #0056b3;
}

.stock-status {
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: bold;
  color: white;
}

.stock-status.in-stock {
  background-color: #28a745; /* 綠色 */
}

.stock-status.out-of-stock {
  background-color: #dc3545; /* 紅色 */
}
</style>