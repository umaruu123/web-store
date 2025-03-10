<template>
    <div class="account-created-container">
      <h2>Your account has been created</h2>
      <p>Thank you for creating your account at MochiPals.</p>
      <p>Your account details have been emailed to <strong>{{ email }}</strong></p>
      <p>Please check your email to verify your account within 24 hours.</p>
      <router-link to="/login" class="login-link">Continue Shopping</router-link>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        email: this.$route.query.email || "your email",
      };
    },
  };
  </script>
  
  <style scoped>
  .account-created-container {
  text-align: center;
  max-width: 600px; /* 限制最大寬度，避免過寬 */
  margin: 0 auto; /* 讓內容置中 */
  padding: 150px 20px 50px; /* 增加 padding-top，讓內容不被 header 蓋住 */
}

h2 {
  font-size: 24px;
  color: #333;
  margin-bottom: 10px;
}

p {
  font-size: 16px;
  color: #555;
  margin-bottom: 10px;
}

.login-link {
  display: inline-block;
  margin-top: 20px;
  padding: 10px 20px;
  color: white;
  background: #007bff;
  text-decoration: none;
  border-radius: 5px;
  transition: background 0.3s;
}

.login-link:hover {
  background: #0056b3;
}

  </style>
  