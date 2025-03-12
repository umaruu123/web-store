<template>
    <div class="recently-viewed">
      <AccountNavigation title="Recently Viewed" />
      <div v-if="loading">Loading...</div>
      <div v-else>
        <ul>
          <li v-for="item in recentlyViewed" :key="item.id">
            <p>{{ item.name }} - ${{ item.price }}</p>
            <button @click="addToCart(item.id)">Add to Cart</button>
            <button @click="addToWishlist(item.id)">Add to Wishlist</button>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import api from '@/api';
  import AccountNavigation from '@/components/AccountNavigation.vue'; // 引入導航組件
  
  export default {
    components: {
      AccountNavigation, // 註冊導航組件
    },
    setup() {
      const recentlyViewed = ref([]);
      const loading = ref(true);
  
      const fetchRecentlyViewed = async () => {
        try {
          const response = await api.getRecentlyViewed();
          recentlyViewed.value = response.data;
        } catch (error) {
          console.error('Failed to fetch recently viewed items:', error);
        } finally {
          loading.value = false;
        }
      };
  
      const addToCart = async (itemId) => {
        try {
          await api.addToCart(itemId);
          alert('Item added to cart');
        } catch (error) {
          console.error('Failed to add item to cart:', error);
        }
      };
  
      const addToWishlist = async (itemId) => {
        try {
          await api.addToWishlist(itemId);
          alert('Item added to wishlist');
        } catch (error) {
          console.error('Failed to add item to wishlist:', error);
        }
      };
  
      onMounted(() => {
        fetchRecentlyViewed();
      });
  
      return {
        recentlyViewed,
        loading,
        addToCart,
        addToWishlist,
      };
    },
  };
  </script>
  
  <style scoped>
  .recently-viewed {
    padding: 20px;
  }
  
  ul {
    list-style: none;
    padding: 0;
  }
  
  li {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
  }
  
  button {
    margin-right: 5px;
  }
  </style>