import { createRouter, createWebHistory } from "vue-router";

import home from "../Landing/Home.vue";
const routes = [

    {
        path: "/home",
        component: home,
    },

]

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: "active",
    routes,
});

export default router