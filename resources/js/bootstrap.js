/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
import { useUserStore } from "./store/user";
window.axios = axios;

let userStore;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.interceptors.request.use((config) => {
    config.headers["Authorization"] = `Bearer ${localStorage.getItem("token")}`;
    userStore = useUserStore();

    return config;
});

axios.interceptors.response.use(
    (res) => {
        userStore = useUserStore();
        return res;
    },
    (err) => {
        userStore = useUserStore();

        if (err.response?.status == 403) {
            window.location = "/403";
        }

        if (err.response?.status == 404) {
            window.location = "/404";
        }

        if (err.response?.status == 401) {
            if (localStorage.getItem("token")) {
                localStorage.removeItem("token");
                window.location = "/";
            }
        }
        return Promise.reject(err);
    },
);

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
