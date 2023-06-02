import axios from 'axios';
import {MainService} from './main.service';

class ProductService extends MainService {
    list(page = null, search = null) {
        let params = {};
        if (page) {
            params.page = page;
        }
        if (search) {
            params.search = search;
        }
        return axios
            .get('product', {params})
            .then(response => {
                return response.data;
            });
    }
    create(product) {
        return axios
            .post('product', product, {headers: this.headers()})
            .then(response => {
                return response.data;
            });
    }
    show(id) {
        return axios
            .get(`product/${id}`, {headers: this.headers()})
            .then(response => {
                return response.data;
            });
    }
    update(id, product) {
        return axios
            .patch(`product/${id}`, product, {headers: this.headers()})
            .then(response => {
                return response.data;
            });
    }
    delete(id) {
        return axios
            .delete(`product/${id}`, {headers: this.headers()})
            .then(response => {
                return response.data;
            });
    }
    bookmark(id, type) {
        return axios
            .post(`product/bookmark/${id}`, {type}, {headers: this.headers()})
            .then(response => {
                return response.data;
            });
    }
}
export default new ProductService();
