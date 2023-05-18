<template>
  <q-header>
    <q-toolbar>
      <q-btn
        flat
        round
        dense
        icon="menu"
        @click="toggleMenu"
      />

      <q-toolbar-title>
        Meu Site
      </q-toolbar-title>
    </q-toolbar>
  </q-header>

  <q-drawer
    v-model="menuOpen"
    show-if-above
    side="left"
  >
    <q-list>
      <q-item v-for="item in menuItems" :key="item.label" clickable>
        <q-item-section>
          <q-item-label>{{ item.label }}</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </q-drawer>
</template>
  
  <!-- Resto do código permanece igual -->
  
  
  
  <script>
  import AuthService from '@/services/AuthService';
  
  export default {
    name: 'MenuBar',
    data() {
      return {
        menuOpen: false,
      menuItems: [
        { label: 'Página 1' },
        { label: 'Página 2' },
        { label: 'Página 3' },
      ],
      };
    },
    created() {
      this.getUserData();
      this.checkMobile();
      window.addEventListener('resize', this.checkMobile);
    },
    beforeUnmount() {
      window.removeEventListener('resize', this.checkMobile);
    },
    methods: {
      toggleMenu() {
        this.isMenuOpen = !this.isMenuOpen;
      },
      getUserData() {
        AuthService.getUser()
          .then(response => {
            this.user = response.data.user;
          })
          .catch(error => {
            console.error(error);
          });
      },
      toggleProfileMenu() {
        this.showProfileMenu = !this.showProfileMenu;
      },
      toggleMobileMenu() {
        this.showMobileMenu = !this.showMobileMenu;
      },
      logout() {
        AuthService.logout()
          .then(() => {
            // Limpar o token e redirecionar para a página de login
            localStorage.removeItem('token');
            this.$router.push('/');
          })
          .catch(error => {
            console.error(error);
          });
      },
      checkMobile() {
        this.isMobile = window.innerWidth <= 768;
      },
    },
    computed: {
      isDesktop() {
        return !this.isMobile;
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos personalizados */
  </style>
  