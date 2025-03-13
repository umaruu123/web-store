<template>
  <div class="account-details">
    <AccountNavigation title="Account Details" />
    <div v-if="loading">Loading...</div>
    <div v-else>
      <!-- 編輯用戶信息的表單 -->
      <div class="edit-form">
        <form @submit.prevent="saveChanges">
          <div class="form-columns">
            <!-- 左列 -->
            <div class="form-column">
              <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" v-model="editUser.first_name" />
              </div>
              <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" v-model="editUser.last_name" />
              </div>
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="editUser.email" />
              </div>
              <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" v-model="editUser.phone" />
              </div>
            </div>

            <!-- 右列 -->
            <div class="form-column">
              <div class="form-group">
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" v-model="editUser.currentPassword" />
              </div>
              <div class="form-group">
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" v-model="editUser.newPassword" />
                <p class="password-hint">Passwords must be at least 7 characters and contain both alphabetic and numeric characters.</p>
                <p v-if="passwordError" class="password-error">{{ passwordError }}</p>
              </div>
              <div class="form-group">
                <label for="confirmNewPassword">Confirm New Password:</label>
                <input type="password" id="confirmNewPassword" v-model="editUser.confirmNewPassword" />
                <p v-if="passwordMismatchError" class="password-error">{{ passwordMismatchError }}</p>
              </div>
            </div>
          </div>

          <!-- 提交按鈕 -->
          <button type="submit">Update Details</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import AccountNavigation from '@/components/AccountNavigation.vue';
import api from '@/api'; // 引入 API 方法

export default {
  components: {
    AccountNavigation,
  },
  data() {
    return {
      editUser: {
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        currentPassword: '', // 當前密碼
        newPassword: '', // 新密碼
        confirmNewPassword: '', // 確認新密碼
      },
      loading: true, // 是否正在加載數據
      passwordError: '', // 密碼格式錯誤提示
      passwordMismatchError: '', // 密碼不匹配錯誤提示
    };
  },
  methods: {
    // 獲取用戶信息
    async fetchUserDetails() {
      try {
        const response = await api.getUserDetails(); // 假設 API 中有 getUserDetails 方法
        this.editUser = {
          first_name: response.data.first_name,
          last_name: response.data.last_name,
          email: response.data.email,
          phone: response.data.phone,
          currentPassword: '',
          newPassword: '',
          confirmNewPassword: '',
        };
        this.loading = false;
      } catch (error) {
        console.error('Failed to fetch user details:', error);
        this.loading = false;
      }
    },
    // 保存更改
    async saveChanges() {
      // 檢查密碼是否匹配
      if (this.editUser.newPassword !== this.editUser.confirmNewPassword) {
        this.passwordMismatchError = 'New password and confirm password do not match.';
        return;
      } else {
        this.passwordMismatchError = ''; // 清空錯誤提示
      }

      // 檢查新密碼是否符合要求
      if (this.editUser.newPassword && !this.isPasswordValid(this.editUser.newPassword)) {
        this.passwordError = 'Password must be at least 7 characters and contain both alphabetic and numeric characters.';
        return;
      } else {
        this.passwordError = ''; // 清空錯誤提示
      }

      try {
        // 更新用戶信息
        await api.updateUserDetails({
          first_name: this.editUser.first_name,
          last_name: this.editUser.last_name,
          email: this.editUser.email,
          phone: this.editUser.phone,
        });

        // 如果用戶輸入了新密碼，則更改密碼
        if (this.editUser.newPassword) {
          await api.changePassword({
            currentPassword: this.editUser.currentPassword,
            newPassword: this.editUser.newPassword,
          });
        }

        alert('Details updated successfully!');
      } catch (error) {
        console.error('Failed to update details:', error);
        alert('Failed to update details. Please try again.');
      }
    },
    // 檢查密碼是否符合要求
    isPasswordValid(password) {
      const hasLetter = /[a-zA-Z]/.test(password); // 檢查是否包含字母
      const hasNumber = /[0-9]/.test(password); // 檢查是否包含數字
      return password.length >= 7 && hasLetter && hasNumber;
    },
  },
  mounted() {
    this.fetchUserDetails(); // 組件加載時獲取用戶信息
  },
};
</script>

<style scoped>
.account-details {
  text-align: center;
  padding: 20px;
}

.edit-form {
  margin-top: 20px;
}

.form-columns {
  display: flex;
  justify-content: space-between;
  max-width: 800px;
  margin: 0 auto;
}

.form-column {
  flex: 1;
  padding: 0 20px; /* 增加列之間的間距 */
}

.form-group {
  margin-bottom: 20px; /* 增加表單組之間的間距 */
  text-align: left; /* 讓標籤和輸入框左對齊 */
}

label {
  display: block;
  margin-bottom: 8px; /* 標籤與輸入框之間的間距 */
  font-weight: bold; /* 讓標籤文字加粗 */
  font-size: 14px; /* 調整標籤文字大小 */
}

input {
  padding: 12px; /* 增加輸入框的內邊距 */
  width: 100%; /* 輸入框寬度填滿父容器 */
  max-width: 400px; /* 增加輸入框的最大寬度 */
  font-size: 14px; /* 調整輸入框文字大小 */
  border: 1px solid #ccc; /* 添加邊框 */
  border-radius: 5px; /* 圓角邊框 */
  box-sizing: border-box; /* 確保 padding 不會影響寬度 */
}

input:focus {
  border-color: #007bff; /* 聚焦時邊框顏色 */
  outline: none; /* 移除默認的聚焦外框 */
}

.password-hint {
  margin-top: 5px;
  font-size: 12px;
  color: #666;
}

.password-error {
  margin-top: 5px;
  font-size: 12px;
  color: red; /* 紅色錯誤提示 */
}

button {
  padding: 12px 24px;
  margin-top: 20px;
  cursor: pointer;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #0056b3;
}
</style>