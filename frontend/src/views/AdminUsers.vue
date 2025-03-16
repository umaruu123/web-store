<template>
  <div class="admin-users">
    <div class="header">
      <h2>User Management</h2>
      <button class="add-user-button" @click="openAddForm">Add User</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.first_name }} {{ user.last_name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.role }}</td>
          <td>
            <button @click="openEditForm(user)">Edit</button>
            <button @click="deleteUser(user)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- 編輯用戶的表單 -->
    <div v-if="showEditForm" class="form-overlay" @click="closeForm">
      <div class="form-container" @click.stop>
        <h2 class="form-title">Edit User</h2>
        <form @submit.prevent="updateUser">
          <div class="form-columns">
            <!-- 左列 -->
            <div class="form-column">
              <!-- First Name -->
              <div class="form-group">
                <label for="first-name">First Name</label>
                <input
                  type="text"
                  id="first-name"
                  v-model="editUser.first_name"
                  :class="{ 'invalid': !editUser.first_name && formSubmitted }"
                  placeholder="Enter first name"
                />
                <span v-if="!editUser.first_name && formSubmitted" class="error-message">First Name is required</span>
              </div>

              <!-- Last Name -->
              <div class="form-group">
                <label for="last-name">Last Name</label>
                <input
                  type="text"
                  id="last-name"
                  v-model="editUser.last_name"
                  :class="{ 'invalid': !editUser.last_name && formSubmitted }"
                  placeholder="Enter last name"
                />
                <span v-if="!editUser.last_name && formSubmitted" class="error-message">Last Name is required</span>
              </div>

              <!-- Email -->
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  id="email"
                  v-model="editUser.email"
                  :class="{ 'invalid': !editUser.email && formSubmitted }"
                  placeholder="Enter email"
                />
                <span v-if="!editUser.email && formSubmitted" class="error-message">Email is required</span>
              </div>

              <!-- Password -->
              <div class="form-group">
                <label for="edit-password">New Password (optional)</label>
                <input
                  type="password"
                  id="edit-password"
                  v-model="editUser.password"
                  placeholder="Enter new password"
                />
                <span v-if="editUser.password && !isPasswordValid(editUser.password)" class="error-message">
                  Password must be at least 7 characters and contain both letters and numbers.
                </span>
              </div>

              <!-- Confirm Password -->
              <div class="form-group">
                <label for="edit-confirm-password">Confirm Password</label>
                <input
                  type="password"
                  id="edit-confirm-password"
                  v-model="editUser.confirmPassword"
                  placeholder="Confirm new password"
                />
                <span v-if="editUser.password && editUser.confirmPassword && !isPasswordMatch(editUser.password, editUser.confirmPassword)" class="error-message">
                  Passwords do not match.
                </span>
              </div>

              <!-- Role -->
              <div class="form-group">
                <label for="role">Role</label>
                <select
                  id="role"
                  v-model="editUser.role"
                  :class="{ 'invalid': !editUser.role && formSubmitted }"
                >
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
                <span v-if="!editUser.role && formSubmitted" class="error-message">Role is required</span>
              </div>

              <!-- Zip -->
              <div class="form-group">
                <label for="zip">Zip</label>
                <input
                  type="text"
                  id="zip"
                  v-model="editUser.zip"
                  :class="{ 'invalid': !editUser.zip && formSubmitted }"
                  placeholder="Enter zip code"
                />
                <span v-if="!editUser.zip && formSubmitted" class="error-message">Zip is required</span>
              </div>
            </div>

            <!-- 右列 -->
            <div class="form-column">
              <!-- Phone -->
              <div class="form-group">
                <label for="phone">Phone</label>
                <input
                  type="text"
                  id="phone"
                  v-model="editUser.phone"
                  :class="{ 'invalid': !editUser.phone && formSubmitted }"
                  placeholder="Enter phone number"
                />
                <span v-if="!editUser.phone && formSubmitted" class="error-message">Phone is required</span>
              </div>

              <!-- Address Line 1 -->
              <div class="form-group">
                <label for="address1">Address Line 1</label>
                <input
                  type="text"
                  id="address1"
                  v-model="editUser.address1"
                  :class="{ 'invalid': !editUser.address1 && formSubmitted }"
                  placeholder="Enter address line 1"
                />
                <span v-if="!editUser.address1 && formSubmitted" class="error-message">Address is required</span>
              </div>

              <!-- City -->
              <div class="form-group">
                <label for="city">City</label>
                <input
                  type="text"
                  id="city"
                  v-model="editUser.city"
                  :class="{ 'invalid': !editUser.city && formSubmitted }"
                  placeholder="Enter city"
                />
                <span v-if="!editUser.city && formSubmitted" class="error-message">City is required</span>
              </div>

              <!-- State -->
              <div class="form-group">
                <label for="state">State</label>
                <input
                  type="text"
                  id="state"
                  v-model="editUser.state"
                  :class="{ 'invalid': !editUser.state && formSubmitted }"
                  placeholder="Enter state"
                />
                <span v-if="!editUser.state && formSubmitted" class="error-message">State is required</span>
              </div>

              <!-- Country -->
              <div class="form-group">
                <label for="country">Country</label>
                <select
                  id="country"
                  v-model="editUser.country"
                  :class="{ 'invalid': !editUser.country && formSubmitted }"
                >
                  <option value="">Select Country</option>
                  <option v-for="country in countries" :key="country" :value="country">
                    {{ country }}
                  </option>
                </select>
                <span v-if="!editUser.country && formSubmitted" class="error-message">Country is required</span>
              </div>
            </div>
          </div>

          <!-- 提交按鈕 -->
          <div class="form-actions">
            <button type="submit" class="submit-button">Save Changes</button>
            <button type="button" class="cancel-button" @click="closeForm">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- 新增用戶的表單 -->
    <div v-if="showAddForm" class="form-overlay" @click="closeAddForm">
      <div class="form-container" @click.stop>
        <h2 class="form-title">Add User</h2>
        <form @submit.prevent="addUser">
          <div class="form-columns">
            <!-- 左列 -->
            <div class="form-column">
              <!-- First Name -->
              <div class="form-group">
                <label for="add-first-name">First Name</label>
                <input
                  type="text"
                  id="add-first-name"
                  v-model="newUser.first_name"
                  :class="{ 'invalid': !newUser.first_name && addFormSubmitted }"
                  placeholder="Enter first name"
                />
                <span v-if="!newUser.first_name && addFormSubmitted" class="error-message">First Name is required</span>
              </div>

              <!-- Last Name -->
              <div class="form-group">
                <label for="add-last-name">Last Name</label>
                <input
                  type="text"
                  id="add-last-name"
                  v-model="newUser.last_name"
                  :class="{ 'invalid': !newUser.last_name && addFormSubmitted }"
                  placeholder="Enter last name"
                />
                <span v-if="!newUser.last_name && addFormSubmitted" class="error-message">Last Name is required</span>
              </div>

              <!-- Email -->
              <div class="form-group">
                <label for="add-email">Email</label>
                <input
                  type="email"
                  id="add-email"
                  v-model="newUser.email"
                  :class="{ 'invalid': (!newUser.email && addFormSubmitted) || emailExists }"
                  placeholder="Enter email"
                />
                <span v-if="!newUser.email && addFormSubmitted" class="error-message">Email is required</span>
                <span v-if="emailExists" class="error-message">Email already exists.</span>
              </div>

              <!-- Password -->
              <div class="form-group">
                <label for="add-password">Password</label>
                <input
                  type="password"
                  id="add-password"
                  v-model="newUser.password"
                  :class="{ 'invalid': !newUser.password && addFormSubmitted }"
                  placeholder="Enter password"
                />
                <span v-if="!newUser.password && addFormSubmitted" class="error-message">Password is required</span>
                <span v-if="newUser.password && !isPasswordValid(newUser.password)" class="error-message">
                  Password must be at least 7 characters and contain both letters and numbers.
                </span>
              </div>

              <!-- Confirm Password -->
              <div class="form-group">
                <label for="add-confirm-password">Confirm Password</label>
                <input
                  type="password"
                  id="add-confirm-password"
                  v-model="newUser.confirmPassword"
                  :class="{ 'invalid': !newUser.confirmPassword && addFormSubmitted }"
                  placeholder="Confirm password"
                />
                <span v-if="!newUser.confirmPassword && addFormSubmitted" class="error-message">Confirm Password is required</span>
                <span v-if="newUser.password && newUser.confirmPassword && !isPasswordMatch(newUser.password, newUser.confirmPassword)" class="error-message">
                  Passwords do not match.
                </span>
              </div>

              <!-- Role -->
              <div class="form-group">
                <label for="add-role">Role</label>
                <select
                  id="add-role"
                  v-model="newUser.role"
                  :class="{ 'invalid': !newUser.role && addFormSubmitted }"
                >
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
                <span v-if="!newUser.role && addFormSubmitted" class="error-message">Role is required</span>
              </div>

              <!-- Zip -->
              <div class="form-group">
                <label for="add-zip">Zip</label>
                <input
                  type="text"
                  id="add-zip"
                  v-model="newUser.zip"
                  :class="{ 'invalid': !newUser.zip && addFormSubmitted }"
                  placeholder="Enter zip code"
                />
                <span v-if="!newUser.zip && addFormSubmitted" class="error-message">Zip is required</span>
              </div>
            </div>

            <!-- 右列 -->
            <div class="form-column">
              <!-- Phone -->
              <div class="form-group">
                <label for="add-phone">Phone</label>
                <input
                  type="text"
                  id="add-phone"
                  v-model="newUser.phone"
                  :class="{ 'invalid': !newUser.phone && addFormSubmitted }"
                  placeholder="Enter phone number"
                />
                <span v-if="!newUser.phone && addFormSubmitted" class="error-message">Phone is required</span>
              </div>

              <!-- Address Line 1 -->
              <div class="form-group">
                <label for="add-address1">Address Line 1</label>
                <input
                  type="text"
                  id="add-address1"
                  v-model="newUser.address1"
                  :class="{ 'invalid': !newUser.address1 && addFormSubmitted }"
                  placeholder="Enter address line 1"
                />
                <span v-if="!newUser.address1 && addFormSubmitted" class="error-message">Address is required</span>
              </div>

              <!-- City -->
              <div class="form-group">
                <label for="add-city">City</label>
                <input
                  type="text"
                  id="add-city"
                  v-model="newUser.city"
                  :class="{ 'invalid': !newUser.city && addFormSubmitted }"
                  placeholder="Enter city"
                />
                <span v-if="!newUser.city && addFormSubmitted" class="error-message">City is required</span>
              </div>

              <!-- State -->
              <div class="form-group">
                <label for="add-state">State</label>
                <input
                  type="text"
                  id="add-state"
                  v-model="newUser.state"
                  :class="{ 'invalid': !newUser.state && addFormSubmitted }"
                  placeholder="Enter state"
                />
                <span v-if="!newUser.state && addFormSubmitted" class="error-message">State is required</span>
              </div>

              <!-- Country -->
              <div class="form-group">
                <label for="add-country">Country</label>
                <select
                  id="add-country"
                  v-model="newUser.country"
                  :class="{ 'invalid': !newUser.country && addFormSubmitted }"
                >
                  <option value="">Select Country</option>
                  <option v-for="country in countries" :key="country" :value="country">
                    {{ country }}
                  </option>
                </select>
                <span v-if="!newUser.country && addFormSubmitted" class="error-message">Country is required</span>
              </div>
            </div>
          </div>

          <!-- 提交按鈕 -->
          <div class="form-actions">
            <button type="submit" class="submit-button">Add User</button>
            <button type="button" class="cancel-button" @click="closeAddForm">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/api'; // 引入 API 方法

