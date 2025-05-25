import { createRouter, createWebHistory } from "vue-router";

import home from "../Landing/Home.vue";
import destination from "../Landing/Destination.vue";
import blogs from "../Landing/Blogs.vue";
import aboutus from "../Landing/Aboutus.vue";
import contactus from "../Landing/Contactus.vue";    
import notFound from "../components/notfound.vue";
import profile from "../Landing/Profile.vue";
import yourbookings from "../Landing/Yourbookings.vue";
import notifications from "../Landing/Notifications.vue";
const routes = [

    {
        path: "/home",
        component: home,
    },
    {
        path: "/destination",
        component: destination,
    },
    {
        path: "/blogs",
        component: blogs,
    },
    {
        path: "/aboutus",
        component: aboutus,
    },
    {
        path: "/contactus",
        component: contactus,
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    },
    {
        path: "/profile",
        component: profile,
    },
    {
        path: "/yourbookings",
        component: yourbookings,
    },
    {
        path: "/notifications",
        component: notifications,
    },
]

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: "active",
    routes,
});

export default router