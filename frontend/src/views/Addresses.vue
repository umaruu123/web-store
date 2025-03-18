<template>
  <div class="addresses">
    <AccountNavigation title="Addresses" />
    <div v-if="loading" class="loading-spinner">
      <div class="spinner"></div>
      <p>Loading...</p>
    </div>
    <div v-else class="address-container">
      <!-- 顯示已有的地址信息 -->
      <div class="address-card">
        <h2 class="address-title">Your Address</h2>
        <div class="address-details">
          <p><strong>{{ address.first_name }} {{ address.last_name }}</strong></p>
          <p>{{ address.address1 }}</p>
          <p>{{ address.city }}, {{ address.state }}, {{ address.zip }}</p>
          <p>{{ address.country }}</p>
          <p>Phone: {{ address.phone }}</p>
        </div>
        <div class="address-actions">
          <button class="edit-button" @click="openEditForm">Edit Address</button>
        </div>
      </div>

      <!-- 編輯地址的表單 -->
      <div v-if="showEditForm" class="address-form-overlay" @click="closeForm">
        <div class="address-form" @click.stop>
          <h2 class="form-title">Edit Address</h2>
          <form @submit.prevent="updateAddress" class="form-container">
            <!-- First Name -->
            <div class="form-group">
              <label for="first-name">First Name</label>
              <input type="text" id="first-name" v-model="editAddress.first_name" required />
            </div>

            <!-- Last Name -->
            <div class="form-group">
              <label for="last-name">Last Name</label>
              <input type="text" id="last-name" v-model="editAddress.last_name" required />
            </div>

            <!-- Address Line 1 -->
            <div class="form-group">
              <label for="address-line-1">Address Line 1</label>
              <input type="text" id="address-line-1" v-model="editAddress.address1" required />
            </div>

            <!-- City -->
            <div class="form-group">
              <label for="city">Suburb/City</label>
              <input type="text" id="city" v-model="editAddress.city" required />
            </div>

            <!-- Country -->
            <div class="form-group">
              <label for="country">Country</label>
              <select id="country" v-model="editAddress.country" required>
                <option value="">Select Country</option>
                <option v-for="country in countries" :key="country" :value="country">
                  {{ country }}
                </option>
              </select>
            </div>

            <!-- State -->
            <div class="form-group">
              <label for="state">State/Province</label>
              <input type="text" id="state" v-model="editAddress.state" required />
            </div>

            <!-- Zip 和 Phone 並排 -->
            <div class="form-row">
              <div class="form-group">
                <label for="zip">Zip/Postcode</label>
                <input type="text" id="zip" v-model="editAddress.zip" required />
              </div>
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" v-model="editAddress.phone" required />
              </div>
            </div>

            <!-- 提交按鈕 -->
            <div class="form-actions">
              <button type="submit" class="submit-button" :disabled="isFormInvalid">Save Changes</button>
              <button type="button" class="cancel-button" @click="closeForm">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { useUserStore } from '@/stores/userStore';
import AccountNavigation from '@/components/AccountNavigation.vue';
import api from '@/api';

