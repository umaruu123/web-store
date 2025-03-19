<template>
    <div class="checkout-page">
      <h1>Checkout</h1>
      <div class="checkout-container">
        <!-- 左側：訂單摘要和付款信息 -->
        <div class="left-section">
          <div class="shipping-info">
            <div class="shipping-header">
              <h2>Shipping Information</h2>
              <button class="edit-address" @click="goToAddresses">Edit</button>
            </div>
            <div class="info-group">
              <label>Name:</label>
              <p>{{ user.name }}</p>
            </div>
            <div class="info-group">
              <label>Address:</label>
              <p>{{ user.address }}</p>
            </div>
          </div>
          <div class="payment-form">
            <h2>Payment Details</h2>
            <form @submit.prevent="submitPayment">
              <div class="form-group">
                <label for="card-number">Card Number</label>
                <input type="text" id="card-number" v-model="paymentDetails.cardNumber" required />
              </div>
              <div class="form-group">
                <label for="expiry-date">Expiry Date</label>
                <input type="text" id="expiry-date" v-model="paymentDetails.expiryDate" required />
              </div>
              <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" v-model="paymentDetails.cvv" required />
              </div>
              <button type="submit" class="submit-payment">Submit Payment</button>
            </form>
          </div>
        </div>
  
        <!-- 右側：訂單摘要 -->
        <div class="order-summary">
          <div class="summary-header">
            <h2>Order Summary</h2>
            <button class="edit-cart" @click="goToCart">Edit Cart</button>
          </div>
          <div v-for="item in cartItems" :key="item.id" class="checkout-item">
            <img :src="item.image_url" :alt="item.name" class="checkout-item-img" />
            <div class="checkout-item-details">
              <p class="checkout-item-name">{{ item.name }}</p>
              <p class="checkout-item-price">RM{{ item.price.toFixed(2) }}</p>
              <p class="checkout-item-quantity">Quantity: {{ item.quantity }}</p>
            </div>
          </div>
          <div class="checkout-total">
            <p>Total: <span>RM{{ totalAmount.toFixed(2) }}</span></p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import { useCartStore } from '@/stores/cartStore';
import { useUserStore } from '@/stores/userStore';
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '@/api';

export default {
  name: 'Checkout',
  setup() {
    const cartStore = useCartStore();
    const userStore = useUserStore();
    const router = useRouter();

    // 計算購物車總金額
    const totalAmount = computed(() => {
      return cartStore.items.reduce((total, item) => {
        return total + item.price * item.quantity;
      }, 0);
    });

    // 格式化地址
    const formatAddress = (address) => {
      if (!address) return 'No address provided';

      const { address1, city, state, zip, country } = address;
      const addressParts = [address1, city, state, zip, country].filter(Boolean); // 過濾掉空值
      return addressParts.join(', ') || 'No address provided'; // 將非空字段用逗號連接
    };

    // 獲取用戶信息
    const fetchUserDetails = async () => {
      try {
        const response = await api.getUserDetails(); // 從後端獲取用戶信息
        userStore.setUser(response.data); // 將用戶信息存儲到 Pinia Store
      } catch (error) {
        console.error('Failed to fetch user details:', error);
      }
    };

    // 獲取地址信息
    const fetchAddress = async () => {
      try {
        const response = await api.getAddresses(); // 從後端獲取地址信息
        userStore.setAddress(response.data); // 將地址信息存儲到 Pinia Store
      } catch (error) {
        console.error('Failed to fetch addresses:', error);
      }
    };

    // 檢查用戶是否已登錄
    onMounted(async () => {
      if (!userStore.user) {
        router.push({ name: 'Login' }); // 如果未登錄，跳轉到登錄頁面
      } else {
        await fetchUserDetails(); // 獲取用戶信息
        await fetchAddress(); // 獲取地址信息
      }
    });

    // 獲取用戶信息
    const user = computed(() => {
      if (!userStore.user) {
        return {
          name: 'Guest',
          address: 'No address provided',
        };
      }
      return {
        name: `${userStore.user.first_name || ''} ${userStore.user.last_name || ''}`.trim() || 'Guest',
        address: formatAddress(userStore.address), // 從 userStore.address 中獲取地址信息
      };
    });

    // 前往 Addresses.vue
    const goToAddresses = () => {
      router.push({ name: 'Addresses' });
    };

    return {
      cartItems: computed(() => cartStore.items),
      totalAmount,
      user,
      goToAddresses,
    };
  },
  data() {
    return {
      paymentDetails: {
        cardNumber: '',
        expiryDate: '',
        cvv: '',
      },
    };
  },
  methods: {
    async submitPayment() {
        try {
            // 調用後端 API 創建訂單
            const response = await api.createOrder({
                paymentDetails: this.paymentDetails, // 傳遞付款信息
            });

            // 訂單創建成功後，清空購物車
            const cartStore = useCartStore();
            await cartStore.clearCart();

            // 提示用戶並跳轉到訂單頁面
            alert('Order created successfully!');
            this.$router.push({ name: 'Orders' });
        } catch (error) {
            console.error('Failed to create order:', error);
            alert(error.response?.data?.message || 'Failed to create order. Please try again.');
        }
    },
    // 前往購物車頁面
    goToCart() {
      this.$router.push({ name: 'Cart' });
    },
  },
};
</script>
  
  <style scoped>
  .checkout-page {
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
  
  .checkout-container {
    display: flex;
    gap: 30px;
  }
  
  .left-section {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 30px;
  }
  
  .shipping-info {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative; /* 讓 Edit 按鈕可以定位 */
  }
  
  .shipping-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .shipping-header h2 {
    font-size: 24px;
    color: #333;
    margin: 0; /* 移除默認的 margin */
  }
  
  .edit-address {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .edit-address:hover {
    background-color: #0056b3;
  }
  
  .info-group {
    margin-bottom: 15px;
  }
  
  .info-group label {
    font-weight: bold;
    color: #555;
  }
  
  .info-group p {
    margin: 5px 0;
    font-size: 16px;
    color: #333;
  }
  
  .payment-form {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .payment-form h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
  }
  
  .form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
  }
  
  .submit-payment {
    display: block;
    width: 100%;
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
  
  .submit-payment:hover {
    background-color: #218838;
  }
  
  .order-summary {
    flex: 1;
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .summary-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .summary-header h2 {
    font-size: 24px;
    color: #333;
  }
  
  .edit-cart {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .edit-cart:hover {
    background-color: #0056b3;
  }
  
  .checkout-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
  }
  
  .checkout-item-img {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
  }
  
  .checkout-item-details {
    flex: 1;
  }
  
  .checkout-item-name {
    font-size: 18px;
    font-weight: bold;
    color: #333;
  }
  
  .checkout-item-price {
    font-size: 16px;
    color: #666;
  }
  
  .checkout-item-quantity {
    font-size: 16px;
    color: #666;
  }
  
  .checkout-total {
    text-align: right;
    font-size: 20px;
    font-weight: bold;
    margin-top: 20px;
  }
  </style>