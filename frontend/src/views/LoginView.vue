<template>
    <div class="login-screen">
      <div class="login-card">
        <div class="logo-container">
          <img src="../assets/logo.png" alt="Logo" class="logo">
        </div>
        <h2>GATE</h2><p class="font-logo">GUN</p>
                <form @submit="submitForm">
          <div class="form-group">
            <div class="input-container">
              <input type="email" id="email" v-model="email" required>
              <label>Email</label>
            </div>
          </div>
          <div class="form-group">
            <div class="input-container">
              <input type="password" id="password" v-model="password" required>
              <label>Password</label>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="login-button">Login</button>
          </div>
        </form>
        <div class="button-group">
            <button type="button" class="register-button" @click="redirectToRegister">Novo cadastro</button>
          <button class="secondary-button">Esqueceu a senha?</button>
        </div>
      </div>
    </div>
  </template>
  
  
  <script>
  import '@/assets/css/gategun.css';
  
  export default {
    name: 'LoginView',
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      submitForm() {
        // Lógica para submeter o formulário de login
      },
      
    redirectToRegister() {
    this.$router.push('/register');
  },
    }
  }
  </script>
<style scoped>
/* Outros estilos específicos do componente LoginView.vue */

@import url('@/assets/css/gategun.css');
</style>
