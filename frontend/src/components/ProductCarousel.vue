<template>
  <div class="product-carousel">
    <div v-if="loading" class="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="carousel-container">
      <button class="carousel-button prev" @click="prevSlide">&#10094;</button>
      <div class="carousel-slide">
        <div
          v-for="(group, index) in groupedProducts"
          :key="index"
          class="slide-group"
          :class="{ active: currentSlide === index }"
        >
          <div
            v-for="product in group"
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
      <button class="carousel-button next" @click="nextSlide">&#10095;</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      products: [],
      featuredProducts: [], // 每個類別的隨機產品
      groupedProducts: [], // 分組後的產品
      loading: true,
      error: null,
      currentSlide: 0, // 當前顯示的幻燈片索引
    };
  },
  async mounted() {
    try {
      const response = await axios.get("http://127.0.0.1:8000/api/products");

      // 確保所有 price 變成數字
      this.products = response.data.map((product) => ({
        ...product,
        price: Number(product.price), // 轉換 price 為數字
      }));

      // 從每個類別中隨機選擇一個產品
      this.featuredProducts = this.getRandomProductsByCategory(this.products);

      // 將產品分組，每組 4 個
      this.groupedProducts = this.chunkArray(this.featuredProducts, 4);
    } catch (err) {
      this.error = "Failed to load products.";
      console.error(err);
    } finally {
      this.loading = false;
    }
  },
  methods: {
    // 從每個類別中隨機選擇一個產品
    getRandomProductsByCategory(products) {
      const categories = [...new Set(products.map((product) => product.category))]; // 獲取所有類別
      const randomProducts = [];

      categories.forEach((category) => {
        const productsInCategory = products.filter(
          (product) => product.category === category
        );
        const randomProduct =
          productsInCategory[Math.floor(Math.random() * productsInCategory.length)];
        randomProducts.push(randomProduct);
      });

      return randomProducts;
    },

    // 將數組分組
    chunkArray(array, size) {
      const result = [];
      for (let i = 0; i < array.length; i += size) {
        result.push(array.slice(i, i + size));
      }
      return result;
    },

    // 切換到上一張幻燈片
    prevSlide() {
      this.currentSlide =
        (this.currentSlide - 1 + this.groupedProducts.length) %
        this.groupedProducts.length;
    },

    // 切換到下一張幻燈片
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % this.groupedProducts.length;
    },

    // 查看商品詳細資料
    viewProductDetails(productId) {
      this.$router.push({ name: 'ProductDetails', params: { id: productId } });
    }
  },
};
</script>

<style scoped>
.product-carousel {
  padding: 40px 0; /* 移除左右 padding，實現全寬 */
  text-align: center;
  background-color: #f9f9f9;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.carousel-container {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  width: 100%; /* 全寬 */
  margin: 0 auto;
}

.carousel-slide {
  display: flex;
  transition: transform 0.5s ease-in-out;
  width: 100%;
}

.slide-group {
  display: grid;
  grid-template-columns: repeat(4, 1fr); /* 每行顯示 4 個產品 */
  gap: 20px; /* 卡片之間的間距 */
  width: 100%;
  opacity: 0;
  display: none;
}

.slide-group.active {
  opacity: 1;
  display: grid;
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
  height: 400px; /* 增加圖片高度 */
  object-fit: cover; /* 讓圖片佔滿容器 */
  transition: transform 0.3s ease;
}

.product-card:hover .product-image {
  transform: scale(1.1); /* 懸停時圖片放大 */
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

.carousel-button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(255, 255, 255, 0.9);
  color: #333;
  border: none;
  border-radius: 50%;
  padding: 16px;
  width: 50px;
  height: 50px;
  cursor: pointer;
  font-size: 24px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease, transform 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2; /* 按鈕層級高於卡片 */
}

.carousel-button:hover {
  background-color: rgba(255, 255, 255, 1);
  transform: translateY(-50%) scale(1.1);
}

.carousel-button.prev {
  left: 10px;
}

.carousel-button.next {
  right: 10px;
}

.loading,
.error {
  font-size: 18px;
  color: #333;
  margin-top: 20px;
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

@media (max-width: 1024px) {
  .slide-group {
    grid-template-columns: repeat(2, 1fr); /* 小螢幕每行顯示 2 個產品 */
  }

  .product-image {
    height: 250px; /* 調整圖片高度 */
  }
}

@media (max-width: 768px) {
  .slide-group {
    grid-template-columns: repeat(1, 1fr); /* 更小螢幕每行顯示 1 個產品 */
  }

  .product-image {
    height: 200px; /* 調整圖片高度 */
  }

  .carousel-button {
    padding: 12px;
    font-size: 20px;
    width: 40px;
    height: 40px;
  }

  .carousel-button.prev {
    left: 5px;
  }

  .carousel-button.next {
    right: 5px;
  }
}
</style>