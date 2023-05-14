<template>
    <div class="login-view">
      <h1>Welcome to the Login Page</h1>
      <LoginForm />
    </div>
  </template>
  
  <script>
  import LoginForm from '@/components/LoginForm';
  
  export default {
    components: {
      LoginForm,
    },
  };
  </script>
  
  <style scoped>
  /* CSS styles specific to LoginView.vue */
  .login-view {
    /* Your styles here */
  }
  </style>
  