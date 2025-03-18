import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '@/stores/userStore'; // 引入 Pinia Store
import HomeView from '../views/HomeView.vue';
import Login from '@/views/Login.vue';
import Register from '@/views/Register.vue';
import AccountCreated from '@/views/AccountCreated.vue';
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
      meta: { requiresAuth: false }, // 不需要登錄
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: { requiresAuth: false }, // 不需要登錄
    },
    {
      path: '/account-created',
      name: 'account-created',
      component: AccountCreated,
      meta: { requiresAuth: false }, // 不需要登錄
    },
    {
      path: '/account/details',
      name: 'AccountDetails',
      component: AccountDetails,
      meta: { requiresAuth: true }, // 需要登錄
    },
    {
      path: '/account/orders',
      name: 'Orders',
      component: Orders,
      meta: { requiresAuth: true }, // 需要登錄
    },
    {
      path: '/account/addresses',
      name: 'Addresses',
      component: Addresses,
      meta: { requiresAuth: true }, // 需要登錄
    },
    {
      path: '/account/wishlists',
      name: 'Wishlists',
      component: Wishlists,
      meta: { requiresAuth: true }, // 需要登錄
    },
    {
      path: '/account/recently-viewed',
      name: 'RecentlyViewed',
      component: RecentlyViewed,
      meta: { requiresAuth: true }, // 需要登錄
    },
    {
      path: '/admin',
      component: AdminDashboard,
      meta: { requiresAuth: true, hideHeader: true }, // 需要登錄
      children: [
        { path: 'users', component: AdminUsers },
        { path: 'orders', component: AdminOrders },
        { path: 'products', component: AdminProducts },
      ],
    },
    {
      path: '/product/:id',
      name: 'ProductDetails',
      component: () => import('../views/ProductDetails.vue'),
      meta: { requiresAuth: false }, // 不需要登錄
    },
  ],
});

// 全局路由守衛
router.beforeEach((to, from, next) => {
  const userStore = useUserStore();
  const isAuthenticated = !!userStore.user; // 檢查用戶是否已登錄

  if (to.meta.requiresAuth && !isAuthenticated) {
    // 如果路由需要登錄且用戶未登錄，則重定向到登錄頁面
    next({ name: 'login' });
  } else {
    next(); // 否則繼續導航
  }
});

export default router;