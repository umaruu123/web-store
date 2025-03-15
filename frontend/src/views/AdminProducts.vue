<template>
  <div class="admin-products">
    <div class="header">
      <h2>Product Management</h2>
      <button class="add-product-button" @click="openAddForm">Add Product</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>${{ product.price }}</td>
          <td>{{ product.stock }}</td>
          <td>
            <button @click="openEditForm(product)">Edit</button>
            <button @click="deleteProduct(product)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- 編輯產品表單 -->
    <div v-if="showEditForm" class="form-overlay" @click="closeForm">
      <div class="form-container" @click.stop>
        <h2 class="form-title">Edit Product</h2>
        <form @submit.prevent="updateProduct">
          <div class="form-group">
            <label for="edit-name">Name</label>
            <input
              type="text"
              id="edit-name"
              v-model="editProductData.name"
              :class="{ 'invalid': !editProductData.name && formSubmitted }"
              placeholder="Enter product name"
            />
            <span v-if="!editProductData.name && formSubmitted" class="error-message">Name is required</span>
          </div>

          <div class="form-group">
            <label for="edit-price">Price</label>
            <input
              type="number"
              id="edit-price"
              v-model="editProductData.price"
              :class="{ 'invalid': !editProductData.price && formSubmitted }"
              placeholder="Enter product price"
            />
            <span v-if="!editProductData.price && formSubmitted" class="error-message">Price is required</span>
          </div>

          <div class="form-group">
            <label for="edit-stock">Stock</label>
            <input
              type="number"
              id="edit-stock"
              v-model="editProductData.stock"
              :class="{ 'invalid': !editProductData.stock && formSubmitted }"
              placeholder="Enter product stock"
            />
            <span v-if="!editProductData.stock && formSubmitted" class="error-message">Stock is required</span>
          </div>

          <div class="form-actions">
            <button type="submit" class="submit-button">Save Changes</button>
            <button type="button" class="cancel-button" @click="closeForm">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- 新增產品表單 -->
    <div v-if="showAddForm" class="form-overlay" @click="closeAddForm">
      <div class="form-container" @click.stop>
        <h2 class="form-title">Add Product</h2>
        <form @submit.prevent="addProduct">
          <div class="form-group">
            <label for="add-name">Name</label>
            <input
              type="text"
              id="add-name"
              v-model="newProduct.name"
              :class="{ 'invalid': !newProduct.name && addFormSubmitted }"
              placeholder="Enter product name"
            />
            <span v-if="!newProduct.name && addFormSubmitted" class="error-message">Name is required</span>
          </div>

          <div class="form-group">
            <label for="add-price">Price</label>
            <input
              type="number"
              id="add-price"
              v-model="newProduct.price"
              :class="{ 'invalid': !newProduct.price && addFormSubmitted }"
              placeholder="Enter product price"
            />
            <span v-if="!newProduct.price && addFormSubmitted" class="error-message">Price is required</span>
          </div>

          <div class="form-group">
            <label for="add-stock">Stock</label>
            <input
              type="number"
              id="add-stock"
              v-model="newProduct.stock"
              :class="{ 'invalid': !newProduct.stock && addFormSubmitted }"
              placeholder="Enter product stock"
            />
            <span v-if="!newProduct.stock && addFormSubmitted" class="error-message">Stock is required</span>
          </div>

          <div class="form-actions">
            <button type="submit" class="submit-button">Add Product</button>
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
      products: [],
      loading: true,
      error: null,
      showEditForm: false,
      showAddForm: false,
      formSubmitted: false, // 用於編輯表單驗證
      addFormSubmitted: false, // 用於新增表單驗證
      editProductData: {
        id: null,
        name: '',
        price: '',
        stock: '',
      },
      newProduct: {
        name: '',
        price: '',
        stock: '',
      },
    };
  },
  async created() {
    await this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await api.getProducts();
        this.products = response.data;
      } catch (error) {
        this.error = 'Failed to fetch products.';
        console.error('Error fetching products:', error);
      } finally {
        this.loading = false;
      }
    },
    async addProduct() {
      this.addFormSubmitted = true; // 標記表單已提交

      // 檢查所有欄位是否已填寫
      if (!this.newProduct.name || !this.newProduct.price || !this.newProduct.stock) {
        return; // 如果有欄位為空，停止提交
      }

      try {
        const response = await api.addProduct(this.newProduct);
        this.products.push(response.data);
        this.closeAddForm(); // 關閉表單
        alert('Product added successfully!');
      } catch (error) {
        alert('Failed to add product.');
        console.error('Error adding product:', error);
      }
    },
    async deleteProduct(product) {
      if (confirm(`Are you sure you want to delete ${product.name}?`)) {
        try {
          await api.deleteProduct(product.id);
          this.products = this.products.filter((p) => p.id !== product.id);
          alert('Product deleted successfully!');
        } catch (error) {
          alert('Failed to delete product.');
          console.error('Error deleting product:', error);
        }
      }
    },
    openEditForm(product) {
      this.editProductData = { ...product }; // 填充當前產品數據
      this.showEditForm = true; // 打開編輯表單
    },
    closeForm() {
      this.showEditForm = false; // 關閉編輯表單
      this.formSubmitted = false; // 重置表單提交狀態
      this.editProductData = { // 重置表單數據
        id: null,
        name: '',
        price: '',
        stock: '',
      };
    },
    async updateProduct() {
      this.formSubmitted = true; // 標記表單已提交

      // 檢查所有欄位是否已填寫
      if (!this.editProductData.name || !this.editProductData.price || !this.editProductData.stock) {
        return; // 如果有欄位為空，停止提交
      }

      try {
        await api.updateProduct(this.editProductData.id, this.editProductData);
        this.fetchProducts(); // 重新獲取產品列表
        this.closeForm(); // 關閉表單
        alert('Product updated successfully!');
      } catch (error) {
        alert('Failed to update product.');
        console.error('Error updating product:', error);
      }
    },
    openAddForm() {
      this.showAddForm = true; // 打開新增表單
    },
    closeAddForm() {
      this.showAddForm = false; // 關閉新增表單
      this.addFormSubmitted = false; // 重置表單提交狀態
      this.newProduct = { // 重置表單數據
        name: '',
        price: '',
        stock: '',
      };
    },
  },
};
</script>

<style scoped>
.admin-products {
  padding: 24px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

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

.add-product-button {
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

.add-product-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

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

.form-container {
  background-color: white;
  padding: 32px;
  border-radius: 12px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.form-title {
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 24px;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #555;
}

input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  background-color: #f9f9f9;
}

input:focus {
  border-color: #007bff;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
  outline: none;
  background-color: #fff;
}

input.invalid {
  border-color: #ff4d4d;
}

.error-message {
  color: #ff4d4d;
  font-size: 14px;
  margin-top: 4px;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 24px;
}

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
