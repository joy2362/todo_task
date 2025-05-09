import Guest from "@/middleware/Guest";

const routes = [
    {
        path: "/login",
        name: "login",
        component: () => import("@/pages/Auth/Login.vue"),
        meta: {
            title: "Login",
            middleware: [Guest],
        },
    },
    {
        path: "/register",
        name: "register",
        component: () => import("@/pages/Auth/Register.vue"),
        meta: {
            title: "Registers",
            middleware: [Guest],
        },
    },
];

export default routes;
