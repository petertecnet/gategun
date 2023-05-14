<template>
    <div class="login-view">
      <h1>Login View</h1>
      <LoginForm @submit="handleLoginFormSubmit" />
    </div>
  </template>
  
  <script>
  import LoginForm from "@/components/LoginForm";
  
  export default {
    name: "LoginView",
    components: {
      LoginForm,
    },
    methods: {
      handleLoginFormSubmit(credentials) {
        // Lógica para lidar com o envio do formulário de login
      },
    },
  };
  </script>
  
  <style>
  .login-view {
    /* Estilos para o componente LoginView */
  }
  </style>
  