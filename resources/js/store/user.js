import { defineStore } from "pinia";
import axios from "axios";

export const useUserStore = defineStore("user", {
    state: () => ({
        user: null,
        authenticated: false,
    }),
    actions: {
        async fetchUser() {
            try {
                const res = await axios.get("/api/v1/me");

                this.user = res.data.profile;
                this.authenticated = true;
            } catch (error) {
                console.log(error);

                localStorage.removeItem("token");
                this.authenticated = false;
            }
        },

        setData(data) {
            this.user = data.profile;
            localStorage.setItem("token", data.token);
            this.authenticated = true;
        },

        logout() {
            localStorage.removeItem("token");
            this.authenticated = false;
            this.user = null;
        },
    },
});
