import { createRouter, createWebHistory } from "vue-router";
import DashboardView from "@/views/DashboardView.vue";
import ManajemenBukuView from "@/views/ManajemenBukuView.vue";
import ManajemenPeminjamanView from "@/views/ManajemenPeminjamanView.vue";
import ReportView from "@/views/ReportView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "dashboard",
      component: DashboardView,
    },
    {
      path: "/about",
      name: "about",
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import("../views/AboutView.vue"),
    },
    {
      path: "/manajemen-buku",
      name: "manajemen-buku",
      component: ManajemenBukuView,
    },
    {
      path: "/manajemen-peminjaman",
      name: "manajemen-peminjaman",
      component: ManajemenPeminjamanView,
    },
    {
      path: "/report",
      name: "report",
      component: ReportView,
    },
  ],
});

export default router;
