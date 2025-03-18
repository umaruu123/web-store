<template>
  <div class="login-container">
    <div class="auth-box">
      <!-- 左側：登入 -->
      <div class="login-box">
        <h2>Welcome Back!</h2>
        <p>Sign in to explore exclusive deals and your favorite products.</p>
        <form @submit.prevent="loginUser">
          <input type="email" v-model="form.email" placeholder="Enter your email" required />
          <input type="password" v-model="form.password" placeholder="Enter your password" required />
          <button type="submit" class="login-button">Sign In</button>
        </form>
        <!-- 顯示錯誤訊息 -->
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
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
import axios from 'axios'; // 引入 axios
import { useUserStore } from '@/stores/userStore'; // 引入 Pinia Store
import { useCartStore } from '@/stores/cartStore'; // 引入購物車 Store

export default {
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      errorMessage: '', // 用於顯示錯誤訊息
    };
  },
  methods: {
    async loginUser() {
      try {
        // 發送登入請求到後端 API
        const response = await axios.post('http://127.0.0.1:8000/api/login', this.form);

        // 從響應中獲取 Token 和用戶信息
        const { token, user, role } = response.data;

        // 將 Token 存儲到 localStorage
        localStorage.setItem('authToken', token);
        localStorage.setItem('user', JSON.stringify(user));

        // 更新 Pinia Store 中的用戶信息
        const userStore = useUserStore();
        userStore.setUser(user);


        // 登錄後獲取購物車數據
        const cartStore = useCartStore();
        await cartStore.fetchCart(); // 從後端獲取購物車數據

        // 根據角色跳轉到不同頁面
        if (role === 'admin') {
          this.$router.push('/admin/users'); // 跳轉到 Admin Dashboard
        } else {
          this.$router.push('/'); // 跳轉到用戶首頁
        }
      } catch (error) {
        // 處理錯誤
        if (error.response) {
          // 後端返回的錯誤訊息
          this.errorMessage = error.response.data.message || 'Login failed. Please try again.';
        } else {
          this.errorMessage = 'Network error. Please check your connection.';
        }
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

.error-message {
  color: red;
  font-size: 14px;
  margin-top: 10px;
}
</style>