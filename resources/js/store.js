import Vue from 'vue'
import Vuex from 'vuex'
import auth from "./modules/auth"
import channel from "./modules/channel"
import flash from "./modules/flash"

Vue.use(Vuex)

export default new Vuex.Store({
	modules: { auth, channel, flash },
	state: {
		photos: {},
		loading: false
	},
	mutations: {
		get(state, photos) {
			state.photos = photos
		},
		add(state, photo) {
			state.photos.data.push(photo)
		},
		remove(state, photo) {
			state.photos.data.splice(state.photos.data.indexOf(photo), 1)
		},
		loading(state, loading) {
			state.loading = loading
		}
	},
	actions: {
		get({ commit }, params) {
			commit("loading", true)

			return axios.get("/api/photos", { params })
				.then(response => {
					commit("loading", false)
					commit("get", response.data)
				})
		},
		add({ commit }, form) {
			return axios.post("/api/photos", form)
				.then(response => commit("add", response.data))
		},
		remove({ commit }, photo) {
			axios.delete(`/api/photos/${photo.id}`)
				.then(() => commit("remove", photo))
		}
	}
})