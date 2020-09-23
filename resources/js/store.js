import Vue from 'vue'
import Vuex from 'vuex'
import auth from "./modules/auth"
import channel from "./modules/channel"
import flash from "./modules/flash"
import photo from "./modules/photo"

Vue.use(Vuex)

export default new Vuex.Store({
	modules: { auth, channel, flash, photo }
})