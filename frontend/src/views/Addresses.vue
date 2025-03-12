<template>
    <div class="addresses">
      <AccountNavigation title="Addresses" />
      <div v-if="loading">Loading...</div>
      <div v-else>
        <button @click="showAddForm = true">Add New Address</button>
        <div v-if="showAddForm" class="address-form">
          <input v-model="newAddress.name" placeholder="Name" />
          <input v-model="newAddress.phone" placeholder="Phone" />
          <input v-model="newAddress.address" placeholder="Address" />
          <button @click="addAddress">Save</button>
          <button @click="showAddForm = false">Cancel</button>
        </div>
        <ul>
          <li v-for="address in addresses" :key="address.id">
            <p>{{ address.name }} - {{ address.phone }}</p>
            <p>{{ address.address }}</p>
            <button @click="editAddress(address)">Edit</button>
            <button @click="deleteAddress(address.id)">Delete</button>
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
      const addresses = ref([]);
      const loading = ref(true);
      const showAddForm = ref(false);
      const newAddress = ref({ name: '', phone: '', address: '' });
  
      const fetchAddresses = async () => {
        try {
          const response = await api.getAddresses();
          addresses.value = response.data;
        } catch (error) {
          console.error('Failed to fetch addresses:', error);
        } finally {
          loading.value = false;
        }
      };
  
      const addAddress = async () => {
        try {
          await api.addAddress(newAddress.value);
          fetchAddresses();
          showAddForm.value = false;
          newAddress.value = { name: '', phone: '', address: '' };
        } catch (error) {
          console.error('Failed to add address:', error);
        }
      };
  
      const deleteAddress = async (addressId) => {
        try {
          await api.deleteAddress(addressId);
          fetchAddresses();
        } catch (error) {
          console.error('Failed to delete address:', error);
        }
      };
  
      onMounted(() => {
        fetchAddresses();
      });
  
      return {
        addresses,
        loading,
        showAddForm,
        newAddress,
        addAddress,
        deleteAddress,
      };
    },
  };
  </script>
  
  <style scoped>
  .addresses {
    padding: 20px;
  }
  
  .address-form {
    margin-bottom: 20px;
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