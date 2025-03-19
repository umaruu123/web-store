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

export default {
  getOrders() {
    return api.get('/orders');
  },
  getOrderDetails(orderId) {
    return api.get(`/orders/${orderId}`);
  },
  cancelOrder(orderId) {
    return api.delete(`/orders/${orderId}`);
  },
  // 添加創建訂單的方法
  createOrder(data) {
    return api.post('/orders', data);
  },
  cancelOrder(orderId) {
    return api.delete(`/orders/${orderId}`);
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
  getWishlist() {
    return api.get('/wishlist');
  },
  removeFromWishlist(itemId) {
    return api.delete(`/wishlist/${itemId}`);
  },
  addToCart(itemId) {
    return api.post('/cart', { itemId });
  },
  getRecentlyViewed() {
    return api.get('/recently-viewed');
  },
  addToWishlist(itemId) {
    return api.post('/wishlist', { itemId });
  },
  getUserDetails() {
    return api.get('/user/details');
  },
  updateUserDetails(data) {
    return api.put('/user/details', data);
  },
  changePassword(data) {
    return api.post('/user/change-password', data);
  },
  updateAddress(data) {
    return api.put('/user/update-address', data);
  },
  // 獲取所有用戶
  getUsers() {
    return api.get('/admin/users');
  },
  addUser(data) {
    return api.post('/admin/users', data); // 確保路徑和後端一致
  },
  // 刪除用戶
  deleteUser(userId) {
    return api.delete(`/admin/users/${userId}`);
  },
  updateUserByAdmin(userId, data) {
    return api.put(`/admin/users/${userId}`, data);
  },
  // 獲取所有產品
  getProducts() {
    return api.get('/admin/products');
  },
  // 獲取所有類別
  getCategories() {
    return api.get('/categories');
  },
  // 添加產品
  addProduct(data) {
    return api.post('/admin/products', data);
  },
  // 更新產品
  updateProduct(productId, data) {  
    return api.put(`/admin/products/${productId}`, data);
  },
  // 刪除產品
  deleteProduct(productId) {
    return api.delete(`/admin/products/${productId}`);
  },
  // 獲取所有訂單
  getAdminOrders() {
    return api.get('/admin/orders');
  },
  // 更新訂單狀態
  updateOrderStatus(orderId, status) {
    return api.put(`/admin/orders/${orderId}/status`, { status });
  },
  // 刪除類別
  deleteCategory(categoryId) {
    return api.delete(`/admin/categories/${categoryId}`);
  },
  addCategory(data) {
    return api.post('/admin/categories', data); // 確保路徑和後端一致
  },
  updateCategory(categoryId, data) {
    return api.put(`/admin/categories/${categoryId}`, data); // 確保路徑和後端一致
  },
};