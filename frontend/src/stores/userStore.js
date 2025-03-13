import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null, // 存儲用戶信息
    address: null, // 存儲地址信息
  }),
  actions: {
    // 設置用戶信息
    setUser(user) {
      this.user = user;
    },
    // 設置地址信息
    setAddress(address) {
      this.address = address;
    },
    // 清除用戶信息
    clearUser() {
      this.user = null;
      this.address = null;
    },
  },
});