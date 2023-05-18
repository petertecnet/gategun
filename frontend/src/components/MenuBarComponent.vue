<template>
 <div>
  <b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="#">NavBar</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item href="#">Link</b-nav-item>
        <b-nav-item href="#" disabled>Disabled</b-nav-item>
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
        </b-nav-form>

        <b-nav-item-dropdown text="Lang" right>
          <b-dropdown-item href="#">EN</b-dropdown-item>
          <b-dropdown-item href="#">ES</b-dropdown-item>
          <b-dropdown-item href="#">RU</b-dropdown-item>
          <b-dropdown-item href="#">FA</b-dropdown-item>
        </b-nav-item-dropdown>

        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em>User</em>
          </template>
          <b-dropdown-item href="#">Profile</b-dropdown-item>
          <b-dropdown-item href="#">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</div>
</template>

<script>
import AuthService from '@/services/AuthService';

export default {
  name: 'MenuBar',
  data() {
    return {
      isMenuOpen: false,
      user: null,
      showProfileMenu: false,
      isMobile: false,
      showMobileMenu: false,
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

  
  <style scoped>
  /* Estilos personalizados */
  </style>
  