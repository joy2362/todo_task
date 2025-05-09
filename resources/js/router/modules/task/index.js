import Auth from "@/middleware/Auth";

const routes = [
    {
        path: "/task",
        name: "task",
        component: () => import("@/pages/Task/Index.vue"),
        meta: {
            title: "Task",
        },
    },
    {
        path: "/task/create",
        name: "task.create",
        component: () => import("@/pages/Task/Create.vue"),
        meta: {
            title: "Create task",
        },
    },
    {
        path: "/task/:id",
        name: "task.show",
        component: () => import("@/pages/Task/Show.vue"),
        meta: {
            title: "Show task",
        },
    },
    {
        path: "/task/:id/edit",
        name: "task.edit",
        component: () => import("@/pages/Task/Edit.vue"),
        meta: {
            title: "Edit task",
        },
    },
];

export default routes;
