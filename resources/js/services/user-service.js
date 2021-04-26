import axios from 'axios';
import authHeader from './auth-header-service';

const API_URL = 'http://localhost/api/users/';

class UserService {
    getListUsers(pageNumber = 1) {
        return axios.get(API_URL, {
            params: { page: pageNumber },
            headers: authHeader()
        });
    }
}

export default new UserService();
