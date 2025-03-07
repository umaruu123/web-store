<template>
    <div class="register-container">
      <div class="register-box">
        <h2 class="register-title">New Account</h2>
        <form @submit.prevent="registerUser" class="register-form">

          <!-- Email -->
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" v-model="form.email" />
            <p class="error-message" v-if="errors.email">{{ errors.email }}</p>
          </div>
  
          <!-- Password -->
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="form.password" />
            <small class="password-hint">
              Passwords must be at least 7 characters and contain both alphabetic and numeric characters.
            </small>
            <p class="error-message" v-if="errors.password">You must enter a password.</p>
          </div>
  
          <!-- Confirm Password -->
          <div class="form-group">
            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" v-model="form.confirmPassword" />
            <p class="error-message" v-if="errors.confirmPassword">Passwords do not match.</p>
          </div>
  
          <!-- Gender -->
          <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" v-model="form.gender">
              <option value="">Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
            <p class="error-message" v-if="errors.gender">Please select your gender.</p>
          </div>
  
          <!-- First Name -->
          <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" v-model="form.firstName" />
            <p class="error-message" v-if="errors.firstName">First name is required.</p>
          </div>
  
          <!-- Last Name -->
          <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" v-model="form.lastName" />
            <p class="error-message" v-if="errors.lastName">Last name is required.</p>
          </div>
  
          <!-- Address Line 1 -->
          <div class="form-group">
            <label for="address-line-1">Address Line 1</label>
            <input type="text" id="address-line-1" v-model="form.address1" />
            <p class="error-message" v-if="errors.address1">Address is required.</p>
          </div>
  
          <!-- Address Line 2 (Optional) -->
          <div class="form-group">
            <label for="address-line-2">Address Line 2 (Optional)</label>
            <input type="text" id="address-line-2" v-model="form.address2" />
          </div>
  
          <!-- City -->
          <div class="form-group">
            <label for="city">Suburb/City</label>
            <input type="text" id="city" v-model="form.city" />
            <p class="error-message" v-if="errors.city">City is required.</p>
          </div>
  
          <!-- Country -->
          <div class="form-group">
            <label for="country">Country</label>
            <select id="country" v-model="form.country">
                <option value="">Select Country</option>
                <option v-for="country in countries" :key="country" :value="country">
                {{ country }}
                </option>
            </select>
            <p class="error-message" v-if="errors.country">Country is required.</p>
            </div>
  
          <!-- State -->
          <div class="form-group">
            <label for="state">State/Province</label>
            <input type="text" id="state" v-model="form.state" />
            <p class="error-message" v-if="errors.state">State is required.</p>
          </div>
  
          <!-- Zip -->
          <div class="form-group">
            <label for="zip">Zip/Postcode</label>
            <input type="text" id="zip" v-model="form.zip" />
            <p class="error-message" v-if="errors.zip">Zip/Postcode is required.</p>
          </div>
  
          <!-- Phone -->
          <div class="form-group full-width">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" v-model="form.phone" />
            <p class="error-message" v-if="errors.phone">Phone number is required.</p>
          </div>
  
          <!-- Submit Button -->
          <button type="submit" class="register-button">Create Account</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
import axios from "axios";

export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
        confirmPassword: "",
        gender: "",
        firstName: "",
        lastName: "",
        address1: "",
        address2: "",
        city: "",
        country: "",
        state: "",
        zip: "",
        phone: "",
      },
      errors: {},
      countries: [
        "United States", "Canada", "United Kingdom", "Australia", "Japan",
        "China", "Germany", "France", "Italy", "India", "Malaysia", "Singapore"
      ],
    };
  },
  methods: {
    async registerUser() {
      this.validateForm(); // 先執行前端驗證
      if (Object.keys(this.errors).length > 0) return; // 如果有錯誤，不發送請求

      try {
        const response = await axios.post("http://127.0.0.1:8000/api/register", this.form, {
          headers: {
            "Content-Type": "application/json",
          },
        });

        alert(response.data.message); // 註冊成功訊息
        this.$router.push("/login"); // 註冊成功後跳轉到登入頁面
            } catch (error) {
            if (error.response && error.response.data.errors) {
            // Laravel 可能會返回多個錯誤，把它轉換成單純的錯誤訊息
            this.errors = Object.fromEntries(
                Object.entries(error.response.data.errors).map(([key, value]) => [key, value[0]])
            );
            } else {
            alert("Something went wrong. Please try again.");
            }
        }
    },
    validateForm() {
      this.errors = {};

      // Email 驗證
      if (!this.form.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
        this.errors.email = true;
      }

      // 密碼驗證
      if (!this.form.password || this.form.password.length < 7 || !/\d/.test(this.form.password) || !/[a-zA-Z]/.test(this.form.password)) {
        this.errors.password = true;
      }

      // 確認密碼
      if (this.form.password !== this.form.confirmPassword) {
        this.errors.confirmPassword = true;
      }

      // 其他必填欄位
      const requiredFields = ["gender", "firstName", "lastName", "address1", "city", "country", "state", "zip", "phone"];
      requiredFields.forEach((field) => {
        if (!this.form[field]) {
          this.errors[field] = true;
        }
      });
    }
  }
};
</script>

  
  <style scoped>
  /* 主容器 */
  .register-container {
    display: flex;
    justify-content: center;
    align-items: flex-start; /* 讓內容從上開始排列，而不是置中 */
    min-height: 100vh; /* 保持至少全屏高度，但允許超出 */
    background: #f8f9fa;
    padding-top: 150px; /* 確保不被 header 蓋住 */
    padding-bottom: 80px; /* 確保不壓到底部 */
    }
  
  /* 外層框架 */
  .register-box {
    width: 100%;
    max-width: 800px;
    background: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
  
  /* 標題 */
  .register-title {
    font-size: 26px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 25px;
    color: #333;
  }
  
  /* 表單 */
  .register-form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }
  
  /* 單獨的輸入框 */
  .form-group {
    width: calc(50% - 10px);
    display: flex;
    flex-direction: column;
  }
  
  /* 全寬輸入框 */
  .full-width {
    width: 100%;
  }
  
  /* 標籤 */
  label {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #555;
  }
  
  /* 輸入框 */
  input, select {
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    transition: 0.3s;
  }
  
  input:focus, select:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
  }
  
  /* 密碼提示 */
  .password-hint {
    font-size: 12px;
    color: #777;
    margin-top: 5px;
  }
  
  /* 註冊按鈕 */
  .register-button {
    width: 100%;
    padding: 14px;
    font-size: 18px;
    font-weight: bold;
    color: white;
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 20px;
  }
  
  .register-button:hover {
    background: linear-gradient(45deg, #0056b3, #003d82);
  }

  /* 新增錯誤訊息樣式 */
    .error-message {
    color: red;
    font-size: 14px;
    margin-top: 5px;
    }
  
  /* 響應式設計 */
  @media (max-width: 768px) {
    .form-group {
      width: 100%;
    }
  }
  </style>
  