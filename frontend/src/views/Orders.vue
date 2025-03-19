<template>
  <div class="orders-container">
    <AccountNavigation title="Orders" />
    <div v-if="loading" class="loading-spinner">
      <div class="spinner"></div>
      <p>Loading orders...</p>
    </div>
    <div v-else>
      <div v-if="orders.length === 0" class="no-orders">
        <p>You have no orders yet.</p>
        <router-link to="/" class="shop-now">Shop Now</router-link>
      </div>
      <div v-else>
        <table class="orders-table">
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
              <td>
                <span :class="['status', order.status.toLowerCase()]">
                  {{ order.status }}
                </span>
              </td>
              <td>
                <button class="view-details" @click="viewDetails(order.id)">
                  View Details
                </button>
                <button
                  v-if="order.status === 'pending'"
                  class="cancel-order"
                  @click="cancelOrder(order.id)"
                >
                  Cancel
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '@/api';
import AccountNavigation from '@/components/AccountNavigation.vue';

export default {
  components: {
    AccountNavigation,
  },
  setup() {
    const orders = ref([]);
    const loading = ref(true);
    const router = useRouter();

    const fetchOrders = async () => {
      try {
        const response = await api.getOrders();
        orders.value = response.data.map((order) => ({
          id: order.id,
          date: new Date(order.created_at).toLocaleDateString(),
          total: Number(order.total_amount).toFixed(2),
          status: order.status,
        }));
      } catch (error) {
        console.error('Failed to fetch orders:', error);
      } finally {
        loading.value = false;
      }
    };

    const viewDetails = (orderId) => {
      router.push({ name: 'OrderDetails', params: { id: orderId } });
    };

    const cancelOrder = async (orderId) => {
      try {
        await api.cancelOrder(orderId);
        alert('Order cancelled successfully');
        fetchOrders(); // 重新加載訂單列表
      } catch (error) {
        console.error('Failed to cancel order:', error);
        alert(error.response?.data?.message || 'Failed to cancel order. Please try again.');
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
.orders-container {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
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

.no-orders {
  text-align: center;
  padding: 50px;
  font-size: 18px;
  color: #666;
}

.shop-now {
  display: inline-block;
  margin-top: 10px;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.shop-now:hover {
  background-color: #0056b3;
}

.orders-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background-color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
}

.orders-table th,
.orders-table td {
  padding: 15px;
  text-align: left;
}

.orders-table th {
  background-color: #007bff;
  color: white;
  font-weight: bold;
}

.orders-table tr:nth-child(even) {
  background-color: #f8f9fa;
}

.orders-table tr:hover {
  background-color: #e9ecef;
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

.view-details,
.cancel-order {
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.view-details {
  background-color: #007bff;
  color: white;
  margin-right: 5px;
}

.view-details:hover {
  background-color: #0056b3;
}

.cancel-order {
  background-color: #dc3545;
  color: white;
}

.cancel-order:hover {
  background-color: #c82333;
}
</style>