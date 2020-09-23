import Vue from "vue"
import axios from "axios"
import router from "./router"
import store from "./store"
import "nprogress/nprogress.css"
import Navbar from "./components/Navbar"
import Modal from "./components/Modal"
import Flash from "./components/Flash"
import Comments from "./components/Comments"
import CommentsModal from "./components/CommentsModal"
import { mapState } from "vuex"

window.axios = axios
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

let auth = localStorage.getItem("auth")

if(auth) store.commit("auth/add", JSON.parse(auth))
	
Vue.prototype.$flash = {
	id: 1,
	message(text, type) {
		store.dispatch("flash/add", { id: this.id++, text, type })
	},
	success(text) {
		this.message(text, "success")
	},
	danger(text) {
		this.message(text, "danger")
	},
	warning(text) {
		this.message(text, "warning")
	}
}

Array.prototype.remove = function(item) {
	return this.splice(this.indexOf(item), 1)[0]
}

let app = new Vue({
	el: "#app",
	router,
	store,
	components: { Navbar, Modal, Flash, Comments, CommentsModal },
	computed: {
		...mapState("channel", ["channels"]),
		...mapState("photo", ["photo"])
	},
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
			this.$store.dispatch("photo/add", this.form)
				.then(() => this.close())
				.catch(errors => this.errors = errors.response.data.errors)
		},
		addWithImage(e) {
			this.$store.dispatch("photo/add", new FormData(e.target))
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