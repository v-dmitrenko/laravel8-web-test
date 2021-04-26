import axios from 'axios';
import store from '../store';
import router from '../router';
import AuthService from '../services/auth-service';

export default function axiosSetUp() {
    // Add a response interceptor
    axios.interceptors.response.use(
        async function(response) {
            // Any status code that lie within the range of 2xx cause this function to trigger
            // Do something with response data

            return response;
        },
        async function(error) {
            // Any status codes that falls outside the range of 2xx cause this function to trigger
            // Do something with response error
            const originalRequest = error.config;
            if (error.response.status === 401 && originalRequest.url.includes(AuthService.getRefreshTokenPath())) {
                store.commit("logout");
                router.push("/");
                return Promise.reject(error);
            } else if (error.response.status === 401 && !originalRequest._retry) {
                console.log('Work interseptors Error');
                originalRequest._retry = true;
                await store.dispatch("refreshToken");
                return axios(originalRequest);
            }
            return Promise.reject(error);
        }
    );
  }
