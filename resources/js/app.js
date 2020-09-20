import Vue from "vue"
import axios from "axios"
import router from "./router"
import store from "./store"
import "nprogress/nprogress.css"
import Navbar from "./components/Navbar"
import Modal from "./components/Modal"
import { mapState } from "vuex"

window.axios = axios
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

let auth = localStorage.getItem("auth")

if(auth) store.commit("auth/add", JSON.parse(auth))

let app = new Vue({
	el: "#app",
	router,
	store,
	components: { Navbar, Modal },
	computed: mapState("channel", ["channels"]),
	data: {
		show: false,
		form: {},
		errors: {}
	},
	created() {
		axios.get("/api/channels")
			.then(response => store.commit("channel/set", response.data))
	},
	methods: {
		add() {
			this.$store.dispatch("add", this.form)
				.then(() => this.close())
				.catch(errors => this.errors = errors.response.data.errors)
		},
		addWithImage(e) {
			this.$store.dispatch("add", new FormData(e.target))
				.then(() => this.close())
				.catch(errors => this.errors = errors.response.data.errors)
		},
		close() {
			this.show = false
			// this.form = {}
			this.$refs["photo-form"].reset()
			this.errors = {}
		}
	}
})