<!-- <template>
	<div class="absolute z-50 inset-0 bg-black bg-opacity-50 flex justify-center items-center">
		<div class="bg-white rounded-lg w-1/3">
			<div class="flex justify-between items-center p-6">
				<h3 class="font-bold text-lg" v-text="photo.title"></h3>
				<button class="focus:outline-none" @click="close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="border-t border-b max-h-lg overflow-auto p-6">
				<div class="comment shadow rounded overflow-hidden" v-for="comment in photo.comments" :key="comment.id">
					<div class="bg-gray-800 text-white px-4 py-2 flex justify-between items-center">
						<span class="font-bold" v-text="comment.user.name"></span>
						<span class="text-sm" v-text="comment.created_at"></span>
					</div>
					<div class="px-4 py-2">
						<p class="mb-2" v-text="comment.content"></p>
						<button class="btn btn-red btn-sm" @click="remove(comment)">Remove</button>
					</div>
				</div>
			</div>
			<div class="p-6">
				<form @submit.prevent="add">
					<textarea class="form-input mb-4" rows="5" placeholder="Leave a comment" v-model="form.content"></textarea>
					<div class="flex justify-end">
						<button class="btn btn-blue mr-2">Add</button>
						<button class="btn btn-secondary" @click="close">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		data() {
			return {
				form: {}
			}
		},
		computed: mapState("photo", ["photo"]),
		methods: {
			async add() {
				let response = await axios.post(`/api/photos/${this.photo.id}/comments`, this.form)

				this.photo.comments.push(response.data)

				this.form = {}
			},
			async remove(comment) {
				await axios.delete(`/api/comments/${comment.id}`)

				this.photo.comments.remove(comment)
			},
			close() {
				this.$store.commit("photo/view", null)
			}
		}
	}
</script>

<style scoped>
	.comment:not(:last-child) {
		margin-bottom: 1.5rem;
	}
</style> -->

<!-- Pagination -->
<!-- <template>
	<div class="absolute z-50 inset-0 bg-black bg-opacity-50 flex justify-center items-center">
		<div class="bg-white rounded-lg w-1/3">
			<div class="flex justify-between items-center p-6">
				<h3 class="font-bold text-lg" v-text="photo.title"></h3>
				<button class="focus:outline-none" @click="close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="border-t border-b max-h-lg overflow-auto p-6">
				<div class="comment shadow rounded overflow-hidden" v-for="comment in comments.data" :key="comment.id">
					<div class="bg-gray-800 text-white px-4 py-2 flex justify-between items-center">
						<span class="font-bold" v-text="comment.user.name"></span>
						<span class="text-sm" v-text="comment.created_at"></span>
					</div>
					<div class="px-4 py-2">
						<p class="mb-2" v-text="comment.content"></p>
						<button class="btn btn-red btn-sm" @click="remove(comment)">Remove</button>
					</div>
				</div>

				<nav class="border rounded inline-block" v-if="comments.last_page > 1">
					<ul class="flex">
						<li>
							<a href="#" class="block px-4 py-2 hover:bg-gray-200" :class="{ 'text-gray-500 pointer-events-none': comments.current_page == 1 || loading }" @click.prevent="get(comments.current_page - 1)">Previous</a>
						</li>
						<li>
							<a href="#" class="block px-4 py-2 border-l hover:bg-gray-200" :class="{ 'text-gray-500 pointer-events-none': comments.current_page == comments.last_page || loading }" @click.prevent="get(comments.current_page + 1)">Next</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="p-6">
				<form @submit.prevent="add">
					<textarea class="form-input mb-4" rows="5" placeholder="Leave a comment" v-model="form.content"></textarea>
					<div class="flex justify-end">
						<button class="btn btn-blue mr-2">Add</button>
						<button class="btn btn-secondary" @click="close">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		data() {
			return {
				comments: {
					data: []
				},
				form: {},
				loading: false
			}
		},
		computed: mapState("photo", ["photo"]),
		created() {
			this.get()
		},
		methods: {
			async get(page = 1) {
				this.loading = true

				let response = await axios.get(`/api/photos/${this.photo.id}/comments?page=${page}`)

				this.loading = false

				this.comments = response.data
			},
			async add() {
				let response = await axios.post(`/api/photos/${this.photo.id}/comments`, this.form)

				this.comments.data.push(response.data)

				this.form = {}
			},
			async remove(comment) {
				await axios.delete(`/api/comments/${comment.id}`)
				
				this.comments.data.remove(comment)
			},
			close() {
				this.$store.commit("photo/view", null)
			}
		}
	}
