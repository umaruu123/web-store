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
import AdminDashboard from '@/views/AdminDashboard.vue';
import AdminUsers from '@/views/AdminUsers.vue';
import AdminOrders from '@/views/AdminOrders.vue';
import AdminProducts from '@/views/AdminProducts.vue';
import AnimalsPage from "@/views/AnimalsPage.vue";
import BagsChairsPage from "@/views/BagsChairsPage.vue";
import BabyBooksPage from "@/views/BabyBooksPage.vue";

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
      path: "/animals",
      component: AnimalsPage,
    },
    {
      path: "/bags-chairs",
      component: BagsChairsPage,
    },
    {
      path: "/baby-books",
      component: BabyBooksPage,
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
    {
      path: '/admin',
      component: AdminDashboard,
      meta: { hideHeader: true }, // 添加元信息
      children: [
        { path: 'users', component: AdminUsers },
        { path: 'orders', component: AdminOrders },
        { path: 'products', component: AdminProducts },
      ],
    },
    
  ],
})

export default router
