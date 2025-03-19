<template>
  <div class="admin-update-order-status">
    <h2 class="page-title">Update Order Status</h2>
    <div v-if="loading" class="loading-spinner">
      <div class="spinner"></div>
      <p class="loading-text">Loading order details...</p>
    </div>
    <div v-else>
      <div v-if="order" class="order-details">
        <p class="order-info"><strong>Order ID:</strong> {{ order.id }}</p>
        <p class="order-info"><strong>Current Status:</strong> <span :class="`status-badge status-${order.status}`">{{ order.status }}</span></p>
        <div class="status-select">
          <label for="status" class="status-label">New Status:</label>
          <select v-model="newStatus" id="status" class="status-dropdown">
            <option value="pending">Pending</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
        <button @click="updateStatus" class="update-button">Update Status</button>
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
      newStatus: '',
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
        this.newStatus = this.order.status;
      } catch (error) {
        this.error = 'Failed to fetch order details.';
        console.error('Error fetching order details:', error);
      } finally {
        this.loading = false;
      }
    },
    async updateStatus() {
      if (confirm('Are you sure you want to update the status?')) {
        try {
          await api.updateOrderStatus(this.order.id, this.newStatus);
          alert('Order status updated successfully!');
          this.$router.push({ name: 'AdminOrders' });
        } catch (error) {
          alert('Failed to update order status.');
          console.error('Error updating order status:', error);
        }
      }
    },
    goBack() {
      console.log('Navigating to AdminOrders'); // 調試信息
      this.$router.push({ name: 'AdminOrders' });
    },
  },
};
</script>


<style scoped>
.admin-update-order-status {
  padding: 30px;
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  max-width: 500px;
  margin: 40px auto;
  font-family: 'Inter', sans-serif;
}

.page-title {
  font-size: 26px;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 25px;
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

.loading-text {
  margin-top: 15px;
  font-size: 16px;
  color: #666;
}

.order-details {
  background-color: #f9fafb;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.order-info {
  font-size: 16px;
  color: #444;
  margin-bottom: 15px;
}

.status-badge {
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 500;
  text-transform: capitalize;
}

.status-pending {
  background-color: #fff3cd;
  color: #856404;
}

.status-shipped {
  background-color: #d1ecf1;
  color: #0c5460;
}

.status-delivered {
  background-color: #d4edda;
  color: #155724;
}

.status-cancelled {
  background-color: #f8d7da;
  color: #721c24;
}

.status-select {
  margin-bottom: 20px;
}

.status-label {
  font-size: 16px;
  color: #444;
  margin-right: 10px;
}

.status-dropdown {
  padding: 8px 12px;
  border-radius: 6px;
  border: 1px solid #ddd;
  font-size: 14px;
  color: #444;
  background-color: #fff;
  width: 100%;
  max-width: 200px;
  transition: border-color 0.3s ease;
}

.status-dropdown:focus {
  border-color: #007bff;
  outline: none;
}

.update-button {
  margin-top: 10px;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.3s ease, transform 0.2s ease;
  width: 100%;
  max-width: 200px;
}

.update-button:hover {
  background-color: #0056b3;
  transform: translateY(-1px);
}

.back-button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #6c757d;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.3s ease, transform 0.2s ease;
  width: 100%;
  max-width: 200px;
}

.back-button:hover {
  background-color: #5a6268;
  transform: translateY(-1px);
}

.not-found {
  text-align: center;
  font-size: 16px;
  color: #dc3545;
  padding: 20px;
  background-color: #f8d7da;
  border-radius: 8px;
}
</style>