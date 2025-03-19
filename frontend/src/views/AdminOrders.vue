<template>
  <div class="admin-orders">
    <h2>Order Management</h2>
    <div v-if="loading" class="loading-spinner">
      <div class="spinner"></div>
      <p>Loading orders...</p>
    </div>
    <div v-else>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id">
            <td>{{ order.id }}</td>
            <td>{{ order.customer }}</td>
            <td>{{ order.date }}</td>
            <td>${{ order.total }}</td>
            <td>
              <span :class="`status status-${order.status.toLowerCase()}`">{{ order.status }}</span>
            </td>
            <td>
              <button class="view-button" @click="viewOrder(order)">View</button>
              <button class="update-button" @click="updateOrderStatus(order)">Update Status</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import api from '@/api';
import { useRouter } from 'vue-router';

export default {
  data() {
    return {
      orders: [],
      loading: true,
      error: null,
    };
  },
  setup() {
    const router = useRouter();
    return { router };
  },
  async created() {
    await this.fetchOrders();
  },
  methods: {
    async fetchOrders() {
      try {
        const response = await api.getAdminOrders();
        console.log('API Response:', response.data);
        this.orders = response.data.map((order) => ({
          ...order,
          date: order.date ? new Date(order.date).toLocaleDateString() : 'N/A',
          total: order.total ? Number(order.total).toFixed(2) : '0.00',
        }));
      } catch (error) {
        this.error = 'Failed to fetch orders.';
        console.error('Error fetching orders:', error);
      } finally {
        this.loading = false;
      }
    },
    viewOrder(order) {
      this.router.push({ name: 'AdminOrderDetails', params: { id: order.id } }); // 跳轉到訂單詳情頁
    },
    updateOrderStatus(order) {
      this.router.push({ name: 'AdminUpdateOrderStatus', params: { id: order.id } }); // 跳轉到更新訂單狀態頁
    },
  },
};
</script>

<style scoped>
.admin-orders {
  padding: 20px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f8f9fa;
}

button {
  padding: 8px 16px;
  margin-right: 8px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

button:hover {
  opacity: 0.8;
}

.view-button {
  background-color: #007bff;
  color: white;
}

.update-button {
  background-color: #28a745;
  color: white;
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
</style>