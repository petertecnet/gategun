import axios from 'axios';

const AuthService = {
  login(email, password) {
    const data = {
      email: email,
      password: password
    };

    return axios.post('/api/login', data)
      .then(response => {
        // Lógica de manipulação da resposta do servidor após o login
        return response.data;
      })
      .catch(error => {
        // Tratamento de erro
        throw error;
      });
  }
};

export default AuthService;
