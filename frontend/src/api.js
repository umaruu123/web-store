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
  addToCart(itemId) {
    return api.post('/cart', { itemId });
  },
  addToWishlist(itemId) {
    return api.post('/wishlist', { itemId });
  },
  getUserDetails() {
    return api.get('/user/details'); // 假設後端有對應的 API 端點
  },
  updateUserDetails(data) {
    return api.put('/user/details', data); // 假設後端有對應的 API 端點
  },
  changePassword(data) {
    return api.post('/user/change-password', data); // 假設後端有對應的 API 端點
  },
  getAddresses() {
    return api.get('/addresses'); // 獲取地址信息
  },
  updateAddress(data) {
    return api.put('/user/update-address', data); // 調用新的地址更新 API
  },
};