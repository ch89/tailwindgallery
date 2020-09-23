<template>
	<ul class="border rounded">
		<li class="flex justify-between items-center p-4" v-for="user in users">
			<span v-text="user.name"></span>
			<button class="btn btn-sm" :class="user.followed ? 'btn-blue' : 'btn-secondary'" @click="follow(user)">Follow</button>
		</li>
	</ul>
</template>

<script>
	export default {
		data() {
			return {
				users: []
			}
		},
		async beforeRouteEnter(to, from, next) {
			let response = await axios.get("/api/users")

			next(vm => vm.users = response.data)
		},
		methods: {
			async follow(user) {
				await axios.post(`/api/users/${user.id}/follow`)

				user.followed = ! user.followed

				this.$flash.success(`Your are now following ${user.name}`)
			}
		}
	}
</script>