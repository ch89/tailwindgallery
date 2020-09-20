<template>
	<form @submit.prevent="register">
		<div class="mb-4">
			<label for="name" class="form-label">Name</label>
			<input type="text" id="name" class="form-input" v-model="form.name">
		</div>
		<div class="mb-4">
			<label for="email" class="form-label">Email</label>
			<input type="email" id="email" class="form-input" v-model="form.email">
		</div>
		<div class="mb-4">
			<label for="password" class="form-label">Password</label>
			<input type="password" id="password" class="form-input" v-model="form.password">
		</div>
		<button class="btn btn-blue">Register</button>
	</form>
</template>

<script>
	export default {
		data() {
			return {
				form: {}
			}
		},
		methods: {
			register() {
				this.$store.dispatch("auth/register", this.form)
					.then(() => this.$router.push("/photos"))
					.catch(errors => console.log(errors))
			}
		}
	}
</script>