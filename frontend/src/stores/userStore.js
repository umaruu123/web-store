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
    // 更新用戶信息
    updateUser(updatedUser) {
      if (this.user) {
        this.user = { ...this.user, ...updatedUser }; // 合併更新用戶信息
      }
    },
    // 設置地址信息
    setAddress(address) {
      this.address = address;
    },
    // 更新地址信息
    updateAddress(updatedAddress) {
      if (this.address) {
        this.address = { ...this.address, ...updatedAddress }; // 合併更新地址信息
      }
    },
    // 清除用戶信息
    clearUser() {
      this.user = null;
      this.address = null;
    },
  },
});