<template>
  <section class="parallax-container">
    <div class="parallax-wrapper">
      <!-- 第一張圖片：玩偶集合 -->
      <div class="parallax-image first" ref="firstImage">
        <div class="content">
          <h2>Adorable Plush Collection</h2>
          <p>Soft, huggable plushies for every moment.</p>
          <a href="#" class="icon-button">
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- 第二張圖片：棉花糖玩偶 -->
      <div class="parallax-image second" ref="secondImage">
        <div class="content">
          <h2>Marshmallow Soft Plush</h2>
          <p>Fluffy, cloud-like plush toys.</p>
          <a href="#" class="icon-button">
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'ParallaxSection',
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    handleScroll() {
      requestAnimationFrame(() => {
        const firstImage = this.$refs.firstImage;
        const secondImage = this.$refs.secondImage;
        const scrollY = window.scrollY;

        if (firstImage) {
          // 第一張圖片往上移動，速度較慢
          let offset = scrollY * -0.3;
          firstImage.style.transform = `translateY(${offset}px)`;
        }

        if (secondImage) {
          // 第二張圖片往上移動，速度較快
          let offset = scrollY * -0.6;
          secondImage.style.transform = `translateY(${offset}px)`;
        }
      });
    },
  },
};
</script>

<style scoped>
.parallax-container {
  position: relative;
  width: 100%;
  overflow: hidden;
}

.parallax-wrapper {
  position: relative;
  width: 100%;
}

.parallax-image {
  position: relative;
  width: 100%;
  height: 70vh; /* 限制高度為視口高度的 70% */
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: flex-end;
  justify-content: flex-start;
  padding: 40px;
  transition: transform 0.1s linear;
}

.first {
  background-image: url('C:/Users/perry/Downloads/road to web master/workspace/web-store/frontend/public/image/animal.webp');
  object-fit: cover; /* 讓圖片保持比例並填滿容器 */
}

.second {
  background-image: url('C:/Users/perry/Downloads/road to web master/workspace/web-store/frontend/public/image/Grace_Gentle0723-149.webp');
  object-fit: cover; /* 讓圖片保持比例並填滿容器 */
}

.content {
  background: none; /* 移除背景 */
  color: black; /* 文字顏色改為黑色 */
  padding: 20px;
  border-radius: 10px;
  max-width: 600px; /* 限制內容寬度 */
  text-shadow: 2px 2px 8px rgba(255, 255, 255, 0.8); /* 白色陰影確保文字清晰 */
}

h2 {
  font-size: 3rem; /* 更大的字體 */
  margin-bottom: 15px;
  font-weight: bold; /* 加粗字體 */
  line-height: 1.2; /* 更好的行高 */
}

p {
  font-size: 1.4rem; /* 更大的字體 */
  margin-bottom: 25px;
  line-height: 1.6; /* 更好的行高 */
}

.icon-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.8); /* 按鈕背景改為黑色 */
  border-radius: 50%;
  padding: 15px;
  text-decoration: none;
  color: white; /* 按鈕文字改為白色 */
  font-size: 24px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* 添加陰影 */
}

.icon-button:hover {
  background: rgba(0, 0, 0, 1); /* 懸停時背景加深 */
  transform: scale(1.1); /* 懸停時放大按鈕 */
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* 懸停時陰影加深 */
}

/* 響應式設計 */
@media (max-width: 768px) {
  .parallax-image {
    height: 50vh; /* 在小屏幕上減少高度 */
    padding: 20px; /* 減少內邊距 */
  }

  .content {
    padding: 15px;
    max-width: 90%;
  }

  h2 {
    font-size: 2rem; /* 更小的字體 */
  }

  p {
    font-size: 1rem; /* 更小的字體 */
  }

  .icon-button {
    padding: 12px;
    font-size: 20px;
  }
}
</style>