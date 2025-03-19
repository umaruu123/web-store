import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
});

// 添加請求攔截器
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('authToken');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// 導出所有 API 方法
export default {
  // 用戶相關 API
  getUserDetails() {
    return api.get('/user/details');
  },
  updateUserDetails(data) {
    return api.put('/user/details', data);
  },
  changePassword(data) {
    return api.post('/user/change-password', data);
  },
  getAddresses() {
    return api.get('/addresses');
  },
  addAddress(data) {
    return api.post('/addresses', data);
  },
  deleteAddress(addressId) {
    return api.delete(`/addresses/${addressId}`);
  },
  updateAddress(data) {
    return api.put('/user/update-address', data);
  },

  // 購物車相關 API
  getCart() {
    return api.get('/cart');
  },
  addToCart(itemId) {
    return api.post('/cart/add', { itemId });
  },
  removeFromCart(productId) {
    return api.delete(`/cart/remove/${productId}`);
  },
  clearCart() {
    return api.delete('/cart/clear');
  },

  // 用戶訂單相關 API
  getOrders() {
    return api.get('/orders');
  },
  getOrderDetails(orderId) {
    return api.get(`/orders/${orderId}`);
  },
  createOrder(data) {
    return api.post('/orders', data);
  },
  cancelOrder(orderId) {
    return api.delete(`/orders/${orderId}`);
  },

  // 管理員相關 API
  // 用戶管理
  getUsers() {
    return api.get('/admin/users');
  },
  addUser(data) {
    return api.post('/admin/users', data);
  },
  updateUserByAdmin(userId, data) {
    return api.put(`/admin/users/${userId}`, data);
  },
  deleteUser(userId) {
    return api.delete(`/admin/users/${userId}`);
  },

  // 產品管理
  getProducts() {
    return api.get('/admin/products');
  },
  addProduct(data) {
    return api.post('/admin/products', data);
  },
  updateProduct(productId, data) {
    return api.put(`/admin/products/${productId}`, data);
  },
  deleteProduct(productId) {
    return api.delete(`/admin/products/${productId}`);
  },

  // 類別管理
  getCategories() {
    return api.get('/categories');
  },
  addCategory(data) {
    return api.post('/admin/categories', data);
  },
  updateCategory(categoryId, data) {
    return api.put(`/admin/categories/${categoryId}`, data);
  },
  deleteCategory(categoryId) {
    return api.delete(`/admin/categories/${categoryId}`);
  },

  // 訂單管理
  getAdminOrders() {
    return api.get('/admin/orders');
  },
  getAdminOrderDetails(orderId) {
    return api.get(`/admin/orders/${orderId}`);
  },
  updateOrderStatus(orderId, status) {
    return api.put(`/admin/orders/${orderId}/status`, { status });
  },

  // 其他 API
  getWishlist() {
    return api.get('/wishlist');
  },
  addToWishlist(itemId) {
    return api.post('/wishlist', { itemId });
  },
  removeFromWishlist(itemId) {
    return api.delete(`/wishlist/${itemId}`);
  },
  getRecentlyViewed() {
    return api.get('/recently-viewed');
  },
  getProductDetails(productId) {
    return api.get(`/products/${productId}/details`);
  },
};