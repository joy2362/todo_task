import Auth from "@/middleware/Auth";
import Guest from "@/middleware/Guest";
import Public from "@/middleware/Public";

const routes = [
    {
        path: "/403",
        name: "403",
        component: () => import("@/pages/error/403.vue"),
        meta: {
            middleware: Auth,
            title: "Unauthorized",
        },
    },
    {
        path: "/401",
        name: "401",
        component: () => import("@/pages/error/401.vue"),
        meta: {
            middleware: Guest,
            title: "Unauthenticated",
        },
    },
    {
        path: "/404",
        name: "404",
        component: () => import("@/pages/error/404.vue"),
        meta: {
            middleware: Public,
            title: "404",
        },
    },
    {
        path: "/:pathMatch(.*)*",
        redirect: "/404",
    },
];
export default routes;
