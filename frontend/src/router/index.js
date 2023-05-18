import { createRouter, createWebHistory } from 'vue-router';
import AuthService from '../services/AuthService';
import LoginView from '@/views/LoginView.vue';
import RegisterView from '@/views/RegisterView.vue';
import HomeView from '@/views/HomeView.vue';
import NavBarHamburger from '@/components/NavBarHamburger.vue';

async function requireAuth(to, from, next) {
  const isAuthenticated = await AuthService.checkAuth(); // Verificar se o usuário está autenticado
  if (isAuthenticated) {
    next(); // O usuário está autenticado, permita o acesso à rota
  } else {
    next('/'); // Redirecionar para a página de login se o usuário não estiver autenticado
  }
}

const routes = [
  { path: '/', component: LoginView },
  { path: '/register', component: RegisterView },
  { path: '/home', component: HomeView, beforeEnter: requireAuth },
  {
    path: '/menu',
    component: NavBarHamburger
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
