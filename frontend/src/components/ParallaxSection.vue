<template>
  <section class="parallax-container">
    <div class="parallax-wrapper">
      <!-- 第一張圖片 -->
      <div class="parallax-image first" ref="firstImage">
        <div class="content">
          <h2>Adorable Plush Collection</h2>
          <p>Soft, huggable plushies for every moment.</p>
          <a href="#" class="icon-button">
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- 第二張圖片 -->
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
  name: "ParallaxSection",
  mounted() {
    window.addEventListener("scroll", this.handleScroll);
  },
  beforeUnmount() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    handleScroll() {
      requestAnimationFrame(() => {
        const firstImage = this.$refs.firstImage;
        const secondImage = this.$refs.secondImage;
        const scrollY = window.scrollY;

        if (firstImage) {
          let offset = scrollY * -0.3;
          firstImage.style.transform = `translateY(${offset}px)`;
        }

        if (secondImage) {
          let offset = scrollY * -0.6;
          secondImage.style.transform = `translateY(${offset}px)`;
        }
      });
    },
  },
};
</script>

<style scoped>
/* Parallax 容器 */
.parallax-container {
  position: relative;
  width: 100%;
  overflow: hidden;
}

.parallax-wrapper {
  position: relative;
  width: 100%;
}

/* Parallax 圖片 */
.parallax-image {
  position: relative;
  width: 100%;
  height: 70vh; /* 視口 70% */
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: flex-end;
  justify-content: flex-start;
  padding: 40px;
  transition: transform 0.1s linear;
}

.first {
  background-image: url('/image/animal.webp');
}

.second {
  background-image: url('/image/Grace_Gentle0723-149.webp');
}

/* 內容區 */
.content {
  color: black;
  padding: 20px;
  border-radius: 10px;
  max-width: 600px;
  text-shadow: 2px 2px 8px rgba(255, 255, 255, 0.8);
}

h2 {
  font-size: clamp(2rem, 5vw, 3rem); /* 自適應大小 */
  margin-bottom: 15px;
  font-weight: bold;
  line-height: 1.2;
}

p {
  font-size: clamp(1rem, 3vw, 1.4rem);
  margin-bottom: 25px;
  line-height: 1.6;
}

.icon-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.8);
  border-radius: 50%;
  padding: 15px;
  text-decoration: none;
  color: white;
  font-size: 24px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.icon-button:hover {
  background: rgba(0, 0, 0, 1);
  transform: scale(1.1);
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
}

/* 🎯 響應式設計 */
@media (max-width: 1024px) {
  .parallax-image {
    height: 60vh;
    padding: 30px;
  }

  .content {
    max-width: 80%;
  }
}

@media (max-width: 768px) {
  .parallax-image {
    height: 50vh;
    padding: 20px;
  }

  .content {
    text-align: center;
    padding: 15px;
    max-width: 90%;
  }

  h2 {
    font-size: clamp(1.5rem, 4vw, 2rem);
  }

  p {
    font-size: clamp(0.9rem, 2.5vw, 1rem);
  }

  .icon-button {
    padding: 12px;
    font-size: 20px;
  }
}
</style>
