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
  export default {
    data() {
      return {
        products: [
          { id: 1, name: 'Product A', price: 50, stock: 100 },
          { id: 2, name: 'Product B', price: 30, stock: 200 },
          { id: 3, name: 'Product C', price: 20, stock: 150 },
        ],
      };
    },
    methods: {
      addProduct() {
        const name = prompt('Enter product name:');
        const price = parseFloat(prompt('Enter product price:'));
        const stock = parseInt(prompt('Enter product stock:'));
        if (name && price && stock) {
          this.products.push({
            id: this.products.length + 1,
            name,
            price,
            stock,
          });
          alert('Product added successfully!');
        }
      },
      editProduct(product) {
        const name = prompt('Enter new name:', product.name);
        const price = parseFloat(prompt('Enter new price:', product.price));
        const stock = parseInt(prompt('Enter new stock:', product.stock));
        if (name && price && stock) {
          product.name = name;
          product.price = price;
          product.stock = stock;
          alert('Product updated successfully!');
        }
      },
      deleteProduct(product) {
        this.products = this.products.filter((p) => p.id !== product.id);
        alert('Product deleted successfully!');
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