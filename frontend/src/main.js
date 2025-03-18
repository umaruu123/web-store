import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import { useUserStore } from '@/stores/userStore'; // 引入 Pinia Store

// 創建 Pinia 實例
const pinia = createPinia();

// 創建 Vue 應用並使用 Pinia 和 Router
const app = createApp(App);
app.use(pinia);
app.use(router);

// 恢復用戶狀態
const userStore = useUserStore();
const user = JSON.parse(localStorage.getItem('user'));
if (user) {
  userStore.setUser(user); // 恢復用戶信息
}

app.mount('#app');