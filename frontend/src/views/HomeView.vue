<template>
  <q-page-container>
    <NavBarHamburger />
    <!-- Conteúdo da página -->
  </q-page-container>
</template>

<script>
import NavBarHamburger from '@/components/NavBarHamburger.vue';

import AuthService from '@/services/AuthService';

export default {
  name: 'HomeView',
  components: {
    NavBarHamburger,
  },
  data() {
    return {
      user: null,
    };
  },
  created() {
    this.getUserData();
  },
  methods: {
    getUserData() {
      AuthService.getUser()
        .then(response => {
          this.user = response.data.user;
        })
        .catch(error => {
          console.error(error);
        });
    },
  },
};
</script>

  <style scoped>  
  @import url('@/assets/css/home.css');
  </style>