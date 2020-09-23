<template>
	<div>
		<table class="shadow rounded overflow-hidden w-full mb-4">
			<thead>
				<tr class="bg-gray-800 text-white text-left">
					<!-- <th class="p-4">
						<a href="#" @click.prevent="sort('name')">Name</a>
						<i class="fas ml-2" :class="direction == 1 ? 'fa-angle-up' : 'fa-angle-down'" v-show="key == 'name'"></i>
					</th>
					<th class="p-4">
						<a href="#" @click.prevent="sort('color')">Color</a>
						<i class="fas ml-2" :class="direction == 1 ? 'fa-angle-up' : 'fa-angle-down'" v-show="key == 'color'"></i>
					</th> -->

					<th class="p-4" v-for="key in keys">
						<a href="#" @click.prevent="sort(key)" v-text="capitalize(key)"></a>
						<i class="fas ml-2" :class="direction == 1 ? 'fa-angle-up' : 'fa-angle-down'" v-show="$data.key == key"></i>
					</th>
					<th class="p-4">Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr class="bg-white even:bg-gray-100" v-show="show">
					<td class="p-4">
						<input type="text" class="form-input" v-model="form.create.name">
					</td>
					<td class="p-4">
						<input type="color" v-model="form.create.color">
					</td>
					<td class="p-4">
						<button class="btn btn-blue btn-sm" @click="add">Add</button>
						<button class="btn btn-red btn-sm" @click="close">Close</button>
					</td>
				</tr>
				<tr v-for="channel in orderedChannels" v-if="$data.channel == channel" class="bg-white even:bg-gray-100">
					<td class="p-4">
						<input type="text" class="form-input" v-model="form.edit.name">
					</td>
					<td class="p-4">
						<input type="color" v-model="form.edit.color">
					</td>
					<td class="p-4">
						<button class="btn btn-blue btn-sm" @click="update">Update</button>
						<button class="btn btn-red btn-sm" @click="cancel">Cancel</button>
					</td>
				</tr>
				<tr v-else class="bg-white even:bg-gray-100">
					<td v-text="channel.name" class="p-4"></td>
					<td class="p-4">
						<button class="btn btn-sm" :style="{ 'background-color': channel.color }" v-text="channel.color"></button>
					</td>
					<td class="p-4">
						<button class="btn btn-blue btn-sm" @click="edit(channel)">Edit</button>
						<button class="btn btn-red btn-sm" @click="remove(channel)">Remove</button>
					</td>
				</tr>
			</tbody>
		</table>

		<button class="btn btn-blue" @click="show = true">New</button>
	</div>
</template>

<!-- <script>
	export default {
		data() {
			return {
				channels: [],
				channel: null,
				show: false,
				form: {
					create: {},
					edit: {}
				}
			}
		},
		created() {
			axios.get("/api/channels")
				.then(response => this.channels = response.data)
		},
		methods: {
			add() {
				axios.post("/api/channels", this.form.create)
					.then(response => {
						this.channels.push(response.data)

						this.close()
					})
			},
			close() {
				this.show = false
				this.form.create = {}
			},
			edit(channel) {
				this.channel = channel
				this.form.edit = Object.assign({}, channel)
			},
			cancel() {
				this.channel = null
				this.form.edit = {}
			},
			update() {
				axios.put(`/api/channels/${this.channel.id}`, this.form.edit)
					.then(response => {
						Object.assign(this.channel, response.data)

						this.cancel()
					})
			},
			remove(channel) {
				axios.delete(`/api/channels/${channel.id}`)
					.then(() => this.channels.splice(this.channels.indexOf(channel), 1))
			}
		}
	}
</script> -->

<!-- Using vuex -->
<script>
	import { mapState } from "vuex"

	export default {
		data() {
			return {
				channel: null,
				show: false,
				form: {
					create: { color: "#000000" },
					edit: {}
				},
				key: "",
				direction: 1,
				keys: ["name", "color"]
			}
		},
		computed: {
			...mapState("channel", ["channels"]),
			orderedChannels() {
				return this.channels.slice().sort((a, b) => {
					a = a[this.key]
					b = b[this.key]

					return (a > b ? 1 : a < b ? -1 : 0) * this.direction
				})
			}
		},
		methods: {
			add() {
				axios.post("/api/channels", this.form.create)
					.then(response => {
						this.$store.commit("channel/add", response.data)

						this.$flash.success("Channel created")

						this.close()
					})
			},
			close() {
				this.show = false
				this.form.create = { color: "#000000" }
			},
			edit(channel) {
				this.channel = channel
				this.form.edit = Object.assign({}, channel)
			},
			cancel() {
				this.channel = null
				this.form.edit = {}
			},
			update() {
				axios.put(`/api/channels/${this.channel.id}`, this.form.edit)
					.then(response => {
						Object.assign(this.channel, response.data)

						this.cancel()
					})
			},
			remove(channel) {
				axios.delete(`/api/channels/${channel.id}`)
					.then(() => {
						this.$store.commit("channel/remove", channel)

						this.$flash.success(`Channel ${channel.name} removed`)
					})
			},
			sort(key) {
				this.direction = this.key == key ? this.direction * -1 : 1

				this.key = key
			},
			capitalize(key) {
				return key[0].toUpperCase() + key.slice(1)
			}
		}
	}
</script>