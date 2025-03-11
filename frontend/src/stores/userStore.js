import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null, // 存儲用戶信息
  }),
  actions: {
    setUser(user) {
      this.user = user; // 更新用戶信息
    },
    clearUser() {
      this.user = null; // 清除用戶信息
    },
  },
});