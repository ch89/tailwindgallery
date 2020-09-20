<template>
	<div>
		<div class="grid gap-6 md:grid-cols-3">
			<photo v-for="photo in photos.data" :key="photo.id" :photo="photo"></photo>
		</div>

		<pagination></pagination>
	</div>
</template>

<script>
	import Photo from "../components/Photo"
	import Pagination from "../components/Pagination"
	import { mapState, mapActions } from "vuex"
	import store from "../store"

	export default {
		components: { Photo, Pagination },
		computed: mapState(["photos"]),
		methods: mapActions(["get"]),
		// created() {
		// 	this.get()
		// }
		async beforeRouteEnter(to, from, next) {
			await store.dispatch("get", to.query)

			next()
		},
		async beforeRouteUpdate(to, from, next) {
			await this.get(to.query)

			next()
		},
	}
</script>