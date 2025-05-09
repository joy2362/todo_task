import { createRouter, createWebHistory } from "vue-router";
import beforeEach from "./beforeEach";

import auth from "./modules/auth";
import error from "./modules/error";
import task from "./modules/task";
import Auth from "@/middleware/Auth";

const routes = [
    ...auth,
    {
        path: "/",
        component: () => import("@/layouts/MainLayout.vue"),
        meta: {
            middleware: [Auth],
        },
        children: [
            {
                path: "",
                name: "dashboard",
                component: () => import("@/pages/Index.vue"),
                meta: {
                    title: "Dashboard",
                },
            },
            ...task,
        ],
    },
    ...error,
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    beforeEach(to, from, next, router);
});

export default router;
