import Vue from "vue"
import Router from "vue-router"
import Layout from "@/views/layout"

Vue.use(Router)

/**
 * Rotas da aplicação
 */
export const constantRouterMap = [
  {
    path: "",
    component: Layout,
    redirect: "dashboard",
    children: [
      {
        path: "dashboard",
        component: () => import("@/views/dashboard/index"),
        name: "dashboard"
      },
      {
        path: "height-problem",
        component: () => import("@/views/heightProblem/index"),
        name: "height.problem"
      }
    ]
  },
  { 
    path: "*",
    redirect: "/404",
    hidden: true 
  },
  {
    path: "/404",
    component: () => import("@/views/errorPage/404"),
    hidden: true
  }
]

export default new Router({
  mode: "history",
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRouterMap
})
