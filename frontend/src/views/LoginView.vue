<template>
  <div class="login-screen">
    <div class="login-card">
      <div class="logo-container">
        <img src="../assets/logo.png" alt="Logo" class="logo">
      </div>

      <img src="../assets/gategun.png" alt="gategun-letters" class="letters">

      <form @submit.prevent="submitForm">
        <label class="label">Email</label>
        <div class="form-group">
          <div class="input-container">
            <input type="email" id="email" v-model="email" required>
          </div>
        </div>

        <label class="label">Password</label>
        <div class="form-group">
          <div class="input-container">
            <input type="password" id="password" v-model="password" required>
          </div>
        </div>

        <button class="image-button" type="submit">
          <img src="../assets/button.png" alt="Imagem">
          <span class="button-text">Login</span>
        </button>
      </form>

      <div class="button-group">
        <button class="image-button" @click="redirectToRegister">
          <img src="../assets/button.png" alt="Imagem">
          <span class="button-text">Novo cadastro</span>
        </button>
        </div>
        

      <div class="button-group">
        <button class="image-button">
          <img src="../assets/button.png" alt="Imagem">
          <span class="button-text">Esqueceu a senha?</span>
        </button>
      </div>
    </div>
    <div></div>
  </div>
</template>


<script>
import AuthService from '@/services/AuthService';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      email: '',
      password: '',
      errorModalVisible: false,
      errorMessage: '',
      modalVisible: false,
    };
  },

  methods: {
    submitForm() {
      AuthService.login({
        email: this.email,
        password: this.password,
      })
        .then(response => {
          if (response.data.success) {
            const token = response.data.token; // Obtenha o token da resposta
        localStorage.setItem('token', token); // Armazene o token no armazenamento local
        localStorage.setItem('user', JSON.stringify(response.data));
            // Login bem-sucedido, redirecionar para a página Home
            this.$router.push('/home');
          } else {
            // Exibir mensagem de erro no modal
            this.errorMessage = response.data.message;
            this.errorModalVisible = true;
          }
        })
        .catch(error => {
          if (error.response && error.response.data && error.response.data.message) {
            this.showAlert(error.response.data.message);
          } else {
            this.showAlert('Ocorreu um erro desconhecido.');
          }
        });
    },

    redirectToRegister() {
      this.$router.push('/register');
    },

    showAlert(message) {
      Swal.fire({
        title: 'Erro',
        text: message,
        icon: 'error',
        customClass: {
          container: 'my-modal-container',
          title: 'my-modal-title',
          content: 'my-modal-content',
          confirmButton: 'my-modal-confirm-button',
        },
        // Mais opções de estilo aqui
      });
    },
  },
};
</script>

<style scoped>
/* Estilos específicos do componente LoginView.vue */

@import url('@/assets/css/gategun.css');
</style>
