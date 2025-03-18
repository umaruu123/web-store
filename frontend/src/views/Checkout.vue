<template>
    <div class="checkout-page">
      <h1>Checkout</h1>
      <div class="checkout-container">
        <div class="checkout-summary">
          <h2>Order Summary</h2>
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
    </div>
  </template>
  
  <script>
  import { useCartStore } from '@/stores/cartStore';
  import { computed } from 'vue';
  
  export default {
    name: 'Checkout',
    setup() {
      const cartStore = useCartStore();
  
      // 計算購物車總金額
      const totalAmount = computed(() => {
        return cartStore.items.reduce((total, item) => {
          return total + item.price * item.quantity;
        }, 0);
      });
  
      return {
        cartItems: computed(() => cartStore.items),
        totalAmount,
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
      submitPayment() {
        alert('Payment submitted successfully!');
        // 這裡可以添加實際的付款邏輯
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
  
  .checkout-summary {
    flex: 1;
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
  
  .payment-form {
    flex: 1;
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
  </style>