export default {
  data() {
    return {
      users: [],
      loading: true,
      error: null,
      showEditForm: false,
      showAddForm: false,
      formSubmitted: false, // 用於編輯表單驗證
      addFormSubmitted: false, // 用於新增表單驗證
      emailExists: false, // 用於檢查 Email 是否已存在
      editUser: {
        id: null,
        first_name: '',
        last_name: '',
        email: '',
        password: '', // 可選，用於修改密碼
        confirmPassword: '', // 確認密碼
        role: 'user',
        phone: '',
        address1: '',
        city: '',
        state: '',
        zip: '',
        country: '',
      },
      newUser: {
        first_name: '',
        last_name: '',
        email: '',
        password: '', // 新增密碼欄位
        confirmPassword: '', // 確認密碼
        role: 'user',
        phone: '',
        address1: '',
        city: '',
        state: '',
        zip: '',
        country: '',
      },
      countries: [
        'United States',
        'Canada',
        'United Kingdom',
        'Australia',
        'Japan',
        'China',
        'Germany',
        'France',
        'Italy',
        'India',
        'Malaysia',
        'Singapore',
      ],
    };
  },
  async created() {
    await this.fetchUsers(); // 組件創建時獲取用戶資料
  },
  methods: {
    // 獲取所有用戶
    async fetchUsers() {
      try {
        const response = await api.getUsers();
        this.users = response.data; // 更新本地用戶資料
      } catch (error) {
        this.error = 'Failed to fetch users.';
        console.error('Error fetching users:', error);
      } finally {
        this.loading = false;
      }
    },

    // 刪除用戶
    async deleteUser(user) {
      if (confirm(`Are you sure you want to delete ${user.first_name} ${user.last_name}?`)) {
        try {
          await api.deleteUser(user.id);
          await this.fetchUsers(); // 刪除後重新獲取用戶資料
          alert('User deleted successfully!');
        } catch (error) {
          alert('Failed to delete user.');
          console.error('Error deleting user:', error);
        }
      }
    },

    // 打開編輯用戶表單
    openEditForm(user) {
      this.editUser = { ...user }; // 填充當前用戶數據
      this.showEditForm = true; // 打開編輯表單
    },

    // 關閉編輯用戶表單
    closeForm() {
      this.showEditForm = false; // 關閉編輯表單
      this.formSubmitted = false; // 重置表單提交狀態
      this.editUser = { // 重置表單數據
        id: null,
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        confirmPassword: '',
        role: 'user',
        phone: '',
        address1: '',
        city: '',
        state: '',
        zip: '',
        country: '',
      };
    },

    // 更新用戶
    async updateUser() {
      this.formSubmitted = true; // 標記表單已提交

      // 檢查所有欄位是否已填寫
      if (
        !this.editUser.first_name ||
        !this.editUser.last_name ||
        !this.editUser.email ||
        !this.editUser.role ||
        !this.editUser.phone ||
        !this.editUser.address1 ||
        !this.editUser.city ||
        !this.editUser.state ||
        !this.editUser.zip ||
        !this.editUser.country
      ) {
        return; // 如果有欄位為空，停止提交
      }

      // 如果提供了新密碼，檢查是否符合規則
      if (this.editUser.password && !this.isPasswordValid(this.editUser.password)) {
        alert('Password must be at least 7 characters and contain both letters and numbers.');
        return;
      }

      // 檢查密碼和確認密碼是否匹配
      if (this.editUser.password && !this.isPasswordMatch(this.editUser.password, this.editUser.confirmPassword)) {
        alert('Passwords do not match.');
        return;
      }

      try {
        await api.updateUserByAdmin(this.editUser.id, this.editUser); // 更新用戶資料
        await this.fetchUsers(); // 更新後重新獲取用戶資料
        this.closeForm(); // 關閉表單
        alert('User updated successfully!');
      } catch (error) {
        alert('Failed to update user.');
        console.error('Error updating user:', error);
      }
    },

    // 打開新增用戶表單
    openAddForm() {
      this.showAddForm = true; // 打開新增表單
    },

    // 關閉新增用戶表單
    closeAddForm() {
      this.showAddForm = false; // 關閉新增表單
      this.addFormSubmitted = false; // 重置表單提交狀態
      this.emailExists = false; // 重置 Email 存在狀態
      this.newUser = { // 重置表單數據
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        confirmPassword: '',
        role: 'user',
        phone: '',
        address1: '',
        city: '',
        state: '',
        zip: '',
        country: '',
      };
    },

    // 新增用戶
    async addUser() {
      this.addFormSubmitted = true; // 標記表單已提交

      // 檢查所有欄位是否已填寫
      if (
        !this.newUser.first_name ||
        !this.newUser.last_name ||
        !this.newUser.email ||
        !this.newUser.password || // 檢查密碼
        !this.newUser.confirmPassword || // 檢查確認密碼
        !this.newUser.role ||
        !this.newUser.phone ||
        !this.newUser.address1 ||
        !this.newUser.city ||
        !this.newUser.state ||
        !this.newUser.zip ||
        !this.newUser.country
      ) {
        return; // 如果有欄位為空，停止提交
      }

      // 檢查密碼是否符合規則
      if (!this.isPasswordValid(this.newUser.password)) {
        alert('Password must be at least 7 characters and contain both letters and numbers.');
        return;
      }

      // 檢查密碼和確認密碼是否匹配
      if (!this.isPasswordMatch(this.newUser.password, this.newUser.confirmPassword)) {
        alert('Passwords do not match.');
        return;
      }

      // 檢查 Email 是否已存在
      if (this.users.some(user => user.email === this.newUser.email)) {
        this.emailExists = true;
        return;
      }

      try {
        await api.addUser(this.newUser); // 新增用戶
        await this.fetchUsers(); // 新增後重新獲取用戶資料
        this.closeAddForm(); // 關閉表單
        alert('User added successfully!');
      } catch (error) {
        alert('Failed to add user.');
        console.error('Error adding user:', error);
      }
    },

    // 驗證密碼是否符合規則
    isPasswordValid(password) {
      const minLength = 7;
      const hasLetter = /[a-zA-Z]/.test(password);
      const hasNumber = /\d/.test(password);
      return password.length >= minLength && hasLetter && hasNumber;
    },

    // 檢查密碼和確認密碼是否匹配
    isPasswordMatch(password, confirmPassword) {
      return password === confirmPassword;
    },
  },
};
</script>

