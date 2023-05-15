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
  },
  register(name, email, password) {
    const data = {
      name: name,
      email: email,
      password: password,
    };
  
    return axios.post('http://127.0.0.1:8000/api/register', data)
      .then(response => {
        // Lógica de manipulação da resposta do servidor após o registro
        return response.data;
      })
      .catch(error => {
        // Tratamento de erro
        throw error;
      });
  }
};

export default AuthService;
