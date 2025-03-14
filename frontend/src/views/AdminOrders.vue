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
  export default {
    data() {
      return {
        orders: [
          { id: 1, customer: 'John Doe', date: '2023-10-01', total: 120, status: 'Shipped' },
          { id: 2, customer: 'Jane Smith', date: '2023-10-02', total: 200, status: 'Pending' },
          { id: 3, customer: 'Alice Johnson', date: '2023-10-03', total: 80, status: 'Delivered' },
        ],
      };
    },
    methods: {
      viewOrder(order) {
        alert(`View order: ${order.id}`);
      },
      updateOrderStatus(order) {
        const newStatus = prompt('Enter new status:', order.status);
        if (newStatus) {
          order.status = newStatus;
          alert(`Order ${order.id} status updated to ${newStatus}`);
        }
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