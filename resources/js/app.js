import "./bootstrap";
import { createApp } from "vue";
import { createNotivue } from "notivue";

import App from "./App.vue";
import router from "./router";
import "../css/app.css";

import "notivue/notification.css"; // Only needed if using built-in <Notification />
import "notivue/animations.css"; // Only needed if using default animations
import { createPinia } from "pinia";
import { useUserStore } from "./store/user";

const pinia = createPinia();
const notivue = createNotivue(/* Options */);
const app = createApp(App);
app.use(notivue).use(pinia);
let userStore;
const token = localStorage.getItem("token");

if (token) {
    userStore = useUserStore();
    await userStore.fetchUser();
}

app.use(router).mount("#app");
