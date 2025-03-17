<template>
  <div class="category-carousel">
    
    <div class="carousel-container">
      <div class="carousel-slide">
        <div
          v-for="(category, index) in categories"
          :key="index"
          class="category-card"
          :class="{ active: currentSlide === index }"
          @click="navigateToCategory(category.route)"
        >
          <div class="category-image-container">
            <img :src="category.image" :alt="category.name" class="category-image" />
            <h3 class="category-name">{{ category.name }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      categories: [
        {
          name: "ANIMALS",
          image: "/image/animal.avif", // 替换为你的图片路径
          route: "/animals",
        },
        {
          name: "BAGS & CHAIRS",
          image: "/image/bagcharms.jpg", // 替换为你的图片路径
          route: "/bags-chairs",
        },
        {
          name: "BABY & BOOKS",
          image: "/image/babybooks.jpg", // 替换为你的图片路径
          route: "/baby-books",
        },
      ],
      currentSlide: 0,
    };
  },
  methods: {
    // 导航到对应类别页面
    navigateToCategory(route) {
      this.$router.push(route);
    },
  },
};
</script>

<style scoped>
.category-carousel {
  padding: 60px 0; /* 上下 padding 保留，左右 padding 移除 */
  background-color: #f9f9f9;
  text-align: center;
  width: 100%; /* 全宽 */
}

.carousel-container {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%; /* 全宽 */
  overflow: hidden;
}

.carousel-slide {
  display: flex;
  gap: 20px;
  transition: transform 0.5s ease-in-out;
  width: 100%;
  padding: 0 20px; /* 添加左右 padding */
}

.category-card {
  flex: 0 0 calc(33.33% - 20px); /* 每行显示 3 个卡片 */
  background-color: white;
  border-radius: 16px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  position: relative;
}

.category-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.category-image-container {
  position: relative;
  width: 100%;
  height: 100%;
}

.category-image {
  width: 100%;
  height: 500px; /* 增大图片高度 */
  object-fit: cover;
  transition: transform 0.3s ease;
}

.category-card:hover .category-image {
  transform: scale(1.05); /* 悬停时图片放大 */
}

.category-name {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 1.5rem;
  font-weight: bold;
  color: white;
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8); /* 文字阴影 */
  text-align: center;
  width: 100%;
  padding: 0 20px;
}

/* 响应式设计 */
@media (max-width: 1024px) {
  .category-card {
    flex: 0 0 calc(50% - 20px); /* 每行显示 2 个卡片 */
  }

  .category-image {
    height: 250px; /* 调整图片高度 */
  }
}

@media (max-width: 768px) {
  .category-card {
    flex: 0 0 100%; /* 每行显示 1 个卡片 */
  }

  .category-image {
    height: 200px; /* 调整图片高度 */
  }
}
</style>