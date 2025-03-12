<template>
  <div class="account-details">
    <AccountNavigation title="Account Details" />
    <div v-if="loading">Loading...</div>
    <div v-else>
      <!-- 顯示用戶信息 -->
      <div class="user-info">
        <h2>User Information</h2>
        <p><strong>Name:</strong> {{ user.name }}</p>
        <p><strong>Email:</strong> {{ user.email }}</p>
        <p><strong>Phone:</strong> {{ user.phone }}</p>
      </div>

      <!-- 編輯用戶信息的表單 -->
      <div class="edit-form" v-if="isEditing">
        <h2>Edit Information</h2>
        <form @submit.prevent="saveChanges">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" v-model="editUser.name" />
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" v-model="editUser.email" />
          </div>
          <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" v-model="editUser.phone" />
          </div>
          <button type="submit">Save Changes</button>
          <button type="button" @click="cancelEdit">Cancel</button>
        </form>
      </div>

      <!-- 編輯按鈕 -->
      <button v-if="!isEditing" @click="startEdit">Edit Information</button>
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
      user: {
        name: '',
        email: '',
        phone: '',
      },
      editUser: {
        name: '',
        email: '',
        phone: '',
      },
      isEditing: false, // 是否正在編輯
      loading: true, // 是否正在加載數據
    };
  },
  methods: {
    // 獲取用戶信息
    async fetchUserDetails() {
      try {
        const response = await api.getUserDetails(); // 假設 API 中有 getUserDetails 方法
        this.user = response.data;
        this.loading = false;
      } catch (error) {
        console.error('Failed to fetch user details:', error);
        this.loading = false;
      }
    },
    // 開始編輯
    startEdit() {
      this.editUser = { ...this.user }; // 複製當前用戶信息到編輯表單
      this.isEditing = true;
    },
    // 取消編輯
    cancelEdit() {
      this.isEditing = false;
    },
    // 保存更改
    async saveChanges() {
      try {
        await api.updateUserDetails(this.editUser); // 假設 API 中有 updateUserDetails 方法
        this.user = { ...this.editUser }; // 更新用戶信息
        this.isEditing = false;
        alert('Information updated successfully!');
      } catch (error) {
        console.error('Failed to update user details:', error);
        alert('Failed to update information. Please try again.');
      }
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

.user-info {
  margin-bottom: 20px;
}

.edit-form {
  margin-top: 20px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input {
  padding: 8px;
  width: 100%;
  max-width: 300px;
  margin-bottom: 10px;
}

button {
  padding: 10px 20px;
  margin-right: 10px;
  cursor: pointer;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #0056b3;
}
</style>