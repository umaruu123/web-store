import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
  },
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
};