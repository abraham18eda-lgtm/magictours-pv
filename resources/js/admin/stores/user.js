import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useUserStore = defineStore('user', () => {
  const token = ref(localStorage.getItem('token'));

  const setToken = (t) => {
    token.value = t;
    localStorage.setItem('token', t);
  };

  const logout = () => {
    token.value = null;
    localStorage.removeItem('token');
  };

  return { token, setToken, logout };
});