<template>
    <div class="wishlists">
      <AccountNavigation title="Wishlists" />
      <div v-if="loading">Loading...</div>
      <div v-else>
        <ul>
          <li v-for="item in wishlist" :key="item.id">
            <p>{{ item.name }} - ${{ item.price }}</p>
            <button @click="removeFromWishlist(item.id)">Remove</button>
            <button @click="addToCart(item.id)">Add to Cart</button>
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
      const wishlist = ref([]);
      const loading = ref(true);
  
      const fetchWishlist = async () => {
        try {
          const response = await api.getWishlist();
          wishlist.value = response.data;
        } catch (error) {
          console.error('Failed to fetch wishlist:', error);
        } finally {
          loading.value = false;
        }
      };
  
      const removeFromWishlist = async (itemId) => {
        try {
          await api.removeFromWishlist(itemId);
          fetchWishlist();
        } catch (error) {
          console.error('Failed to remove item:', error);
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
  
      onMounted(() => {
        fetchWishlist();
      });
  
      return {
        wishlist,
        loading,
        removeFromWishlist,
        addToCart,
      };
    },
  };
  </script>
  
  <style scoped>
  .wishlists {
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