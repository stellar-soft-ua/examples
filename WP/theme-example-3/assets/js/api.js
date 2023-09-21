import axios from 'axios';

const http = axios.create({
    baseURL: '/wp-json/wp/v2'
});

http.interceptors.response.use((response) => {
    return response;
}, function (error) {
    return Promise.reject(error.response);
});

http.defaults.params = {
    lang: document.documentElement.lang || null
};

export const api = {
    search: ({post_type = undefined, search = '', per_page = 10}) => http.get('/search', {
        params: {
            type: 'post',
            search: search,
            subtype: post_type,
            per_page: per_page
        }
    }),
    posts: (post_type, params) => http.get(`/${post_type}`, {params}),
    projectsAndEvents: params => http.get('/events-projects', {
        params,
        baseURL: '/wp-json/posts'
    }),
};
