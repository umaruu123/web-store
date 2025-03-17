<template>
  <div class="animals-page">
    <h1>ANIMALS Collection</h1>
    <p>Explore our adorable animal plushies!</p>
    <div v-if="loading" class="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="product-list">
      <div v-for="product in products" :key="product.id" class="product-card" @click="viewProductDetails(product.id)">
        <img :src="product.image_url" :alt="product.name" class="product-image" />
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
        "http://127.0.0.1:8000/api/products/category/ANIMALS"
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
.animals-page {
  padding: 2rem;
  text-align: center;
  max-width: 100%; /* 接近全宽 */
  margin: 0 auto;
}

h1 {
  font-size: 2.5rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 1rem;
}

p {
  font-size: 1.2rem;
  color: #555;
  margin-bottom: 2rem;
}

.product-list {
  display: grid;
  grid-template-columns: repeat(4, 1fr); /* 每行 4 个产品 */
  gap: 20px;
  padding: 20px;
  max-width: 100%; /* 接近全宽 */
  margin: 0 auto;
}

.product-card {
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.product-image {
  width: 100%;
  height: 400px; /* 增大图片高度 */
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image {
  transform: scale(1.05); /* 悬停时图片放大 */
}

.product-name {
  font-size: 1.2rem;
  font-weight: bold;
  margin: 10px 0;
  color: #333;
}

.product-price {
  font-size: 1.1rem;
  color: #28a745;
  font-weight: bold;
  margin-bottom: 10px;
}

.loading,
.error {
  font-size: 1.2rem;
  color: #333;
  margin-top: 20px;
}

/* 响应式设计 */
@media (max-width: 1024px) {
  .product-list {
    grid-template-columns: repeat(3, 1fr); /* 每行 3 个产品 */
  }

  .product-image {
    height: 250px; /* 调整图片高度 */
  }
}

@media (max-width: 768px) {
  .product-list {
    grid-template-columns: repeat(2, 1fr); /* 每行 2 个产品 */
  }

  .product-image {
    height: 200px; /* 调整图片高度 */
  }
}

@media (max-width: 480px) {
  .product-list {
    grid-template-columns: 1fr; /* 每行 1 个产品 */
  }

  .product-image {
    height: 250px; /* 调整图片高度 */
  }
}
</style>