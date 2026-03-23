import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from './stores/user';
import Login from './pages/Login.vue';
import Dashboard from './pages/Dashboard.vue';
import Tours from './pages/Tours.vue';
import EditTour from './pages/EditTour.vue';
import CreateTour from './pages/CreateTour.vue';
import api from './api';
import AdminLayout from './layouts/AdminLayout.vue';

const routes = [
  { path: '/admin/login', component: Login, name: 'Login' },

  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: 'dashboard',
        component: Dashboard,
        name: 'Dashboard'
      },
      {
        path: 'tours',
        component: Tours
      },
      {
        path: 'tours/create',
        component: CreateTour
      },
      {
        path: 'tours/edit/:id',
        component: EditTour
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Protección global
router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore();

  // Si requiere auth
  if (to.meta.requiresAuth) {
    if (!userStore.token) {
      return next({ name: 'Login' });
    }

    try {
      // Validar token con backend
      await api.get('/admin/user');
      return next();
    } catch (error) {
      // Token inválido o expirado
      userStore.logout();
      return next({ name: 'Login' });
    }
  }

  // Si intenta ir a login estando autenticado
  if (to.name === 'Login' && userStore.token) {
    return next({ name: 'Dashboard' });
  }

  next();
});

export default router;