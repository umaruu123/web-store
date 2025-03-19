<template>
    <div class="order-details-container">
      <AccountNavigation title="Order Details" />
      <div v-if="loading">Loading...</div>
      <div v-else>
        <div v-if="order" class="order-details">
          <h2>Order #{{ order.id }}</h2>
          <div class="order-info">
            <p><strong>Date:</strong> {{ order.date }}</p>
            <p><strong>Total:</strong> ${{ order.total }}</p>
            <p><strong>Status:</strong> <span :class="['status', order.status.toLowerCase()]">{{ order.status }}</span></p>
          </div>
          <div class="order-items">
            <h3>Items</h3>
            <table>
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in order.items" :key="item.product_id">
                  <td>
                    <div class="product-info">
                      <img :src="item.product_image" :alt="item.product_name" class="product-image" />
                      <span class="product-name">{{ item.product_name }}</span>
                    </div>
                  </td>
                  <td>{{ item.quantity }}</td>
                  <td>${{ item.price }}</td>
                  <td>${{ (item.price * item.quantity).toFixed(2) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <button class="back-button" @click="goBack">Back to Orders</button>
        </div>
        <div v-else class="no-order">
          <p>Order not found.</p>
          <button class="back-button" @click="goBack">Back to Orders</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import api from '@/api';
  import AccountNavigation from '@/components/AccountNavigation.vue';
  
  export default {
    components: {
      AccountNavigation,
    },
    setup() {
      const route = useRoute();
      const router = useRouter();
      const order = ref(null);
      const loading = ref(true);
  
      const fetchOrderDetails = async () => {
        try {
          const orderId = route.params.id;
          const response = await api.getOrderDetails(orderId);
          order.value = {
            id: response.data.id,
            date: new Date(response.data.created_at).toLocaleDateString(),
            total: Number(response.data.total_amount).toFixed(2),
            status: response.data.status,
            items: response.data.items.map((item) => ({
              product_name: item.product_name,
              product_image: item.product_image, // 新增圖片 URL
              quantity: item.quantity,
              price: item.price,
            })),
          };
        } catch (error) {
          console.error('Failed to fetch order details:', error);
        } finally {
          loading.value = false;
        }
      };
  
      const goBack = () => {
        router.push({ name: 'Orders' });
      };
  
      onMounted(() => {
        fetchOrderDetails();
      });
  
      return {
        order,
        loading,
        goBack,
      };
    },
  };
  </script>
  
  <style scoped>
  .order-details-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .order-details {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .order-info p {
    margin: 10px 0;
    font-size: 16px;
  }
  
  .order-items {
    margin-top: 20px;
  }
  
  .order-items h3 {
    margin-bottom: 10px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }
  
  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  th {
    background-color: #f8f9fa;
  }
  
  .product-info {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  
  .product-image {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
  }
  
  .product-name {
    font-weight: bold;
  }
  
  .status {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
  }
  
  .status.pending {
    background-color: #ffc107;
    color: #333;
  }
  
  .status.completed {
    background-color: #28a745;
    color: white;
  }
  
  .status.cancelled {
    background-color: #dc3545;
    color: white;
  }
  
  .back-button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .back-button:hover {
    background-color: #0056b3;
  }
  
  .no-order {
    text-align: center;
    padding: 50px;
    font-size: 18px;
    color: #666;
  }
  </style>