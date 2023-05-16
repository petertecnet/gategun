import axios from 'axios';
import router from '../router/index.js';


const AuthService = {
  login(email, password) {
    const data = {
      email: email,
      password: password
    };
    return axios.post('http://127.0.0.1:8000/api/login', data)
      .then(response => {
        if (response.data.success) {
          // Login bem-sucedido, redirecionar para a página Home
          router.push('/home');
        } else {
          // Exibir mensagem de erro no console
          console.error(response.data.message);
        }
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
