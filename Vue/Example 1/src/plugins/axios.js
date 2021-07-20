import axios from 'axios';

const axiosApiInstance = axios.create({
    baseURL: process.env.VUE_APP_API_ENDPOINT + 'api/v1/',
    withCredentials: true,
});

export default axiosApiInstance;