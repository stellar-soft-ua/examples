import axios from 'axios';

const http = axios.create({
    baseURL: '/wp-json/read-counter'
});

const post_id = wp_data && wp_data.post_id || null;
const count_after_seconds = 1;

if (+post_id > 0) {
    /**
     * Increase the read counter after one second
     */
    setTimeout(() => {
        http.post('/increase/' + post_id);
    }, count_after_seconds * 1000);
}
