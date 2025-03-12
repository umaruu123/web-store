<template>
    <div class="orders">
      <AccountNavigation title="Orders" />
      <div v-if="loading">Loading...</div>
      <div v-else>
        <table>
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Date</th>
              <th>Total</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders" :key="order.id">
              <td>{{ order.id }}</td>
              <td>{{ order.date }}</td>
              <td>${{ order.total }}</td>
              <td>{{ order.status }}</td>
              <td>
                <button @click="viewDetails(order.id)">View Details</button>
                <button v-if="order.status === 'Pending'" @click="cancelOrder(order.id)">Cancel</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import api from '@/api';
  import AccountNavigation from '@/components/AccountNavigation.vue'; // 引入導航組件
  
  export default {
    components: {
      AccountNavigation, // 註冊導航組件
    },
    setup() {
      const orders = ref([]);
      const loading = ref(true);
  
      const fetchOrders = async () => {
        try {
          const response = await api.getOrders();
          orders.value = response.data;
        } catch (error) {
          console.error('Failed to fetch orders:', error);
        } finally {
          loading.value = false;
        }
      };
  
      const viewDetails = (orderId) => {
        this.$router.push({ name: 'OrderDetails', params: { id: orderId } });
      };
  
      const cancelOrder = async (orderId) => {
        try {
          await api.cancelOrder(orderId);
          alert('Order cancelled successfully');
          fetchOrders();
        } catch (error) {
          console.error('Failed to cancel order:', error);
        }
      };
  
      onMounted(() => {
        fetchOrders();
      });
  
      return {
        orders,
        loading,
        viewDetails,
        cancelOrder,
      };
    },
  };
  </script>
  
  <style scoped>
  .orders {
    padding: 20px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
  }
  
  button {
    margin-right: 5px;
  }
  </style>