<template>
  <div class="admin-products">
    <div class="header">
      <h2>Product Management</h2>
      <div class="header-buttons">
        <button class="add-product-button" @click="openAddForm">Add Product</button>
        <button class="add-category-button" @click="openAddCategoryForm">Add Category</button>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Category</th>
          <th>SKU</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>RM{{ typeof product.price === 'number' ? product.price.toFixed(2) : product.price }}</td>
          <td>{{ product.stock }}</td>
          <td>{{ product.category ? product.category.name : 'No Category' }}</td>
          <td>{{ product.sku }}</td>
          <td>{{ product.status }}</td>
          <td>
            <button @click="openEditForm(product)">Edit</button>
            <button @click="deleteProduct(product)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- 類別列表 -->
    <div class="category-list">
      <h3>Categories</h3>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id">
            <td>{{ category.id }}</td>
            <td>{{ category.name }}</td>
            <td>{{ category.slug }}</td>
            <td>{{ category.description }}</td>
            <td>
              <button @click="openEditCategoryForm(category)">Edit</button>
              <button @click="deleteCategory(category)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Edit Product Form -->
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
              step="0.01"
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

          <div class="form-group">
            <label for="edit-category">Category</label>
            <select
              id="edit-category"
              v-model="editProductData.category_id"
              :class="{ 'invalid': !editProductData.category_id && formSubmitted }"
            >
              <option value="">Select a category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
            <span v-if="!editProductData.category_id && formSubmitted" class="error-message">Category is required</span>
          </div>

          <div class="form-group">
            <label for="edit-sku">SKU</label>
            <input
              type="text"
              id="edit-sku"
              v-model="editProductData.sku"
              :class="{ 'invalid': !editProductData.sku && formSubmitted }"
              placeholder="Enter product SKU"
            />
            <span v-if="!editProductData.sku && formSubmitted" class="error-message">SKU is required</span>
          </div>

          <div class="form-group">
            <label for="edit-status">Status</label>
            <select
              id="edit-status"
              v-model="editProductData.status"
              :class="{ 'invalid': !editProductData.status && formSubmitted }"
            >
              <option value="">Select a status</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="out_of_stock">Out of Stock</option>
            </select>
            <span v-if="!editProductData.status && formSubmitted" class="error-message">Status is required</span>
          </div>

          <div class="form-group">
            <label for="edit-image">Image URL</label>
            <input
              type="url"
              id="edit-image"
              v-model="editProductData.image_url"
              placeholder="Enter image URL"
            />
          </div>

          <div class="form-group">
            <label for="edit-description">Description</label>
            <textarea
              id="edit-description"
              v-model="editProductData.description"
              placeholder="Enter product description"
            ></textarea>
          </div>

          <div class="form-actions">
            <button type="submit" class="submit-button">Save Changes</button>
            <button type="button" class="cancel-button" @click="closeForm">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Add Product Form -->
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
              step="0.01"
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

          <div class="form-group">
            <label for="add-category">Category</label>
            <select
              id="add-category"
              v-model="newProduct.category_id"
              :class="{ 'invalid': !newProduct.category_id && addFormSubmitted }"
            >
              <option value="">Select a category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
            <span v-if="!newProduct.category_id && addFormSubmitted" class="error-message">Category is required</span>
          </div>

          <div class="form-group">
            <label for="add-sku">SKU</label>
            <input
              type="text"
              id="add-sku"
              v-model="newProduct.sku"
              :class="{ 'invalid': !newProduct.sku && addFormSubmitted }"
              placeholder="Enter product SKU"
            />
            <span v-if="!newProduct.sku && addFormSubmitted" class="error-message">SKU is required</span>
          </div>

          <div class="form-group">
            <label for="add-status">Status</label>
            <select
              id="add-status"
              v-model="newProduct.status"
              :class="{ 'invalid': !newProduct.status && addFormSubmitted }"
            >
              <option value="">Select a status</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="out_of_stock">Out of Stock</option>
            </select>
            <span v-if="!newProduct.status && addFormSubmitted" class="error-message">Status is required</span>
          </div>

          <div class="form-group">
            <label for="add-image">Image URL</label>
            <input
              type="url"
              id="add-image"
              v-model="newProduct.image_url"
              placeholder="Enter image URL"
            />
          </div>

          <div class="form-group">
            <label for="add-description">Description</label>
            <textarea
              id="add-description"
              v-model="newProduct.description"
              placeholder="Enter product description"
            ></textarea>
          </div>

          <div class="form-actions">
            <button type="submit" class="submit-button">Add Product</button>
            <button type="button" class="cancel-button" @click="closeAddForm">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Add Category Form -->
    <div v-if="showAddCategoryForm" class="form-overlay" @click="closeAddCategoryForm">
      <div class="form-container" @click.stop>
        <h2 class="form-title">Add Category</h2>
        <form @submit.prevent="addCategory">
          <div class="form-group">
            <label for="add-category-name">Category Name</label>
            <input
              type="text"
              id="add-category-name"
              v-model="newCategory.name"
              placeholder="Enter category name"
            />
          </div>
          <div class="form-group">
            <label for="add-category-slug">Slug</label>
            <input
              type="text"
              id="add-category-slug"
              v-model="newCategory.slug"
              placeholder="Enter category slug"
            />
          </div>
          <div class="form-group">
            <label for="add-category-description">Description</label>
            <textarea
              id="add-category-description"
              v-model="newCategory.description"
              placeholder="Enter category description"
            ></textarea>
          </div>
          <div class="form-actions">
            <button type="submit" class="submit-button">Add Category</button>
            <button type="button" class="cancel-button" @click="closeAddCategoryForm">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- 編輯類別表單 -->
    <div v-if="showEditCategoryForm" class="form-overlay" @click="closeEditCategoryForm">
      <div class="form-container" @click.stop>
        <h2 class="form-title">Edit Category</h2>
        <form @submit.prevent="updateCategory">
          <div class="form-group">
            <label for="edit-category-name">Category Name</label>
            <input
              type="text"
              id="edit-category-name"
              v-model="editCategoryData.name"
              placeholder="Enter category name"
            />
          </div>
          <div class="form-group">
            <label for="edit-category-slug">Slug</label>
            <input
              type="text"
              id="edit-category-slug"
              v-model="editCategoryData.slug"
              placeholder="Enter category slug"
            />
          </div>
          <div class="form-group">
            <label for="edit-category-description">Description</label>
            <textarea
              id="edit-category-description"
              v-model="editCategoryData.description"
              placeholder="Enter category description"
            ></textarea>
          </div>
          <div class="form-actions">
            <button type="submit" class="submit-button">Save Changes</button>
            <button type="button" class="cancel-button" @click="closeEditCategoryForm">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/api'; // 導入 API 方法

