<template>
  <div class="admin-orders">
    <h2>Order Management</h2>
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
            <span :class="`status-${order.status}`">{{ order.status }}</span>
          </td>
          <td>
            <button @click="viewOrder(order)">View</button>
            <button @click="updateOrderStatus(order)">Update Status</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import api from '@/api'; // 引入 API 方法

export default {
  data() {
    return {
      orders: [],
      loading: true,
      error: null,
    };
  },
  async created() {
    await this.fetchOrders();
  },
  methods: {
    async fetchOrders() {
      try {
        const response = await api.getOrders();
        this.orders = response.data;
      } catch (error) {
        this.error = 'Failed to fetch orders.';
        console.error('Error fetching orders:', error);
      } finally {
        this.loading = false;
      }
    },
    async updateOrderStatus(order) {
      const newStatus = prompt('Enter new status:', order.status);
      if (newStatus) {
        try {
          await api.updateOrderStatus(order.id, newStatus);
          order.status = newStatus;
          alert(`Order ${order.id} status updated to ${newStatus}`);
        } catch (error) {
          alert('Failed to update order status.');
          console.error('Error updating order status:', error);
        }
      }
    },
    viewOrder(order) {
      alert(`View order: ${order.id}`);
      // 這裡可以跳轉到訂單詳情頁面
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
    padding: 6px 12px;
    margin-right: 8px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  button:hover {
    opacity: 0.8;
  }
  
  .status-Pending {
    color: #ffc107;
  }
  
  status-Shipped {
    color: #007bff;
  }
  
  status-Delivered {
    color: #28a745;
  }
  </style>