import axios from "axios";

export class MainService {
    constructor() {
        axios.defaults.baseURL = '/api/';
    }
    headers() {
        const headers = {};
        if (localStorage.getItem('user')) {
            headers.Authorization = `Bearer ${localStorage.getItem('user')}`;
        }
        return headers;
    }
}
