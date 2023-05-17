import axios from 'axios';
import router from '../router/index.js';

const login = (email, password) => {
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
};


const checkAuth = () => {
  return axios
    .get('http://127.0.0.1:8000/api/check-auth')
    .then(response => {
      const authenticated = response.data.authenticated;
      if (authenticated) {
        // Usuário autenticado, prosseguir para as rotas protegidas
        return true;
      } else {
        // Usuário não autenticado, redirecionar para a tela de login
        throw new Error('Usuário não autenticado');
      }
    })
    .catch(() => {
      // Erro ao verificar a autenticação, redirecionar para a tela de login
      throw new Error('Erro ao verificar autenticação');
    });
};


export default {
  login,
  checkAuth
};
