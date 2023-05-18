import axios from 'axios';

const BASE_URL = 'http://127.0.0.1:8000/api';

const authService = {
  register(userData) {
    return axios.post(`${BASE_URL}/register`, userData);
  },
  login(credentials) {
    return axios.post(`${BASE_URL}/login`, credentials);
  },
  logout() {
    return axios.post(`${BASE_URL}/logout`, null, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
  },
  refresh() {
    return axios.post(`${BASE_URL}/refresh`, null, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
  },
  getUser() {
    return axios.get(`${BASE_URL}/user`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
  },
  checkAuth() {
    return axios.get(`${BASE_URL}/check-auth`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
  },
};

export default authService;
