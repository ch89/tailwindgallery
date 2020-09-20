<template>
	<!-- <nav class="shadow-md sticky">
		<div class="container mx-auto md:flex">
			<div class="flex justify-between">
				<a href="#" class="block p-6">
					<img src="/images/logo.png" alt="Logo" class="h-8">
				</a>
				<button class="block p-6 focus:outline-none md:hidden" @click="show = ! show">
					<i class="fas fa-bars"></i>
				</button>
			</div>
			<ul class="md:flex" :class="show ? 'block' : 'hidden'">
				<li>
					<router-link to="/" class="h-full flex items-center p-6 hover:bg-gray-200">Home</router-link>
				</li>
				<li>
					<router-link to="/photos" class="h-full flex items-center p-6 hover:bg-gray-200">Photos</router-link>
				</li>
			</ul>
		</div>
	</nav> -->

	<!-- <nav class="shadow-md">
		<div class="container mx-auto md:flex">
			<div class="flex justify-between">
				<a href="#" class="block p-6">
					<img src="/images/logo.png" alt="Logo" class="h-8">
				</a>
				<button class="block p-6 md:hidden" @click="show = ! show">
					<i class="fas fa-bars"></i>
				</button>
			</div>
			<div class="md:flex" :class="show ? 'block' : 'hidden'">
				<a href="#" class="flex items-center p-6 hover:bg-gray-200">Home</a>
				<a href="#" class="flex items-center p-6 hover:bg-gray-200">About</a>
				<a href="#" class="flex items-center p-6 hover:bg-gray-200">Contact</a>
				<a href="#" class="flex items-center p-6 hover:bg-gray-200">Support</a>
			</div>
		</div>
	</nav> -->

	<!-- <nav class="shadow-md">
		<div class="container mx-auto md:flex">
			<div class="flex justify-between">
				<a href="#" class="block p-6">
					<img src="/images/logo.png" alt="Logo" class="h-8">
				</a>
				<button class="block p-6 focus:outline-none md:hidden" @click="show = ! show">
					<i class="fas fa-bars"></i>
				</button>
			</div>
			<div class="md:flex-1 md:flex md:justify-between" :class="show ? 'block' : 'hidden'">
				<div class="md:flex">
					<a href="#" class="flex items-center p-6 hover:bg-gray-200">Home</a>
					<a href="#" class="flex items-center p-6 hover:bg-gray-200">About</a>
					<a href="#" class="flex items-center p-6 hover:bg-gray-200">Contact</a>
					<a href="#" class="flex items-center p-6 hover:bg-gray-200">Support</a>
				</div>
				<div class="flex items-center">
					<div class="relative">
						<a href="#" class="flex items-center">
							<img src="/images/avatar2.jpg" alt="Avatar" class="h-8 rounded-full">
							<span class="font-semibold ml-4">Jane Doe</span>
						</a>
						<div class="absolute z-10 w-48 shadow-md rounded-md overflow-hidden bg-white mt-2">
							<a href="#" class="block p-6 hover:bg-gray-200">Settings</a>
							<a href="#" class="block p-6 hover:bg-gray-200">Sign out</a>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</nav> -->

	<nav class="shadow-md sticky">
		<div class="container mx-auto md:flex">
			<div class="flex justify-between">
				<a href="#" class="block p-6">
					<img src="/images/logo.png" alt="Logo" class="h-8">
				</a>
				<button class="block p-6 focus:outline-none md:hidden" @click="show = ! show">
					<i class="fas fa-bars"></i>
				</button>
			</div>
			<div class="md:flex-1 md:flex md:justify-between" :class="show ? 'block' : 'hidden'">
				<div class="md:flex">
					<router-link to="/" class="flex items-center p-6 hover:bg-gray-200">Home</router-link>
					<template v-if="user">
						<router-link to="/photos" class="flex items-center p-6 hover:bg-gray-200">Photos</router-link>
						<a href="#" class="flex items-center p-6 hover:bg-gray-200" @click.prevent="$emit('modal')">Create</a>
						<router-link to="/channels" class="flex items-center p-6 hover:bg-gray-200">Channels</router-link>
					</template>
				</div>
				<div class="md:flex">
					<div v-if="user" class="relative">
						<a href="#" @click="dropdown = ! dropdown" class="h-full flex items-center p-6">
							<img :src="user.avatar" alt="Avatar" class="w-8 h-8 rounded-full">
							<span class="ml-4 font-semibold">{{ user.name }}</span>
						</a>
						<div class="absolute z-50 shadow-md rounded-md overflow-hidden bg-white w-48" :class="dropdown ? 'block' : 'hidden'">
							<router-link to="/profile" class="block p-6 hover:bg-gray-200">Profile</router-link>
							<a href="#" class="block p-6 hover:bg-gray-200" @click.prevent="logout">Sign out</a>
						</div>
					</div>
					<template v-else>
						<router-link to="/login" class="flex items-center p-6 hover:bg-gray-200">Login</router-link>
						<router-link to="/register" class="flex items-center p-6 hover:bg-gray-200">Register</router-link>
					</template>
				</div>
			</div>
		</div>
	</nav>
</template>

<script>
	import { mapState, mapActions } from "vuex"

	export default {
		computed: mapState("auth", ["user"]),
		methods: {
			// ...mapActions("auth", ["logout"]),
			async logout() {
				await this.$store.dispatch("auth/logout")

				if(this.$route.meta.auth) this.$router.push({ name: "home" })
			}
		},
		data() {
			return {
				show: false,
				dropdown: false
			}
		}
	}
</script>