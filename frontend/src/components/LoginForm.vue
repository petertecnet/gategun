<template>
    <div class="login-form">
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
  </template>
  
  <script>
  import AuthService from '../services/AuthService';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async submitForm(event) {
        event.preventDefault();
        try {
          const response = await AuthService.login(this.email, this.password);
          console.log(response); // Log the response or perform any desired action
        } catch (error) {
          console.error(error); // Handle the error or show an error message
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* CSS styles specific to LoginForm.vue */
  .login-form {
    /* Your styles here */
  }
  </style>
  