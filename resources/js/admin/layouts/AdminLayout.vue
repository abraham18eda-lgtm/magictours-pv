<template>
  <div class="flex min-h-screen bg-gray-100">
    
    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
        CMS - Tours
      </div>

      <nav class="flex-1 p-4 space-y-2">
        <router-link
          to="/admin/dashboard"
          class="block px-4 py-2 rounded hover:bg-gray-700"
        >
          🏠 Dashboard
        </router-link>

        <router-link
          to="/admin/tours"
          class="block px-4 py-2 rounded hover:bg-gray-700"
        >
          🌴 Ver Tours
        </router-link>
        <router-link
          to="/admin/tours/create"
          class="block px-4 py-2 rounded hover:bg-gray-700"
        >
          🌴 Agregar Tours
        </router-link>
      </nav>

      <div class="p-4 border-t border-gray-700">
        <button
          @click="logout"
          class="w-full bg-red-500 hover:bg-red-600 py-2 rounded"
        >
          Cerrar sesión
        </button>
      </div>
    </aside>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col">

      <!-- HEADER -->
      <header class="bg-white shadow px-6 py-2 flex justify-center items-center">
         <img
            :src="logo"
            class="w-[180px] lg:h-[80px]  object-contain"
            alt="Logo"
          />
        <!-- <h1 class="text-xl font-semibold">Panel Admin</h1> -->
      </header>

      <!-- PAGE -->
      <main class="p-6 flex-1 overflow-y-auto">
        <router-view />
      </main>

    </div>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { useUserStore } from "../stores/user";
import logo from "../../assets/logos/magic-tours-hz.svg"

const router = useRouter();
const userStore = useUserStore();

const logout = () => {
  userStore.logout();
  router.push({ name: "Login" });
};
</script>