<style scoped>
/* 全局樣式 */
.admin-users {
  padding: 24px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* 表頭樣式 */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.header h2 {
  font-size: 24px;
  font-weight: 600;
  color: #333;
}

/* 新增用戶按鈕 */
.add-user-button {
  padding: 10px 20px;
  background: linear-gradient(135deg, #28a745, #218838);
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 16px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.add-user-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* 表格樣式 */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

th, td {
  padding: 14px;
  text-align: left;
  border-bottom: 1px solid #e0e0e0;
}

th {
  background-color: #f8f9fa;
  font-weight: 600;
  color: #555;
}

tr:hover {
  background-color: #f5f5f5;
}

/* 按鈕樣式 */
button {
  padding: 8px 16px;
  margin-right: 8px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover {
  transform: translateY(-2px);
}

button:active {
  transform: translateY(0);
}

/* 表單遮罩層 */
.form-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

/* 表單容器 */
.form-container {
  background-color: white;
  padding: 32px;
  border-radius: 12px;
  width: 90%;
  max-width: 800px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

/* 表單標題 */
.form-title {
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 24px;
  color: #333;
}

/* 表單列佈局 */
.form-columns {
  display: flex;
  gap: 32px; /* 增加左右兩列之間的間距 */
}

/* 表單列 */
.form-column {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 16px; /* 增加輸入框之間的間距 */
}

/* 表單輸入組 */
.form-group {
  margin-bottom: 0; /* 移除默認的 margin-bottom */
}

/* 標籤樣式 */
label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #555;
}

/* 輸入框和下拉選單 */
input,
select {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  background-color: #f9f9f9;
}

/* 輸入框聚焦效果 */
input:focus,
select:focus {
  border-color: #007bff;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
  outline: none;
  background-color: #fff;
}

/* 錯誤輸入框樣式 */
input.invalid,
select.invalid {
  border-color: #ff4d4d;
}

/* 錯誤提示 */
.error-message {
  color: #ff4d4d;
  font-size: 14px;
  margin-top: 4px;
}

/* 表單操作按鈕 */
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 24px;
}

/* 提交按鈕 */
.submit-button {
  padding: 12px 24px;
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.submit-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* 取消按鈕 */
.cancel-button {
  padding: 12px 24px;
  background: #f0f0f0;
  color: #333;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.cancel-button:hover {
  background-color: #e0e0e0;
}
</style>