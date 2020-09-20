<template>
	<div class="shadow-md rounded overflow-hidden">
		<div class="relative">
			<img :src="photo.image" alt="Photo" class="w-full">
			<img src="/images/avatar2.jpg" alt="Avatar" class="absolute right-5 transform -translate-y-1/2 w-1/4 rounded-full border-4 border-white">
			<router-link :to="{ query: { channel_id: photo.channel.id } }" class="btn font-bold absolute bottom-5 left-5" :style="{ 'background-color': photo.channel.color }" v-text="photo.channel.name"></router-link>
		</div>
		<div class="p-6">
			<h3 class="font-bold text-lg mb-2">{{ photo.title }}</h3>
			<p class="text-gray-600 truncate mb-3">{{ photo.content }}</p>
			<button class="btn btn-red btn-sm" @click="remove(photo)">Remove</button>
		</div>
	</div>
</template>

<script>
	import { mapActions } from "vuex"

	export default {
		props: ["photo"],
		methods: mapActions(["remove"])
	}
</script>