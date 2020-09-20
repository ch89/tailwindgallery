export default {
	namespaced: true,
    state: {
    	messages: []
    },
    mutations: {
    	add(state, message) {
    		state.messages.push(message)
    	},
    	remove(state, message) {
    		state.messages.splice(state.messages.indexOf(message), 1)
    	}
    },
    actions: {
    	add({ commit }, message) {
    		commit("add", message)

    		setTimeout(() => commit("remove", message), 5000)
    	}
    }
}