import { defineStore } from 'pinia';
import axios from 'axios';
import { useUserStore } from '@/stores/userStore'; // 引入用戶 Store

// 統一配置 API 基礎路徑
const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
});

// 添加請求攔截器，將 Token 附加到請求頭中
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('authToken');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [], // 購物車中的商品列表
  }),
  actions: {
    // 從後端獲取購物車數據
    async fetchCart() {
      const userStore = useUserStore();
      if (!userStore.user) {
        this.items = []; // 如果用戶未登錄，清空購物車數據
        return;
      }

      try {
        const response = await api.get('/cart');
        console.log('Cart API Response:', response.data); // 打印返回的數據
        if (Array.isArray(response.data)) {
          // 更新 items 狀態
          this.items = response.data.map((item) => ({
            ...item.product, // 將後端返回的商品數據映射到前端格式
            quantity: item.quantity,
            price: parseFloat(item.product.price), // 將 price 轉換為數字
          }));
        } else {
          console.error('Invalid cart data format:', response.data);
        }
      } catch (error) {
        console.error('Failed to fetch cart:', error);
      }
    },

    // 添加商品到購物車
    async addItem(product, quantity = 1) {
      const userStore = useUserStore();
      if (!userStore.user) {
        this.$router.push({ name: 'login' }); // 如果用戶未登錄，跳轉到登錄頁面
        return;
      }

      try {
        // 更新後端數據
        await api.post('/cart/add', {
          product_id: product.id,
          quantity: quantity,
        });

        // 更新本地狀態
        const existingItem = this.items.find((item) => item.id === product.id);
        if (existingItem) {
          existingItem.quantity += quantity; // 如果商品已存在，增加數量
        } else {
          this.items.push({ ...product, quantity }); // 如果商品不存在，添加到購物車
        }

        console.log('Item added to cart:', product); // 調試信息
      } catch (error) {
        console.error('Failed to add item to cart:', error);
      }
    },

    // 從購物車中移除商品
    async removeItem(productId) {
      try {
        // 更新後端數據
        await api.delete(`/cart/remove/${productId}`);

        // 更新本地狀態
        this.items = this.items.filter((item) => item.id !== productId);

        console.log('Item removed from cart:', productId); // 調試信息
      } catch (error) {
        console.error('Failed to remove item from cart:', error);
      }
    },

    // 清空購物車
    async clearCart() {
      try {
        // 更新後端數據
        await api.delete('/cart/clear');

        // 更新本地狀態
        this.items = [];

        console.log('Cart cleared'); // 調試信息
      } catch (error) {
        console.error('Failed to clear cart:', error);
      }
    },
  },
  getters: {
    // 計算購物車中的商品總數
    totalItems: (state) => state.items.reduce((total, item) => total + item.quantity, 0),
  },
});