<template>
  <div class="product-list">
    <h2>Products</h2>
    <div v-if="loading">Loading...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else>
      <div v-for="product in products" :key="product.id" class="product-card">
        <img :src="product.image" :alt="product.name" class="product-image" />
        <h3>{{ product.name }}</h3>
        <p>${{ product.price.toFixed(2) }}</p> <!-- 確保 price 是數字 -->
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

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
      const response = await axios.get("http://127.0.0.1:8000/api/products");
      
      // 確保所有 price 變成數字
      this.products = response.data.map(product => ({
        ...product,
        price: Number(product.price) // 轉換 price 為數字
      }));

      console.log(this.products); // 確認轉換成功
    } catch (err) {
      this.error = "Failed to load products.";
      console.error(err);
    } finally {
      this.loading = false;
    }
  },
};
</script>

<style scoped>
.product-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}
.product-card {
  width: 200px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 8px;
  text-align: center;
}
.product-image {
  width: 100%;
  height: auto;
  border-radius: 5px;
}
</style>
