<template>
  <div class="login-container">
    <div class="auth-box">
      <!-- 左側：登入 -->
      <div class="login-box">
        <h2>Welcome Back!</h2>
        <p>Sign in to explore exclusive deals and your favorite products.</p>
        <!-- 驗證成功的消息 -->
        <div v-if="isVerified" class="verification-success">
          Your account has been successfully verified! Please log in.
        </div>
        <form @submit.prevent="loginUser">
          <input type="email" v-model="form.email" placeholder="Enter your email" required />
          <input type="password" v-model="form.password" placeholder="Enter your password" required />
          <button type="submit" class="login-button">Sign In</button>
        </form>
        <a href="#" class="forgot-password">Forgot your password?</a>
      </div>

      <!-- 右側：註冊 -->
      <div class="register-box">
        <h2>New to MochiPals?</h2>
        <p>Join us today and enjoy special member-only offers!</p>
        <router-link to="/register" class="register-button">Create Your Account</router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isVerified: false, // 是否顯示驗證成功的消息
      form: {
        email: '',
        password: '',
      },
    };
  },
  created() {
    // 檢查 URL 參數 `verified`
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('verified') === '1') {
      this.isVerified = true;
    }
  },
  methods: {
    async loginUser() {
      try {
        // 這裡可以添加登入邏輯，例如調用 API
        console.log('Logging in with:', this.form);
        // 登入成功後重定向到首頁或其他頁面
        this.$router.push('/');
      } catch (error) {
        console.error('Login failed:', error);
      }
    },
  },
};
</script>

<style scoped>
/* 🌟 主容器 */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: #f8f9fa; /* 柔和背景 */
  padding: 20px;
}

/* 🏠 外層框架 */
.auth-box {
  display: flex;
  width: 100%;
  max-width: 1300px; /* 讓框架更寬 */
  background: #ffffff;
  border-radius: 20px; /* 增加圓角 */
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); /* 更柔和的陰影 */
  overflow: hidden;
}

/* 📌 登入 & 註冊區塊 */
.login-box,
.register-box {
  flex: 1;
  min-height: 550px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 60px;
}

/* 🟦 登入區塊 */
.login-box {
  background: #ffffff;
}

/* 🟩 註冊區塊 */
.register-box {
  background: #f5f5f5; /* 更柔和的灰色 */
}

/* 🏷️ 標題 */
h2 {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 10px;
}

/* 📖 副標題 */
p {
  font-size: 17px;
  color: #666;
  margin-bottom: 25px;
}

/* 📝 輸入框 */
input {
  width: 100%;
  max-width: 420px;
  padding: 14px;
  margin: 12px 0;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-size: 16px;
  transition: 0.3s;
}

input:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}

/* 🔵 登入按鈕 */
.login-button {
  width: 100%;
  max-width: 420px;
  padding: 14px;
  background: linear-gradient(45deg, #007bff, #0056b3); /* 漸變藍色 */
  color: white;
  font-size: 17px;
  font-weight: bold;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  transition: 0.3s;
}

.login-button:hover {
  background: linear-gradient(45deg, #0056b3, #003d82);
}

/* 🔵 註冊按鈕 */
.register-button {
  text-decoration: none; /* 移除底線 */
  display: inline-block; /* 讓按鈕樣式生效 */
  text-align: center;
  width: 100%;
  max-width: 420px;
  padding: 14px;
  background: linear-gradient(45deg, #92c6e0, #68a5c4); /* 淺藍漸變 */
  font-size: 17px;
  font-weight: bold;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  transition: 0.3s;
  color: black; /* 確保文字顏色 */
}

.register-button:hover {
  background: linear-gradient(45deg, #68a5c4, #4a8bae);
}

/* 🔗 忘記密碼 */
.forgot-password {
  margin-top: 12px;
  font-size: 15px;
  color: #007bff;
  text-decoration: none;
}

.forgot-password:hover {
  text-decoration: underline;
}

/* 📱 響應式設計 */
@media (max-width: 900px) {
  .auth-box {
    flex-direction: column;
    width: 100%;
    max-width: 500px;
  }
}

/* 新增驗證成功的消息樣式 */
.verification-success {
  background-color: #d4edda; /* 淺綠色背景 */
  color: #155724; /* 深綠色文字 */
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
  text-align: center;
}
</style>