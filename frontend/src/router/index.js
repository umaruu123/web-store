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
import AdminDashboard from '@/views/AdminDashboard.vue';
import AnimalsPage from "@/views/AnimalsPage.vue";
import BagsCharmsPage from "@/views/BagsCharmsPage.vue";
import BabyBooksPage from "@/views/BabyBooksPage.vue";
import OrderDetails from '@/views/OrderDetails.vue'; // 導入 OrderDetails 組件
import ExploreAllPage from '@/views/ExploreAllPage.vue';
import OurStory from '@/views/OurStory.vue';
import WhyUs from '@/views/WhyUs.vue';
import PressPR from '@/views/PressPR.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/our-story',
      name: 'OurStory',
      component: OurStory,
    },
    {
      path: '/why-us',
      name: 'WhyUs',
      component: WhyUs,
    },
    {
      path: '/press-pr',
      name: 'PressPR',
      component: PressPR,
    },
    {
      path: '/explore-all',
      name: 'ExploreAll',
      component: ExploreAllPage,
    },
    {
      path: "/animals",
      component: AnimalsPage,
    },
    {
      path: "/bags-charms",
      component: BagsCharmsPage,
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
      path: '/checkout',
      name: 'Checkout',
      component: () => import('@/views/Checkout.vue'),
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
      path: '/cart',
      name: 'Cart',
      component: () => import('@/views/Cart.vue'),
    },
    {
      path: '/product/:id',
      name: 'ProductDetails',
      component: () => import('../views/ProductDetails.vue'),
      meta: { requiresAuth: false }, // 不需要登錄
    },
    {
      path: '/orders/:id', // 動態路由，:id 是訂單 ID
      name: 'OrderDetails', // 路由名稱
      component: OrderDetails, // 對應的組件
      props: true, // 將路由參數作為 props 傳遞給組件
    },
    {
      path: '/admin',
      component: AdminDashboard,
      meta: { requiresAuth: true, hideHeader: true }, // 需要登錄
      children: [
        {
          path: 'users',
          component: () => import('@/views/AdminUsers.vue'),
        },
        {
          path: 'orders',
          name: 'AdminOrders', // 確保路由名稱是 'AdminOrders'
          component: () => import('@/views/AdminOrders.vue'),
        },
        {
          path: 'orders/:id',
          name: 'AdminOrderDetails',
          component: () => import('@/views/AdminOrderDetails.vue'),
        },
        {
          path: 'orders/:id/update-status',
          name: 'AdminUpdateOrderStatus',
          component: () => import('@/views/AdminUpdateOrderStatus.vue'),
        },
        {
          path: 'products',
          component: () => import('@/views/AdminProducts.vue'),
        },
      ],
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