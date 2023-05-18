<template>
  <div class="login-screen">
    <div class="login-card">
      <div class="logo-container">
        <img src="../assets/logo.png" alt="Logo" class="logo">
      </div>
      
      <img src="../assets/gategun.png" alt="gategun-letters" class="letters">
      
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <div class="input-container">
            <input type="name" id="name" v-model="name" required>
            <label>Name</label>
          </div>
        </div>
        <div class="form-group">
          <div class="input-container">
            <input type="email" id="email" v-model="email" required>
            <label>Email</label>
          </div>
        </div>
        <div class="form-group">
          <div class="input-container">
            <input type="password" id="password" v-model="password" required>
            <label>Senha</label>
          </div>
        </div>
        <div>
          <button class="image-button" type="submit">
            <img src="../assets/button.png" alt="Imagem">
            <span class="button-text">Concluir</span>
          </button>
        </div>
      </form>
      
      <div class="button-group">
        <button class="image-button" @click="redirectToLogin">
          <img src="../assets/button.png" alt="Imagem">
          <span class="button-text">Jà tenho cadastro</span>
        </button>
      </div>
      
      <div class="button-group">
        <button class="image-button">
          <img src="../assets/button.png" alt="Imagem">
          <span class="button-text">Esqueceu a senha?</span>
        </button>
      </div>
    </div>
    <div>

      <!-- Modal -->
      <div v-if="modalVisible" class="modal">
        <div class="modal-content">
          <!-- Conteúdo do modal -->
          <h3>Erro</h3>
          <p>{{ errorMessage }}</p>

          <!-- Botão para fechar o modal -->
          <button @click="redirectToLogin">Fechar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>import AuthService from '@/services/AuthService';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      modalVisible: false,
      errorMessage: '',
    };
  },

  methods: {
    submitForm() {
  const userData = {
    name: this.name,
    email: this.email,
    password: this.password,
  };

  AuthService.register(userData)
    .then(response => {
      // Verifique a resposta do servidor e tome a ação apropriada
      // por exemplo, exibir mensagem de sucesso ou erro
      this.showAlert2(response.data.message);

      // Autenticar o usuário automaticamente
      AuthService.login(userData)
        .then(response => {
          if (response.data.success) {
            // Login bem-sucedido, redirecionar para a página Home
            this.$router.push('/home');
          } else {
            // Exibir mensagem de erro no modal
            this.errorMessage = response.data.message;
            this.errorModalVisible = true;
          }
        })
        .catch(error => {
          // Trate o erro aqui
          if (error.response && error.response.data && error.response.data.message) {
            this.showAlert(error.response.data.message);
          } else {
            this.showAlert('Ocorreu um erro desconhecido durante o login automático.');
          }
        });
    })
    .catch(error => {
      // Trate o erro aqui
      if (error.response && error.response.data && error.response.data.message) {
        this.showAlert(error.response.data.message);
      } else {
        this.showAlert('Ocorreu um erro desconhecido durante o registro.');
      }
    });
},


    redirectToLogin() {
      this.$router.push('/');
    },

    closeModal() {
      this.modalVisible = false;
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
    },showAlert2(message) {
      Swal.fire({
        title: 'Sucesso',
        text: message,
        icon: 'success',
        customClass: {
          container: 'my-modal-container',
          title: 'my-modal-title',
          content: 'my-modal-content',
          confirmButton: 'my-modal-confirm-button',
        },
        // Mais opções de estilo aqui
      });
    },
  }
};

</script>

<style scoped>
/* Estilos específicos do componente LoginView.vue */

@import url('@/assets/css/gategun.css');
</style>
