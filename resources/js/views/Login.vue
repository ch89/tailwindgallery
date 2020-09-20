<template>
	<form @submit.prevent="login">
		<div class="mb-4">
			<label for="email" class="form-label">Email</label>
			<input type="email" id="email" class="form-input" v-model="form.email">
		</div>
		<div class="mb-4">
			<label for="password" class="form-label">Password</label>
			<input type="password" id="password" class="form-input" v-model="form.password">
		</div>
		<button class="btn btn-blue">Login</button>
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
			login() {
				this.$store.dispatch("auth/login", this.form)
					.then(() => this.$router.push("/photos"))
					.catch(errors => console.log(errors))
			}
		}
	}
</script>