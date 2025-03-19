<template>
    <div class="explore-all">
      <h1>Explore All Products</h1>
      <div v-if="loading" class="loading">Loading...</div>
      <div v-else-if="error" class="error">{{ error }}</div>
      <div v-else class="product-list">
        <div v-for="product in products" :key="product.id" class="product-item" @click="goToProduct(product.id)">
          <img :src="product.image_url" :alt="product.name" class="product-image" />
          <h3 class="product-name">{{ product.name }}</h3>
          <p class="product-price">RM{{ parseFloat(product.price).toFixed(2) }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        products: [],
        loading: true,
        error: null,
      };
    },
    async mounted() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/products');
        this.products = response.data;
      } catch (err) {
        this.error = 'Failed to load products.';
        console.error(err);
      } finally {
        this.loading = false;
      }
    },
    methods: {
      goToProduct(productId) {
        this.$router.push({ name: 'ProductDetails', params: { id: productId } });
      },
    },
  };
  </script>
  
  <style scoped>
  .explore-all {
    padding: 2rem;
    text-align: center;
  }
  
  .product-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    padding: 1rem;
  }
  
  .product-item {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 1rem;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .product-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
  }
  
  .product-name {
    font-size: 1.2rem;
    margin: 0.5rem 0;
  }
  
  .product-price {
    font-size: 1rem;
    color: #28a745;
    font-weight: bold;
  }
  
  .loading,
  .error {
    font-size: 1.2rem;
    color: #333;
    margin-top: 20px;
  }
  </style>