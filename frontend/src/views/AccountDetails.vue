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
import { ref, onMounted } from 'vue';
import { useUserStore } from '@/stores/userStore';
import { useRouter } from 'vue-router';
import AccountNavigation from '@/components/AccountNavigation.vue';
import api from '@/api';

export default {
  components: {
    AccountNavigation,
  },
  setup() {
    const userStore = useUserStore();
    const router = useRouter();
    const editUser = ref({
      first_name: '',
      last_name: '',
      email: '',
      phone: '',
      currentPassword: '',
      newPassword: '',
      confirmNewPassword: '',
    });
    const loading = ref(true);
    const passwordError = ref('');
    const passwordMismatchError = ref('');

    // 從 Pinia Store 中獲取用戶信息
    const fetchUserDetails = async () => {
      try {
        if (userStore.user) {
          editUser.value = {
            first_name: userStore.user.first_name,
            last_name: userStore.user.last_name,
            email: userStore.user.email,
            phone: userStore.user.phone,
            currentPassword: '',
            newPassword: '',
            confirmNewPassword: '',
          };
        } else {
          const response = await api.getUserDetails();
          editUser.value = {
            first_name: response.data.first_name,
            last_name: response.data.last_name,
            email: response.data.email,
            phone: response.data.phone,
            currentPassword: '',
            newPassword: '',
            confirmNewPassword: '',
          };
        }
      } catch (error) {
        console.error('Failed to fetch user details:', error);
      } finally {
        loading.value = false;
      }
    };

    // 保存更改
    const saveChanges = async () => {
      if (editUser.value.newPassword !== editUser.value.confirmNewPassword) {
        passwordMismatchError.value = 'New password and confirm password do not match.';
        return;
      } else {
        passwordMismatchError.value = '';
      }

      if (editUser.value.newPassword && !isPasswordValid(editUser.value.newPassword)) {
        passwordError.value = 'Password must be at least 7 characters and contain both alphabetic and numeric characters.';
        return;
      } else {
        passwordError.value = '';
      }

      try {
        // 更新用戶信息
        await api.updateUserDetails({
          first_name: editUser.value.first_name,
          last_name: editUser.value.last_name,
          email: editUser.value.email,
          phone: editUser.value.phone,
        });

        // 更新 Pinia Store 中的用戶信息
        userStore.updateUser({
          first_name: editUser.value.first_name,
          last_name: editUser.value.last_name,
          email: editUser.value.email,
          phone: editUser.value.phone,
        });

        if (editUser.value.newPassword) {
          await api.changePassword({
            currentPassword: editUser.value.currentPassword,
            newPassword: editUser.value.newPassword,
          });
        }

        alert('Details updated successfully!');
        window.location.reload(); // 刷新頁面
      } catch (error) {
        console.error('Failed to update details:', error);
        alert('Failed to update details. Please try again.');
      }
    };

    // 檢查密碼是否符合要求
    const isPasswordValid = (password) => {
      const hasLetter = /[a-zA-Z]/.test(password);
      const hasNumber = /[0-9]/.test(password);
      return password.length >= 7 && hasLetter && hasNumber;
    };

    onMounted(() => {
      fetchUserDetails();
    });

    return {
      editUser,
      loading,
      passwordError,
      passwordMismatchError,
      saveChanges,
    };
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