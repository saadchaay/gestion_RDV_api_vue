import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import SignupView from "../views/SignupView.vue";
import LoginView from "../views/LoginView.vue";
import AptView from "../views/AptView.vue";
import AptsView from "../views/AptsView.vue";
import SchedulesView from "../views/SchedulesView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/appointments",
    name: "appointments",
    component: AptView,
  },
  {
    path: "/appointment",
    name: "appointment",
    component: AptsView,
  },
  {
    path: "/schedules",
    name: "schedules",
    component: SchedulesView,
  },
  {
    path: "/sign-up",
    name: "SignUp",
    component: SignupView,
  },
  {
    path: "/login",
    name: "Login",
    component: LoginView,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
