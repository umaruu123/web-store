import { createApp } from 'vue';
import { createPinia } from 'pinia'; // 導入 Pinia
import App from './App.vue';
import router from './router';

// 創建 Pinia 實例
const pinia = createPinia();

// 創建 Vue 應用並使用 Pinia 和 Router
const app = createApp(App);
app.use(pinia); // 使用 Pinia
app.use(router);
app.mount('#app');