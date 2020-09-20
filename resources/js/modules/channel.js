export default {
	namespaced: true,
    state: {
    	channels: []
    },
    mutations: {
    	set(state, channels) {
    		state.channels = channels
    	},
    	add(state, channel) {
    		state.channels.push(channel)
    	},
    	remove(state, channel) {
    		state.channels.splice(state.channels.indexOf(channel), 1)
    	}
    }
}