</script>

<style scoped>
	.comment:not(:last-child) {
		margin-bottom: 1.5rem;
	}
</style> -->

<!-- Infinite scroll -->
<template>
	<div class="absolute z-10 inset-0 bg-black bg-opacity-50 flex justify-center items-center">
		<div class="bg-white rounded-lg w-1/3">
			<div class="flex justify-between items-center p-6">
				<div class="flex items-center">
					<h3 class="font-bold text-lg mr-4">{{ photo.title }} by {{ photo.user.name }}</h3>
					<button class="btn btn-sm" :class="photo.subscribed ? 'btn-blue' : 'btn-secondary'" @click="subscribe">Subscribe</button>
				</div>
				<button class="focus:outline-none" @click="close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="border-t border-b max-h-lg overflow-auto scroll-smooth p-6" v-on="active ? { scroll } : {}">
				<!-- <a href="#comment-39">To comment 39</a> -->

				<div class="comment shadow rounded overflow-hidden" v-for="comment in comments.data" :key="comment.id" :id="`comment-${comment.id}`">
					<div class="text-white px-4 py-2 flex justify-between items-center transition duration-1000" :class="comment.id == photo.comment_id ? 'bg-green-500' : 'bg-gray-800'">
						<span class="font-bold" v-text="comment.user.name"></span>
						<span class="text-sm" v-text="comment.created_at"></span>
					</div>
					<div class="px-4 py-2">
						<p class="mb-2" v-text="comment.content"></p>
						<button class="btn btn-red btn-sm" @click="remove(comment)" v-if="comment.can.delete">Remove</button>
						<button class="btn btn-green btn-sm" @click="best(comment)" v-if="photo.can.update">Best</button>
					</div>
				</div>
			</div>
			<div class="p-6">
				<form @submit.prevent="add">
					<textarea class="form-input mb-4" rows="5" placeholder="Leave a comment" v-model="form.content"></textarea>
					<div class="flex justify-end">
						<button class="btn btn-blue mr-2">Add</button>
						<button class="btn btn-secondary" @click="close">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		data() {
			return {
				comments: {
					data: []
				},
				form: {},
				active: false
			}
		},
		computed: mapState("photo", ["photo"]),
		created() {
			this.get()
		},
		methods: {
			async get(page = 1) {
				this.active = false

				let response = await axios.get(`/api/photos/${this.photo.id}/comments?page=${page}`)

				let { data, ...rest } = response.data

				this.comments = {
					data: [...this.comments.data, ...data],
					...rest
				}

				if(this.comments.current_page < this.comments.last_page) this.active = true
			},
			async add() {
				let response = await axios.post(`/api/photos/${this.photo.id}/comments`, this.form)

				this.comments.data.push(response.data)

				this.form = {}
			},
			async remove(comment) {
				await axios.delete(`/api/comments/${comment.id}`)
				
				this.comments.data.remove(comment)
			},
			close() {
				this.$store.commit("photo/view", null)
			},
			async best(comment) {
				await axios.put(`/api/comments/${comment.id}`)

				this.photo.comment_id = comment.id

				this.$flash.success(`Comment ${comment.id} marked as best reply`)
			},
			async subscribe() {
				await axios.post(`/api/photos/${this.photo.id}/subscribe`)

				this.photo.subscribed = ! this.photo.subscribed

				this.$flash.success(`Subscribed to ${this.photo.title}`)
			},
			scroll(e) {
				// if(e.target.scrollHeight - e.target.clientHeight == e.target.scrollTop) {
				// 	this.get(this.comments.current_page + 1)
				// }

				if(e.target.scrollTop / (e.target.scrollHeight - e.target.clientHeight) >= .7) {
					this.get(this.comments.current_page + 1)
				}
			}
		}
	}
</script>

<style scoped>
	.comment:not(:last-child) {
		margin-bottom: 1.5rem;
	}
</style>