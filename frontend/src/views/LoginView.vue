<template>
    <div class="login-screen">
      <div class="login-card">
        <h2>Login</h2>
        <form @submit="submitForm">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" v-model="email" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" v-model="password" required>
          </div>
          <div class="form-group">
            <button type="submit">Login</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
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
      }
    }
  }
  </script>
  
  <style scoped>
  /* Outros estilos específicos do componente LoginView.vue */
  
  @import '../assets/css/gategun.css';
  </style>
  