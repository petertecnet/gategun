<template>
  <div>
    <MenuBar />
    <h1>Welcome, {{ user ? user.name : '' }}</h1>
    <!-- Conteúdo da página Home -->
  </div>
</template>

<script>
import MenuBar from '@/components/MenuBarComponent.vue';
import AuthService from '@/services/AuthService';

export default {
  name: 'HomeView',
  components: {
    MenuBar,
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