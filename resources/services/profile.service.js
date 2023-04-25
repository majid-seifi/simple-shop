import axios from 'axios';
import {MainService} from './main.service';

class ProfileService extends MainService {
    show(page) {
        const query = page ? `/?page=${page}` : '';
        return axios
            .get('profile' + query, {headers: this.headers()})
            .then(response => {
                return response.data;
            });
    }
}
export default new ProfileService();
