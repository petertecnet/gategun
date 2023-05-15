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
            <input type="name" id="email" v-model="name" required>
            <label>Nome</label>
          </div>
        </div><div class="form-group">
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
        <button class="secondary-button" @click="redirectLogin">Já tem cadastro?</button>
      </div>
    </div>
  </div>
</template>
  

<script>
import AuthService from '@/services/AuthService';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
    };
  },
  methods: {
    submitForm() {
      AuthService.register(this.name, this.email, this.password)
        .then(response => {
          // Lógica após o registro bem-sucedido
          console.log(response);
        })
        .catch(error => {
          // Tratamento de erro
          console.error(error);
        });
    }
  }
};
</script>
  <style scoped>
  @import url('@/assets/css/gategun.css');
  </style>
  