export default {
  components: {
    AccountNavigation,
  },
  setup() {
    const userStore = useUserStore();
    const address = ref({});
    const loading = ref(true);
    const showEditForm = ref(false);
    const editAddress = ref({
      first_name: '',
      last_name: '',
      address1: '',
      city: '',
      state: '',
      zip: '',
      country: '',
      phone: '',
    });

    const countries = [
      "United States", "Canada", "United Kingdom", "Australia", "Japan",
      "China", "Germany", "France", "Italy", "India", "Malaysia", "Singapore"
    ];

    // 檢查表單是否有效
    const isFormInvalid = computed(() => {
      return (
        !editAddress.value.first_name ||
        !editAddress.value.last_name ||
        !editAddress.value.address1 ||
        !editAddress.value.city ||
        !editAddress.value.state ||
        !editAddress.value.zip ||
        !editAddress.value.country ||
        !editAddress.value.phone
      );
    });

    // 從 Pinia Store 中獲取地址信息
    const fetchAddress = async () => {
      try {
        if (userStore.address) {
          address.value = userStore.address;
        } else {
          const response = await api.getAddresses();
          address.value = response.data;
          userStore.setAddress(response.data); // 將地址信息存儲到 Pinia Store
        }
      } catch (error) {
        console.error('Failed to fetch addresses:', error);
      } finally {
        loading.value = false;
      }
    };

    // 打開編輯表單
    const openEditForm = () => {
      editAddress.value = { ...address.value }; // 填充當前地址數據
      showEditForm.value = true; // 打開表單
    };

    // 關閉表單並重置數據
    const closeForm = () => {
      showEditForm.value = false; // 關閉表單
      editAddress.value = { // 重置表單數據
        first_name: '',
        last_name: '',
        address1: '',
        city: '',
        state: '',
        zip: '',
        country: '',
        phone: '',
      };
    };

    // 更新地址
    const updateAddress = async () => {
      try {
        await api.updateAddress(editAddress.value); // 更新地址
        userStore.updateAddress(editAddress.value); // 更新 Pinia Store
        fetchAddress(); // 重新獲取地址信息
        closeForm(); // 關閉表單並重置數據
        alert('Address updated successfully!');
        window.location.reload(); // 刷新頁面
      } catch (error) {
        console.error('Failed to update address:', error);
        alert('Failed to update address. Please try again.');
      }
    };

    onMounted(() => {
      fetchAddress();
    });

    return {
      address,
      loading,
      showEditForm,
      editAddress,
      countries,
      isFormInvalid,
      openEditForm,
      closeForm,
      updateAddress,
    };
  },
};
</script>

<style scoped>
.addresses {
  padding: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.loading-spinner {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 200px;
}

.spinner {
  border: 4px solid rgba(0, 0, 0, 0.1);
  border-left-color: #007bff;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.address-container {
  display: flex;
  justify-content: center;
}

.address-card {
  background-color: #ffffff;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  padding: 32px;
  max-width: 800px;
  width: 100%;
}

.address-title {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 24px;
  color: #333;
}

.address-details {
  font-size: 18px;
  color: #555;
  line-height: 1.8;
}

.address-actions {
  margin-top: 24px;
  display: flex;
  gap: 16px;
}

.edit-button {
  padding: 14px 28px;
  font-size: 18px;
  font-weight: bold;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  background-color: #007bff;
  color: white;
}

.edit-button:hover {
  background-color: #0056b3;
}

.address-form-overlay {
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

.address-form {
  background-color: white;
  padding: 40px;
  border-radius: 16px;
  width: 100%;
  max-width: 800px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.form-title {
  font-size: 28px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 32px;
  color: #333;
}

.form-container {
  display: flex;
  flex-wrap: wrap;
  gap: 24px;
}

.form-row {
  display: flex;
  gap: 24px;
  width: 100%;
}

.form-group {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.full-width {
  width: 100%;
}

label {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 12px;
  color: #555;
}

input, select {
  padding: 14px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 12px;
  transition: 0.3s;
}

input:focus, select:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}

.form-actions {
  width: 100%;
  display: flex;
  justify-content: flex-end;
  gap: 16px;
  margin-top: 24px;
}

.submit-button {
  padding: 14px 28px;
  font-size: 18px;
  font-weight: bold;
  color: white;
  background-color: #007bff;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.submit-button:hover:not(:disabled) {
  background-color: #0056b3;
}

.cancel-button {
  padding: 14px 28px;
  font-size: 18px;
  font-weight: bold;
  color: #007bff;
  background-color: #f0f0f0;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.cancel-button:hover {
  background-color: #e0e0e0;
}

@media (max-width: 768px) {
  .form-row {
    flex-direction: column;
    gap: 16px;
  }

  .address-card {
    padding: 24px;
  }

  .address-form {
    padding: 32px;
  }
}
</style>