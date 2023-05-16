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
              <input type="email" id="email"  v-model="email" required>
              <label>Email</label>
            </div>
          </div>
          <div class="form-group">
            <div class="input-container">
              <input type="password" id="password" v-model="password" required>
              <label>Senha</label>
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
    <modal v-if="errorModalVisible" @close="closeModal">
    <h3>Erro</h3>
    <p>{{ errorMessage }}</p>
  </modal>
  </template>
  
  
<script>
import AuthService from '@/services/AuthService';

export default {
  // Restante do seu código
  
  data() {
    return {
      // Outros dados do componente
      errorModalVisible: false,
      errorMessage: ''
    };
  },
  
  methods: {
    // Restante dos seus métodos
    
    submitForm() {
        
        console.log(this.email); 
      AuthService.login(this.email, this.password)
        .then(response => {
            console.log(this.email); 
          if (response.success) {
            // Login bem-sucedido, redirecionar para a página Home
            console.log('oi'); 
            this.$router.push('/home');
          } else {
            // Exibir mensagem de erro no modal
            console.log('oi'); 
            this.showModal(response.message);
          }
        })
        .catch(error => {
          // Tratamento de erro
          console.error(error);
        });
    },
    redirectToRegister(){
        this.$router.push('/register');
    },
    showModal(message) {
      this.errorMessage = message;
      this.errorModalVisible = true;
    },
    
    closeModal() {
      this.errorModalVisible = false;
    }
  }
};
</script>
<style scoped>
/* Outros estilos específicos do componente LoginView.vue */

@import url('@/assets/css/gategun.css');
</style>
