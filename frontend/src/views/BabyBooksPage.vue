<template>
  <div class="baby-books-page">
    <h1>Baby & Books</h1>
    <div v-if="loading" class="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="product-list">
      <div
        v-for="product in products"
        :key="product.id"
        class="product-card"
        @click="viewProductDetails(product.id)"
      >
        <div class="product-image-container">
          <img :src="product.image_url" :alt="product.name" class="product-image" />
          <!-- 顯示庫存狀態 -->
          <div :class="['stock-status', product.stock > 0 ? 'in-stock' : 'out-of-stock']">
            {{ product.stock > 0 ? 'In Stock' : 'Out of Stock' }}
          </div>
        </div>
        <h3 class="product-name">{{ product.name }}</h3>
        <p class="product-price">RM{{ product.price.toFixed(2) }}</p>
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
      const response = await axios.get(
        "http://127.0.0.1:8000/api/products/category/BABY & BOOKS"
      );
      this.products = response.data.map((product) => ({
        ...product,
        price: Number(product.price),
      }));
    } catch (err) {
      this.error = "Failed to load products.";
      console.error(err);
    } finally {
      this.loading = false;
    }
  },
  methods: {
    viewProductDetails(productId) {
      this.$router.push({ name: 'ProductDetails', params: { id: productId } });
    }
  }
};
</script>

<style scoped>
.baby-books-page {
  padding: 100px 20px 20px; /* 添加 padding-top 避免被 Header 覆蓋 */
  max-width: 1200px;
  margin: 0 auto;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
  font-size: 32px;
  color: #333;
}

.product-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
  padding: 20px;
}

.product-card {
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative; /* 讓 stock-status 可以定位 */
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.product-image-container {
  overflow: hidden;
  border-radius: 12px 12px 0 0;
  position: relative; /* 讓 stock-status 可以定位 */
}

.product-image {
  width: 100%;
  height: 250px;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image {
  transform: scale(1.1);
}

.product-name {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin: 16px 0 8px;
}

.product-price {
  font-size: 16px;
  color: #28a745;
  font-weight: bold;
  margin-bottom: 16px;
}

.stock-status {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: bold;
  color: white;
  z-index: 1; /* 確保 stock-status 顯示在圖片上方 */
}

.stock-status.in-stock {
  background-color: #28a745; /* 綠色 */
}

.stock-status.out-of-stock {
  background-color: #dc3545; /* 紅色 */
}

.loading,
.error {
  font-size: 18px;
  color: #333;
  margin-top: 20px;
}
</style>