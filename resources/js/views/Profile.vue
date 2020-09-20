<template>
	<div>
		<h1 class="font-bold text-xl mb-4">Profile {{ user.name }}</h1>

		<form @submit.prevent="update">
			<div class="mb-4">
				<label for="name" class="form-label">Name</label>
				<input type="text" class="form-input" id="name" name="name" :value="user.name">
			</div>
			<div class="mb-4">
				<label for="avatar" class="form-label">Avatar</label>
				<input type="file" class="block w-full" id="image" name="avatar">
			</div>
			<button class="btn btn-blue">Update</button>
		</form>
	</div>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		computed: mapState("auth", ["user"]),
		methods: {
			update(e) {
				this.$store.dispatch("auth/profile", new FormData(e.target))
			}
		}
	}
</script>