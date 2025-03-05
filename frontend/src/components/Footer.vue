<template>
  <footer class="footer">
    <div class="footer-container">
      <!-- 左側 Logo -->
      <div class="footer-brand">
        <a href="/" class="brand-link">
          <img src="/image/toyLogo.webp" alt="Logo" class="brand-logo" />
          <h1 class="brand-name">MochiPals</h1>
        </a>
      </div>

      <!-- Quick Links -->
      <div class="footer-section">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Explore All</a></li>
          <li><a href="#">Animals</a></li>
          <li><a href="#">Baby & Books</a></li>
          <li><a href="#">Bag Charm</a></li>
        </ul>
      </div>

      <!-- About -->
      <div class="footer-section">
        <h3>About</h3>
        <ul>
          <li><a href="#">Our Story</a></li>
          <li><a href="#">Why Us</a></li>
          <li><a href="#">Press & PR</a></li>
        </ul>
      </div>
    </div>
  </footer>
</template>

<style scoped>
/* 整體樣式 */
.footer {
  background-color: #e6f2ff; /* 淺藍色背景 */
  padding: 60px 0;
  border-top: 1px solid #ccc;
  font-family: Arial, sans-serif;
}

/* 容器 */
.footer-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

/* 左側 Logo */
.footer-brand {
  display: flex;
  align-items: center;
  flex: 1;
}

.brand-link {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: inherit;
  transition: opacity 0.3s ease;
}

.brand-link:hover {
  opacity: 0.8;
}

.brand-logo {
  width: 80px; /* 增大 Logo 大小 */
  height: 80px; /* 增大 Logo 大小 */
  margin-right: 20px; /* 调整 Logo 和文字之间的间距 */
}

.brand-name {
  font-size: 32px; /* 增大字体大小 */
  font-weight: bold;
  color: #333;
  margin: 0;
}

/* Quick Links & About */
.footer-section {
  flex: 1;
  text-align: left;
  margin-left: 40px; /* 增加左侧间距 */
}

.footer-section h3 {
  font-size: 20px; /* 增大标题字体大小 */
  font-weight: bold;
  margin-bottom: 16px; /* 增加标题和列表之间的间距 */
  color: #0056b3;
}

.footer-section ul {
  list-style: none;
  padding: 0;
}

.footer-section li {
  margin-bottom: 10px; /* 增加列表项之间的间距 */
}

.footer-section a {
  text-decoration: none;
  color: #333;
  font-size: 16px; /* 增大链接字体大小 */
  transition: color 0.3s ease;
}

.footer-section a:hover {
  color: #007bff;
}

/* 🎯 響應式設計（RWD） */
@media (max-width: 1024px) {
  .footer-container {
    flex-wrap: wrap;
    justify-content: center;
    text-align: center;
  }

  .footer-brand {
    width: 100%;
    justify-content: center;
    margin-bottom: 30px; /* 增加底部间距 */
  }

  .footer-section {
    width: 45%;
    text-align: center;
    margin-left: 0; /* 移除左侧间距 */
    margin-bottom: 30px; /* 增加底部间距 */
  }
}

@media (max-width: 768px) {
  .footer-container {
    flex-direction: column;
    text-align: center;
  }

  .footer-brand {
    justify-content: center;
    margin-bottom: 30px; /* 增加底部间距 */
  }

  .footer-section {
    width: 100%;
  }
}
</style>
