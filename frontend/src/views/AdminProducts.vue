<template>
  <div class="admin-products">
    <h2>Product Management</h2>
    <button class="add-product-button" @click="addProduct">Add Product</button>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>${{ product.price }}</td>
          <td>{{ product.stock }}</td>
          <td>
            <button @click="editProduct(product)">Edit</button>
            <button @click="deleteProduct(product)">Delete</button>
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
      products: [],
      loading: true,
      error: null,
    };
  },
  async created() {
    await this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await api.getProducts();
        this.products = response.data;
      } catch (error) {
        this.error = 'Failed to fetch products.';
        console.error('Error fetching products:', error);
      } finally {
        this.loading = false;
      }
    },
    async addProduct() {
      const name = prompt('Enter product name:');
      const price = parseFloat(prompt('Enter product price:'));
      const stock = parseInt(prompt('Enter product stock:'));
      if (name && price && stock) {
        try {
          const response = await api.addProduct({ name, price, stock });
          this.products.push(response.data);
          alert('Product added successfully!');
        } catch (error) {
          alert('Failed to add product.');
          console.error('Error adding product:', error);
        }
      }
    },
    async deleteProduct(product) {
      if (confirm(`Are you sure you want to delete ${product.name}?`)) {
        try {
          await api.deleteProduct(product.id);
          this.products = this.products.filter((p) => p.id !== product.id);
          alert('Product deleted successfully!');
        } catch (error) {
          alert('Failed to delete product.');
          console.error('Error deleting product:', error);
        }
      }
    },
    editProduct(product) {
      alert(`Edit product: ${product.name}`);
      // 這裡可以跳轉到編輯頁面
    },
  },
};
</script>
  
  <style scoped>
  .admin-products {
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .add-product-button {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
  }
  
  .add-product-button:hover {
    background-color: #218838;
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
  </style>