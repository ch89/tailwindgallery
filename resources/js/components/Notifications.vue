<template>
	<div>
		<a href="#" class="h-full flex items-center p-6" @click.prevent="show = ! show">
			<i class="fas fa-bell"></i>
			<span class="inline-block bg-red-500 text-white rounded-full text-xs leading-none px-2 py-1" v-if="notifications.length" v-text="notifications.length"></span>
		</a>
		<transition name="notifications">
			<div class="absolute shadow-md rounded-md overflow-hidden" v-show="show">
				<div class="bg-gray-800 text-white flex justify-between items-center p-4">
					<span class="font-bold">Notifications</span>
					<a href="#" class="hover:underline" @click.prevent="markAsRead">Mark all as read</a>
				</div>
				<div class="bg-white odd:bg-gray-100 flex items-center p-4" v-for="notification in notifications">
					<img src="/images/avatar2.jpg" alt="Avatar" class="w-12 rounded-full mr-4">
					<div>
						<component :is="notification.type" :notification="notification"></component>
						<span class="text-gray-600 text-sm">2 hours ago</span>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
	import PhotoLiked from "./notifications/PhotoLiked"
	import PhotoRated from "./notifications/PhotoRated"
	import PhotoCommented from "./notifications/PhotoCommented"

	export default {
		components: { PhotoLiked, PhotoRated, PhotoCommented },
		data() {
			return {
				notifications: [],
				show: false
			}
		},
		async created() {
			let response = await axios.get("/api/notifications")

			this.notifications = response.data
		},
		methods: {
			async markAsRead() {
				await axios.put("/api/notifications")

				this.notifications = []
			}
		}
	}
</script>

<style scoped>
	.notifications-enter-active, .notifications-leave-active {
		transition: .5s;
	}

	.notifications-enter, .notifications-leave-to {
		opacity: 0;
		transform: scale(1.1);
	}
</style>