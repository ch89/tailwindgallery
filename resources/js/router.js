import Vue from "vue"
import VueRouter from "vue-router"
import NProgress from "nprogress"
import store from "./store"
import Home from "./views/Home"
import Photos from "./views/Photos"
import Register from "./views/Register"
import Login from "./views/Login"
import Profile from "./views/Profile"
import Channels from "./views/Channels"
import Users from "./views/Users"

Vue.use(VueRouter)

let router = new VueRouter({
	mode: "history",
	routes: [
		{ path: "/", name: "home", component: Home },
		{ path: "/photos", name: "photos", component: Photos, meta: { auth: true } },
		{ path: "/register", name: "register", component: Register },
		{ path: "/login", name: "login", component: Login },
		{ path: "/profile", name: "profile", component: Profile },
		{ path: "/channels", name: "channels", component: Channels },
		{ path: "/users", name: "users", component: Users }
	]
})

router.beforeEach((to, from, next) => {
	NProgress.start()

	to.meta.auth && ! store.state.auth.user ? next("/login") : next()
})

router.afterEach((to, from) => {
	NProgress.done()
})

export default router