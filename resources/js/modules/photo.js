export default {
	namespaced: true,
    state: {
    	photos: {},
		photo: null,
		loading: false
    },
    mutations: {
    	get(state, photos) {
			state.photos = photos
		},
		view(state, photo) {
			state.photo = photo
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
}