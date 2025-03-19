<template>
  <div class="admin-order-details">
    <h2 class="page-title">Order Details</h2>
    <div v-if="loading" class="loading-spinner">
      <div class="spinner"></div>
      <p>Loading order details...</p>
    </div>
    <div v-else>
      <div v-if="order" class="order-info">
        <div class="order-header">
          <p><strong>Order ID:</strong> {{ order.id }}</p>
          <p><strong>Customer:</strong> {{ order.customer }}</p>
          <p><strong>Date:</strong> {{ order.date }}</p>
          <p><strong>Total:</strong> ${{ order.total }}</p>
          <p><strong>Status:</strong> <span :class="`status status-${order.status.toLowerCase()}`">{{ order.status }}</span></p>
          <p><strong>Address:</strong> {{ order.address }}</p> <!-- 顯示地址信息 -->
        </div>

        <h3 class="items-title">Items</h3>
        <table class="items-table">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in order.items" :key="item.product_id">
              <td>{{ item.product_name }}</td>
              <td>{{ item.quantity }}</td>
              <td>${{ item.price }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="not-found">
        <p>Order not found.</p>
      </div>
    </div>
    <button @click="goBack" class="back-button">Back to Orders</button>
  </div>
</template>

<script>
import api from '@/api';

export default {
  data() {
    return {
      order: null,
      loading: true,
      error: null,
    };
  },
  async created() {
    const orderId = this.$route.params.id;
    await this.fetchOrderDetails(orderId);
  },
  methods: {
    async fetchOrderDetails(orderId) {
      try {
        const response = await api.getAdminOrderDetails(orderId);
        this.order = response.data;
      } catch (error) {
        this.error = 'Failed to fetch order details.';
        console.error('Error fetching order details:', error);
      } finally {
        this.loading = false;
      }
    },
    goBack() {
      this.$router.push({ name: 'AdminOrders' }); // 確保路由名稱是 'AdminOrders'
    },
  },
};
</script>

<style scoped>
.admin-order-details {
  padding: 20px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  max-width: 1000px;
  margin: 20px auto;
}

.page-title {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.loading-spinner {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 200px;
}

.spinner {
  border: 4px solid rgba(0, 0, 0, 0.1);
  border-left-color: #007bff;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.order-info {
  margin-top: 20px;
}

.order-header {
  background-color: #f8f9fa;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.order-header p {
  margin: 5px 0;
  font-size: 16px;
  color: #555;
}

.items-title {
  font-size: 20px;
  font-weight: bold;
  color: #333;
  margin-bottom: 15px;
}

.items-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #ffffff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
}

.items-table th,
.items-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.items-table th {
  background-color: #007bff;
  color: white;
  font-weight: bold;
}

.items-table tr:hover {
  background-color: #f1f1f1;
}

.status {
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: bold;
}

.status-pending {
  background-color: #ffc107;
  color: #333;
}

.status-shipped {
  background-color: #007bff;
  color: white;
}

.status-delivered {
  background-color: #28a745;
  color: white;
}

.status-cancelled {
  background-color: #dc3545;
  color: white;
}

.not-found {
  text-align: center;
  padding: 20px;
  font-size: 18px;
  color: #666;
}

.back-button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.back-button:hover {
  background-color: #0056b3;
}
</style>