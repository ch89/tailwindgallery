<template>
	<div class="absolute z-50 inset-0 bg-black bg-opacity-50 flex justify-center items-center">
		<div class="bg-white rounded-lg w-1/3">
			<div class="flex justify-between items-center p-6">
				<div class="flex">
					<h3 class="font-bold text-lg mr-4" v-text="photo.title">Title</h3>
					<button class="btn btn-sm" :class="[photo.subscribed ? 'btn-blue' : 'btn-secondary', { loading }]" disabled @click="subscribe">Subscribe</button>
				</div>
				<button class="focus:outline-none" @click="close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="border-t border-b border-gray-300 max-h-lg overflow-auto p-6" v-on="active ? { scroll } : {}">
				<div class="comment shadow rounded overflow-hidden" v-for="comment in comments.data">
					<div class="bg-gray-800 text-white px-4 py-2 flex justify-between items-center">
						<span class="font-bold" v-text="comment.user.name"></span>
						<span class="text-sm" v-text="comment.created_at"></span>
					</div>
					<div class="px-4 py-2">
						<p class="mb-2" v-text="comment.content"></p>
						<button class="btn btn-red btn-sm">Remove</button>
					</div>
				</div>
			</div>
			<div class="p-6">
				<form @submit.prevent="add">
					<textarea class="form-input mb-4" rows="5" v-model="form.content"></textarea>
					<div class="flex justify-between items-center">
						<span class="animate-spin h-5 w-5"></span>
						<div>
							<button class="btn btn-blue font-bold">Add</button>
							<button type="button" class="btn btn-secondary" @click="close">Close</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		computed: mapState("photo", ["photo"]),
		data() {
			return {
				comments: {
					data: []
				},
				form: {},
				active: false,
				loading: false
			}
		},
		created() {
			this.get()
		},
		methods: {
			async get(page = 1) {
				this.active = false

				let response = await axios.get(`/api/photos/${this.photo.id}/comments?page=${page}`)

				let { data, ...rest } = response.data

				// this.comments = {
				// 	data: [...this.comments.data, ...data],
				// 	...rest
				// }

				this.comments = {
					data: this.comments.data.concat(data),
					...rest
				}

				if(this.comments.current_page < this.comments.last_page) this.active = true
			},
			async add() {
				let response = await axios.post(`/api/photos/${this.photo.id}/comments`, this.form)

				this.comments.data.push(response.data)

				this.form = {}
			},
			close() {
				this.$store.commit("photo/view", null)
			},
			scroll(e) {
				// if(e.target.scrollHeight - e.target.clientHeight == e.target.scrollTop) {
				// 	console.log("load")

				// 	this.get(this.comments.current_page + 1)
				// }

				console.log("scrolling")

				if(e.target.scrollTop / (e.target.scrollHeight - e.target.clientHeight) >= .7) {
					console.log("load")

					this.get(this.comments.current_page + 1)
				}
			},
			async subscribe() {
				this.loading = true

				await axios.post(`/api/photos/${this.photo.id}/subscribe`)

				this.loading = false

				this.photo.subscribed = ! this.photo.subscribed
			}
		}
	}
</script>

<style scoped>
	.comment:not(:last-child) {
		margin-bottom: 1.5rem;
	}
</style>