export default {
  data() {
    return {
      products: [], // 產品列表
      categories: [], // 類別列表
      loading: true, // 加載狀態
      error: null, // 錯誤訊息
      showEditForm: false, // 控制編輯產品表單的顯示
      showAddForm: false, // 控制添加產品表單的顯示
      showAddCategoryForm: false, // 控制添加類別表單的顯示
      showEditCategoryForm: false, // 控制編輯類別表單的顯示
      formSubmitted: false, // 表單提交狀態
      addFormSubmitted: false, // 添加表單提交狀態
      editProductData: {
        id: null,
        name: '',
        price: '',
        stock: '',
        category_id: '',
        sku: '',
        status: '',
        image_url: '',
        description: '',
      },
      newProduct: {
        name: '',
        price: '',
        stock: '',
        category_id: '',
        sku: '',
        status: '',
        image_url: '',
        description: '',
      },
      newCategory: {
        name: '',
        slug: '',
        description: '',
      },
      editCategoryData: {
        id: null,
        name: '',
        slug: '',
        description: '',
      },
    };
  },
  async created() {
    await this.fetchProducts(); // 獲取產品資料
    await this.fetchCategories(); // 獲取類別資料
  },
  methods: {
    // 獲取產品列表
    async fetchProducts() {
      try {
        const response = await api.getProducts();
        this.products = response.data.map(product => ({
          ...product,
          price: parseFloat(product.price), // 將價格轉為數字
        }));
      } catch (error) {
        this.error = 'Failed to fetch products.';
        console.error('Error fetching products:', error);
      } finally {
        this.loading = false;
      }
    },

    // 獲取類別列表
    async fetchCategories() {
      try {
        const response = await api.getCategories();
        this.categories = response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },

    // 添加產品
    async addProduct() {
      this.addFormSubmitted = true;

      // 驗證所有必填字段
      if (
        !this.newProduct.name ||
        !this.newProduct.price ||
        !this.newProduct.stock ||
        !this.newProduct.category_id ||
        !this.newProduct.sku ||
        !this.newProduct.status
      ) {
        return;
      }

      try {
        await api.addProduct(this.newProduct);
        await this.fetchProducts(); // 重新獲取產品資料以確保一致性
        this.closeAddForm(); // 關閉表單
        alert('Product added successfully!');
      } catch (error) {
        alert('Failed to add product.');
        console.error('Error adding product:', error);
      }
    },

    // 添加類別
    async addCategory() {
      try {
        await api.addCategory(this.newCategory);
        await this.fetchCategories(); // 重新獲取類別資料以確保一致性
        this.closeAddCategoryForm(); // 關閉表單
        alert('Category added successfully!');
      } catch (error) {
        alert('Failed to add category.');
        console.error('Error adding category:', error);
      }
    },

    // 刪除產品
    async deleteProduct(product) {
      if (confirm(`Are you sure you want to delete ${product.name}?`)) {
        try {
          await api.deleteProduct(product.id);
          await this.fetchProducts(); // 重新獲取產品資料以確保一致性
          alert('Product deleted successfully!');
        } catch (error) {
          alert('Failed to delete product.');
          console.error('Error deleting product:', error);
        }
      }
    },

    // 刪除類別
    async deleteCategory(category) {
      if (confirm(`Are you sure you want to delete ${category.name}?`)) {
        try {
          await api.deleteCategory(category.id);
          await this.fetchCategories(); // 重新獲取類別資料以確保一致性
          alert('Category deleted successfully!');
        } catch (error) {
          alert('Failed to delete category.');
          console.error('Error deleting category:', error);
        }
      }
    },

    // 打開編輯產品表單
    openEditForm(product) {
      this.editProductData = { ...product }; // 填充當前產品數據
      this.showEditForm = true; // 打開編輯表單
    },

    // 關閉編輯產品表單
    closeForm() {
      this.showEditForm = false;
      this.formSubmitted = false;
      this.editProductData = {
        id: null,
        name: '',
        price: '',
        stock: '',
        category_id: '',
        sku: '',
        status: '',
        image_url: '',
        description: '',
      };
    },

    // 更新產品
    async updateProduct() {
      this.formSubmitted = true;

      // 驗證所有必填字段
      if (
        !this.editProductData.name ||
        !this.editProductData.price ||
        !this.editProductData.stock ||
        !this.editProductData.category_id ||
        !this.editProductData.sku ||
        !this.editProductData.status
      ) {
        return;
      }

      try {
        await api.updateProduct(this.editProductData.id, this.editProductData);
        await this.fetchProducts(); // 重新獲取產品資料以確保一致性
        this.closeForm(); // 關閉表單
        alert('Product updated successfully!');
      } catch (error) {
        alert('Failed to update product.');
        console.error('Error updating product:', error);
      }
    },

    // 打開添加產品表單
    openAddForm() {
      this.showAddForm = true;
    },

    // 關閉添加產品表單
    closeAddForm() {
      this.showAddForm = false;
      this.addFormSubmitted = false;
      this.newProduct = {
        name: '',
        price: '',
        stock: '',
        category_id: '',
        sku: '',
        status: '',
        image_url: '',
        description: '',
      };
    },

    // 打開添加類別表單
    openAddCategoryForm() {
      this.showAddCategoryForm = true;
    },

    // 關閉添加類別表單
    closeAddCategoryForm() {
      this.showAddCategoryForm = false;
      this.newCategory = {
        name: '',
        slug: '',
        description: '',
      };
    },

    // 打開編輯類別表單
    openEditCategoryForm(category) {
      this.editCategoryData = { ...category }; // 填充當前類別數據
      this.showEditCategoryForm = true; // 打開編輯表單
    },

    // 關閉編輯類別表單
    closeEditCategoryForm() {
      this.showEditCategoryForm = false;
      this.editCategoryData = {
        id: null,
        name: '',
        slug: '',
        description: '',
      };
    },

    // 更新類別
    async updateCategory() {
      try {
        await api.updateCategory(this.editCategoryData.id, this.editCategoryData);
        await this.fetchCategories(); // 重新獲取類別資料以確保一致性
        this.closeEditCategoryForm(); // 關閉表單
        alert('Category updated successfully!');
      } catch (error) {
        alert('Failed to update category.');
        console.error('Error updating category:', error);
      }
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

.header-buttons {
  display: flex;
  gap: 10px;
}

.add-product-button,
.add-category-button {
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

.add-product-button:hover,
.add-category-button:hover {
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
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.form-container {
  background-color: white;
  padding: 32px;
  border-radius: 12px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  animation: slideIn 0.3s ease;
}

@keyframes slideIn {
  from {
    transform: translateY(-20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
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

input,
select,
textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  background-color: #f9f9f9;
}

input:focus,
select:focus,
textarea:focus {
  border-color: #007bff;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
  outline: none;
  background-color: #fff;
}

input.invalid,
select.invalid,
textarea.invalid {
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