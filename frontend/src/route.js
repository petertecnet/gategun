import { createRouter, createWebHistory } from 'vue-router';
import LoginView from '@/views/LoginView.vue';
import RegisterView from '@/views/RegisterView.vue';
import HomeView from '@/views/HomeView.vue';


const routes = [
    {
        path: '/',
        name: 'Login',
        component: LoginView,
      }, 
      {
        path: '/register',
        name: 'Register',
        component: RegisterView,
      }, 
      {
        path: '/home',
        name: 'Home',
        component: HomeView,
      },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
