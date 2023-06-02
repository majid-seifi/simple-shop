import axios from 'axios';
import {MainService} from './main.service';
class AuthService extends MainService {
    login(user) {
        return axios
            .post('auth/login', {
                email: user.email,
                password: user.password
            })
            .then(response => {
                if (response.data.token) {
                    localStorage.setItem('user', response.data.token);
                    localStorage.setItem('accesses', JSON.stringify(response.data.accesses));
                }
                return response.data;
            });
    }

    logout() {
        localStorage.removeItem('user');
        localStorage.removeItem('accesses');
    }
}
export default new AuthService();
