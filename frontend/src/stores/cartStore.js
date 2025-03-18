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
    async addItem(product) {
      const userStore = useUserStore();
      if (!userStore.user) {
        this.$router.push({ name: 'login' }); // 如果用戶未登錄，跳轉到登錄頁面
        return;
      }

      try {
        await api.post('/cart/add', {
          product_id: product.id,
          quantity: 1,
        });
        await this.fetchCart(); // 重新獲取購物車數據
      } catch (error) {
        console.error('Failed to add item to cart:', error);
      }
    },
    // 從購物車中移除商品
    async removeItem(productId) {
      try {
        await api.delete(`/cart/remove/${productId}`);
        await this.fetchCart(); // 重新獲取購物車數據
      } catch (error) {
        console.error('Failed to remove item from cart:', error);
      }
    },
    // 清空購物車（僅清除前端狀態）
    clearCart() {
      this.items = []; // 清空前端購物車數據
    },
  },
  getters: {
    // 計算購物車中的商品總數
    totalItems: (state) => state.items.reduce((total, item) => total + item.quantity, 0),
  },
});