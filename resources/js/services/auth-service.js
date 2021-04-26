import axios from 'axios';
import authHeader from './auth-header-service';

const API_URL = 'http://localhost/api/auth/';
const API_REFRESH_TOKEN_PATH = 'refresh-token';

class AuthService {
    register(user) {
        return axios.post(API_URL + 'register', {
            name: user.name,
            email: user.email,
            password: user.password,
            password_confirmation: user.password_confirmation
        });
    }

    confirmEmail(data) {
        return axios.get(API_URL + 'register/confirm-email/' + data.email + '/token/' + data.token);
    }

    login(credentials) {
        return axios.post(API_URL + 'login', {
            email: credentials.email,
            password: credentials.password
        });
    }

    refreshToken() {
        return axios.post(API_URL + API_REFRESH_TOKEN_PATH, {}, {
            headers: authHeader(),
        });
    }

    getRefreshTokenPath() {
        return API_REFRESH_TOKEN_PATH;
    }

    logout() {
        return axios.post(API_URL + 'logout', {}, {
            headers: authHeader(),
        });
    }
}

export default new AuthService();
