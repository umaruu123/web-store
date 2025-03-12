import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from '@/views/Login.vue'
import Register from '@/views/Register.vue'
import AccountCreated from '@/views/AccountCreated.vue' // 新增 AccountCreated.vue
import AccountDetails from '@/views/AccountDetails.vue';
import Orders from '@/views/Orders.vue';
import Addresses from '@/views/Addresses.vue';
import Wishlists from '@/views/Wishlists.vue';
import RecentlyViewed from '@/views/RecentlyViewed.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/account-created', // ➜ 新增註冊成功頁面路由
      name: 'account-created',
      component: AccountCreated,
    },
    {
      path: '/account/details', // 路徑可以根據需求調整
      name: 'AccountDetails', // 路由名稱
      component: AccountDetails,
    },
    {
      path: '/account/orders',
      name: 'Orders',
      component: Orders,
    },
    {
      path: '/account/addresses',
      name: 'Addresses',
      component: Addresses,
    },
    {
      path: '/account/wishlists',
      name: 'Wishlists',
      component: Wishlists,
    },
    {
      path: '/account/recently-viewed',
      name: 'RecentlyViewed',
      component: RecentlyViewed,
    },
  ],
})

export default router
