import { createRouter, createWebHistory } from "vue-router";

import home from "../components/Homepage.vue";
import about from "../components/Aboutpage.vue";
import notFound from "../components/NotfoundPage.vue";

const routes = [

    {
        path: "/",
        component: home,
    },
    {
        path: "/destination",
        component: about,
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    }
]

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: "active",
    routes,
});

export default router